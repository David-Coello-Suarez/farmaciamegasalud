<?
include_once("../system/conexion.php");
include_once("../system/Funciones.php");

if (file_exists("../../config.php")) {
    include_once("../../config.php");
} else {
    include_once("../../../config.php");
}

class Carrito
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion->DBConexion();
    }

    public function GuardarProductoCarrito($idproducto)
    {
        $stock = $this->conexion->DBConsulta("SELECT stock FROM Productos WHERE id = $idproducto", false);

        if (intval($stock['stock']) > 0) {

            session_start();
            $idusuario = session_id();

            $existeItem = $this->conexion->DBConsulta("SELECT cantidad, id FROM Carrito WHERE idproducto = $idproducto AND idusuario = '$idusuario'", false);

            if ($existeItem) {
                return Funciones::RespuestaJson(2, "Ya tiene un producto", $existeItem);
            } else {
                $guardar = $this->conexion->DBConsulta("INSERT INTO Carrito (idproducto, idusuario) VALUES (?,?)", true, array($idproducto, session_id()));

                if ($guardar) {
                    return Funciones::RespuestaJson(1, "Añadido");
                } else {
                    return Funciones::RespuestaJson(2, "Error al añadir");
                }
            }
        } else {
            return Funciones::RespuestaJson(2, "Stock no disponible");
        }
    }

    public function ObtenerProductoCarrito()
    {
        session_start();

        $sql = "SELECT c.cantidad, c.id AS idcarrito, ct.nombre as categoria, p.* 
        FROM Carrito AS c 
        INNER JOIN Productos AS p 
        ON c.idproducto = p.id 
        INNER JOIN ProductosCategorias AS pc 
        ON p.id = pc.idproducto 
        INNER JOIN Categorias AS ct ON pc.idcategoria = ct.id 
        WHERE c.idusuario = ?";

        $obtenerCarrito = $this->conexion->DBConsulta($sql, false, array(session_id()));

        if ($obtenerCarrito) {
            $data = array();
            $subtotal = 0;
            foreach ($obtenerCarrito as $item) {

                // $ptotal = number_format((number_format($item['precio'], 2) * intval($item['cantidad'])), 2);

                // $item['ptotal'] = $ptotal;

                // $subtotal += $ptotal;

                $subtotalItem = 0;

                if ( intval($item['cantidad']) >= intval($item['combo'])) {

                    $subtotalItem = number_format($item['precioUnitPromo'], 2) * intval($item['cantidad']);

                    // $precioTotal = number_format($subtotalItem, 2);

                    // $subtotal += $precioTotal;

                    $item['aplicaOferta'] = true;

                    //UNIFICANDO DATOS
                    $item['precio'] = number_format($item['precioUnitPromo'], 2);
                    $item['ptotal'] = number_format($subtotalItem, 2);
                } else {
                    $subtotalItem = number_format($item['precionormal'], 2) * intval($item['cantidad']);

                    // $precioTotal = number_format($subtotalItem, 2);

                    // $subtotal += $precioTotal;

                    $item['aplicaOferta'] = false;

                    //UNIFICANDO DATOS
                    $item['precio'] = number_format($item['precionormal'], 2);
                    $item['ptotal'] = number_format($subtotalItem, 2);
                }

                $precioTotal = number_format($subtotalItem, 2);
                $subtotal += $precioTotal;

                $data['carrito'][] = $item;
            }
            $data['subtotal'] = number_format($subtotal, 2);
            $data['iva'] = 12;
            $data['ivaSumado'] = number_format(($subtotal * 0.12), 2);
            $data['total'] =  number_format((($subtotal * 0.12) + $subtotal), 2);

            return Funciones::RespuestaJson(1, "", $data);
        } else {
            return Funciones::RespuestaJson(2, "Error al añadir");
        }
    }

    public function ActualizarCarrito($idcarrito, $cantidad)
    {
        $stockDisponible = $this->conexion->DBConsulta("SELECT pt.stock FROM Carrito AS ct INNER JOIN Productos AS pt ON ct.idproducto = pt.id WHERE ct.id = $idcarrito", false);

        if ($stockDisponible) {
            if (intval($stockDisponible['stock']) > 0) {
                if (($cantidad <= intval($stockDisponible['stock']))) {
                    $actualizarCantidad = $this->conexion->DBConsulta("UPDATE Carrito SET cantidad = ? WHERE id = ?", true, array($cantidad, $idcarrito));

                    if ($actualizarCantidad) {
                        return Funciones::RespuestaJson(1);
                    } else {
                        return Funciones::RespuestaJson(2, "No se pudo actualizar la cantidad del producto");
                    }
                } else {
                    return Funciones::RespuestaJson(2, "No se puede superar el stock disponible, stock disponible: '" . (intval($stockDisponible['stock'])) . "'");
                }
            } else {
                return Funciones::RespuestaJson(2, "Stock no disponible");
            }
        } else {
            return Funciones::RespuestaJson(2, "No existe carrito con ese id");
        }
    }

    public function EliminarCarritoProducto($idcarrito)
    {
        session_start();
        $eliminar = $this->conexion->DBConsulta("DELETE FROM Carrito WHERE id = ? AND idusuario = ?", true, array($idcarrito, session_id()));

        if ($eliminar) {
            return Funciones::RespuestaJson(1);
        } else {
            return Funciones::RespuestaJson(2, "Error al quitar el producto");
        }
    }
}
