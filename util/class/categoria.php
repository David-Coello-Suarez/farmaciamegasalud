<?
include_once("../system/conexion.php");
include_once("../system/Funciones.php");
include_once("parametroswb.php");

if (file_exists("../../config.php")) {
    include_once("../../config.php");
} else {
    include_once("../../../config.php");
}

class Categorias
{
    private $conexion;
    private $producto;

    public function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion->DBConexion();

        $this->producto = new Parametros();
    }

    public function ListarCategoriasWeb()
    {
        $categoria = $this->conexion->DBConsulta("SELECT id, nombre FROM Categorias WHERE estado = ?", false, array(1));
        if (count($categoria) > 0) {
            return Funciones::RespuestaJson(1, "", $categoria);
        } else {
            return Funciones::RespuestaJson(2, "No hay data para mostrar");
        }
    }

    public function ProductosCategoria($id, $pagina = 1, $limite)
    {
        // MUESTRA EL NUMERO DE ITEMS POR PAGINA
        $itemsPages = ($limite);

        // CALCULO PARA OBTENER EL NUMERO DE ITEMS A PARTIR DE DONDE MOSTRAR
        $inicio = intval(intval($pagina - 1) * $itemsPages);

        // OBTENGO EL TOTAL DE ITEMS
        $query = "SELECT pc.idproducto 
        FROM ProductosCategorias AS pc
        INNER JOIN Productos AS p
        ON pc.idproducto = p.id
        WHERE pc.idcategoria = ?
        AND p.estado = 1 ";

        $productos = $this->conexion->DBConsulta($query, false, array($id));

        // OBTENGO LOS ITEMS PAGINADOS
        if ($limite > 0) {
            $query .= " LIMIT $inicio, $itemsPages";
        }
        
        $dataProductos = $this->conexion->DBConsulta($query, false, array($id));

        if (count($dataProductos) > 0) {
            $producto = array();
            $cont = 0;
            foreach ($dataProductos as $item) {
                $idp = intval($item['idproducto']);
                $items = $this->conexion->DBConsulta("SELECT * FROM Productos WHERE id = $idp AND estado = 1 AND stock > 0");

                if ($items) {
                    $items['precioDescue'] = number_format($items['precioDescue'], 2);
                    $items['precionormal'] = number_format($items['precionormal'], 2);

                    $items['id'] = intval($items['id']);
                    $items['combo'] = intval($items['combo']);
                    $items['codigo'] = intval($items['codigo']);
                    $items['descuento'] = ceil($items['descuento'] * 100);

                    $producto[] = $items;
                    $cont++;
                }
            }

            // DATAS PRODUCTOS
            $data['productos'] = $producto;

            // PAGINACION DE LA TABLA
            $data['paginacion'] = Funciones::Paginacion(count($productos), $itemsPages, $pagina);

            // MOSTRANDO TOTAL DE ITEMS
            $inicioI = $pagina;
            $text = "página";
            if ($pagina > 1) {
                $text = "páginas";
                $inicioI = $pagina . "0";
            }
            $data['mostrando'] = "Mostrando $inicioI al " . ($cont) . " de " . count($productos) . " (" . intval(ceil(count($productos) / $itemsPages)) . " $text)";

            return Funciones::RespuestaJson(1, "", $data);
        } else {
            return Funciones::RespuestaJson(2, "No hay productos para esa categoria");
        }
    }

    public function ItemsProductos($param)
    {
        // MUESTRA EL NUMERO DE ITEMS POR PAGINA
        $paramswb = $this->producto->ParametrosWeb();
        $itemsPageswb = intval($paramswb[$param]);

        return $itemsPageswb;
    }
}
