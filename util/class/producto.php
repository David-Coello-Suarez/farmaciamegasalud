<?
include_once("../system/conexion.php");
include_once("../system/Funciones.php");

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

    public function ListarProducto()
    {
        $sql = "SELECT DISTINCT c.id, c.nombre
        FROM ProductosCategorias AS pc
        INNER JOIN Categorias AS c
        ON pc.idcategoria = c.id LIMIT 5";


        $categorias = $this->conexion->DBConsulta($sql, false, array(0));

        if (count($categorias) > 0) {
            $data = array();

            foreach ($categorias as $item) {
                $idcategoria = intval($item['id']);

                $sqlInt = "SELECT p.*
                FROM ProductosCategorias AS pc
                INNER JOIN Productos AS p
                ON pc.idproducto = p.id
                WHERE pc.idcategoria = ? AND p.estado = ? LIMIT 10";

                $productos = $this->conexion->DBConsulta($sqlInt, false, array($idcategoria, 1));

                if (count($productos) > 0) {
                    foreach ($productos as $itemInt) {

                        $itemInt['descuento'] = ceil($itemInt['descuento'] * 100);
                        $itemInt['precionormal'] = number_format($itemInt['precionormal'], 2);
                        $itemInt['precioUnitPromo'] = number_format($itemInt['precioUnitPromo'], 2);

                        $item['productos'][] = $itemInt;
                    }
                } else {
                    $item['productos'] = "No hay producto para la categoria";
                }

                $data['categoria'][] = $item;
            }

            return Funciones::RespuestaJson(1, "", $data);
        } else {
            return Funciones::RespuestaJson(2, "No hay categorias disponible");
        }
    }
}
