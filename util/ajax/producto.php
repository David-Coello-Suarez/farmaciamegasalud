<?
include_once("../class/categoria.php");
include_once("../class/producto.php");

$productos = new Categorias();
$productosv2 = new Producto();
$metodo = $_POST['metodo'];

switch ($metodo) {
    case 'LCP':
        $id = intval($_POST['id']);
        $pagina = intval($_POST['pagina']);
        $limite = intval($_POST['limite']);
        $respuesta = $productos->ProductosCategoria($id, $pagina, $limite);
        break;
    case 'CLC':
        $param = $_POST['params'];
        $respuesta = array("estado" => 1, "msg" => "", "data" => array("numero" => $productos->ItemsProductos($param)));
        break;
    case 'LPW':
        $respuesta = $productosv2->ListarProducto();
        break;


    default:
        $respuesta = array("estado" => 3, "msg" => "No existe metodo seleccionado", "data" => array());
        break;
}

print_r(json_encode($respuesta));
