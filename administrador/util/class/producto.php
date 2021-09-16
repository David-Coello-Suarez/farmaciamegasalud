<?
include_once("../funciones/conexion.php");
include_once("../funciones/Funciones.php");

if (file_exists("../../config.php")) {
    include_once("../../config.php");
} else {
    include_once("../../../config.php");
}

class Producto
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion->DBConexion();
    }

    public function CrearProductos($datos, $img)
    {
        $totalExisto = 0;
        $sqlInsert = "INSERT INTO Productos(codigo,nombre,stock,combo,precionormal,descuento,precioDescue,precioUnitPromo) 
                    VALUES(?,?,?,?,?,?,?,?)";

        $productoRepetidos = array();

        for ($i = 0; $i < count($datos['codigo']); $i++) {

            $codigo = intval($datos['codigo'][$i]);

            $existeCodigo = $this->conexion->DBConsulta("SELECT codigo FROM Productos WHERE codigo = $codigo", false);

            if ($existeCodigo) {
                $productoRepetidos[] = $existeCodigo;
            } else {
                $subtotal = ($datos['pvp'][$i]) * intval($datos['combo'][$i]);
                $descuento = ($datos['descuento'][$i] / 100);
                $restarDesc = ($subtotal * $descuento);
                $ofertaFinal = number_format(($subtotal - $restarDesc), 2);

                $subtotalPromo = ($datos['pvp'][$i]) * $descuento;
                $precioUnitPromo = number_format((($datos['pvp'][$i]) - $subtotalPromo), 2);

                $data = array(
                    intval($datos['codigo'][$i]),
                    htmlentities($datos['nombre'][$i]),
                    intval($datos['stock'][$i]),
                    intval($datos['combo'][$i]),
                    number_format(($datos['pvp'][$i]), 2),
                    $descuento,
                    $ofertaFinal,
                    $precioUnitPromo
                );

                $guardarProd = $this->conexion->DBConsulta($sqlInsert, true, $data);

                if ($guardarProd) {
                    $id = $this->conexion->UltimoInsert();
                    $type = $img['image']['type'][$i];
                    $tmpName = $img['image']['tmp_name'][$i];

                    $nombreImg = Funciones::SubirImg("producto", $type, $tmpName, $id);

                    $guardarImg = $this->conexion->DBConsulta("UPDATE Productos SET imagen = ? WHERE id = ?", true, array($nombreImg, $id));

                    if ($guardarImg) {
                        $idcategoria = intval($datos['categoria'][$i]);

                        $guardarCate = $this->conexion->DBConsulta("INSERT INTO ProductosCategorias (idcategoria, idproducto) VALUES (?,?)", true, array($idcategoria, $id));

                        if ($guardarCate) {
                            $totalExisto++;
                        }
                    }
                }
            }
        }

        if ($totalExisto == count($datos['codigo'])) {
            return Funciones::RespuestaJson(1, "Exito al guardar");
        } else if (count($productoRepetidos) > 0) {
            return Funciones::RespuestaJson(2, "Los siguiente productos ya existen", $productoRepetidos);
        } else {
            return Funciones::RespuestaJson(3, "Error al guardar");
        }
    }

    public function ListarProductos($pagina = 1, $itemForPage = 30)
    {
        $sql = "SELECT c.nombre AS categoria, p.*
        FROM ProductosCategorias AS pc
        INNER JOIN Productos AS p
        ON (pc.idproducto = p.id)
        INNER JOIN Categorias AS c
        ON (pc.idcategoria = c.id)";

        $where = 1;

        $totalItems = count($this->conexion->DBConsulta($sql, false, array($where)));

        if ($totalItems > 0) {
            $inicia = intval(($pagina - 1) * $itemForPage);

            $sqlItems = $sql . " LIMIT $inicia, $itemForPage";

            $consultarLimite = $this->conexion->DBConsulta($sqlItems, false, array($where));

            if (count($consultarLimite) > 0) {
                $items = array();
                $cont = $inicia + 1;
                foreach ($consultarLimite as $item) {
                    $item['numeral'] = $cont;

                    if (!file_exists("../../" . $item['imagen'])) {
                        $item['imagen'] = "img/producto/no-producto.png";
                    }

                    $item['precionormal'] = number_format($item['precionormal'], 2);
                    $item['precioDescue'] = number_format($item['precioDescue'], 2);

                    $items[] = $item;
                    $cont++;
                }

                $paginas = intval(ceil($totalItems / $itemForPage));

                $paginasInt = $paginas . ($paginas == 1 ? " Página" : ' Páginas');

                $data['producto'] = $items;
                $data['mostar'] = "Mostrando del " . ($inicia + 1) . " al " . ($cont - 1) . " de " . $totalItems . " ( $paginasInt ) ";
                $data['paginacion'] = Funciones::Paginacion($totalItems, $itemForPage, $pagina);
                return Funciones::RespuestaJson(1, "", $data);
            }
        } else {
            $data['mostar'] = "Mostrando del 0 al 0 de 0 ( 0 Páginas )";
            return Funciones::RespuestaJson(2, "No hay productos para mostrar", $data);
        }
    }

    public function ActualizarEstado($data)
    {
        $estado = $this->conexion->DBConsulta("UPDATE Productos SET estado = ? WHERE codigo = ? AND id = ?", true, array(intval($data['estado']), intval($data['codigo']), intval($data['id'])));

        if ($estado) {
            return Funciones::RespuestaJson(1, "Exito al cambiar de estado");
        } else {
            return Funciones::RespuestaJson(2, "Error al cambiar de estado");
        }
    }

    public function ObtenerProducto($data)
    {
        $id = intval($data['id']);
        $codigo = intval($data['codigo']);

        $sql = "
            SELECT pc.idcategoria, p.*
            FROM Productos AS p 
            INNER JOIN ProductosCategorias AS pc
            ON p.id = pc.idproducto
            WHERE p.codigo = $codigo AND p.id = $id
        ";
        $obtener = $this->conexion->DBConsulta($sql, false);

        if ($obtener) {

            $obtener['precionormal'] = number_format($obtener['precionormal'], 2);
            $obtener['precioDescue'] = number_format($obtener['precioDescue'], 2);

            $desc = 0;
            $entero = ($obtener['descuento'] * 100);
            $longdesc = explode('.', $entero);

            if (count($longdesc) > 1) {
                $desc = number_format(($obtener['descuento'] * 100), 2);
            } else {
                $desc = number_format(($obtener['descuento'] * 100), 0);
            }
            $obtener['descuento'] = $desc;

            $obtener['nombre'] = html_entity_decode($obtener['nombre']);

            return Funciones::RespuestaJson(1, "", $obtener);
        } else {
            return Funciones::RespuestaJson(2, "No hay producto");
        }
    }

    public function ActualziarProducto($datos, $img)
    {
        $i = 0;
        $id = intval($datos['idproducto'][$i]);
        $codigo = intval($datos['codigo'][$i]);

        $sql = "SELECT pc.id, p.imagen
        FROM Productos AS p 
        INNER JOIN ProductosCategorias AS pc
        ON p.id = pc.idproducto
        WHERE p.codigo = $codigo AND p.id = $id";

        $exite = $this->conexion->DBConsulta($sql, false);

        if ($exite) {
            $sql = "UPDATE Productos SET nombre = ?, stock = ?, combo = ?, precionormal = ?, descuento = ?, precioDescue = ?, updatedAt = ?, precioUnitPromo = ?";
            $data = array();

            $nombre = htmlentities($datos['nombre'][$i]);
            $descuento = ($datos['descuento'][$i] / 100);
            $precionormal = number_format(($datos['pvp'][$i]), 2);
            $precioDesc = number_format(($datos['oferta'][$i]), 2);
            $combo = intval($datos['combo'][$i]);
            $stock = intval($datos['stock'][$i]);

            $subtotalPromoUnit = ($precionormal * $descuento);
            $precioUnitPromo = number_format(($precionormal - $subtotalPromoUnit), 2);

            $categoria = intval($datos['categoria'][$i]);

            array_push($data, $nombre, $stock, $combo, $precionormal, $descuento, $precioDesc, date("Y-m-d H:i:s"), $precioUnitPromo);

            if ($img['name'][$i] != "") {

                $eliminaImg = Funciones::EliminarArchivo($exite['imagen']);

                if ($eliminaImg) {
                    $sql .= ", imagen = ?";
                    $data[] = Funciones::SubirImg('producto', $img['type'][$i], $img['tmp_name'][$i], $id);
                } else {
                    $sql .= ", imagen = ?";
                    $data[] = Funciones::SubirImg('producto', $img['type'][$i], $img['tmp_name'][$i], $id);
                }
            }

            $sql .= " WHERE id = ? AND codigo = ?";
            array_push($data, $id, $codigo);

            $actualizar = $this->conexion->DBConsulta($sql, true, $data);

            if ($actualizar) {

                $categoria = $this->conexion->DBConsulta("UPDATE ProductosCategorias SET idcategoria = ? WHERE id = ? AND idproducto = ?", true, array($categoria, intval($exite['id']), $id));

                if ($categoria) {
                    return Funciones::RespuestaJson(1, "Exito");
                } else {
                    return Funciones::RespuestaJson(2, "Error al termino de la actualización");
                }
            } else {
                return Funciones::RespuestaJson(2, "Error");
            }
        }
    }
}
