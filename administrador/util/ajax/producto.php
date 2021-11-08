<?

require_once("../funciones/session.php");
require_once("../funciones/Funciones.php");

$session = new Session();

if ($session->checkSession()) {

    require_once("../class/producto.php");

    $producto = new Producto();
    $metodo = $_POST['metodo'];

    unset($_POST['metodo']);
    switch ($metodo) {
        case 'CNP':
            $data = $_POST;
            $img = $_FILES;
            $respuesta = $producto->CrearProductos($data, $img);
            break;
        case 'OLP':
            $items = intval($_POST['items']);
            $pagina = intval($_POST['pagina']);
            $respuesta = $producto->ListarProductos($pagina, $items);
            break;
        case 'AEP':
            $data = $_POST;
            $respuesta = $producto->ActualizarEstado($data);
            break;
        case 'OP':
            $data = $_POST;
            $respuesta = $producto->ObtenerProducto($data);
            break;
        case 'APC':
            $data = $_POST;
            $img = $_FILES['image'];
            $respuesta = $producto->ActualziarProducto($data, $img);
            break;

        default:
            $respuesta = Funciones::RespuestaJson(3, "El metodo seleccionado no existe", $_POST);
            break;
    }
} else {
    $respuesta = Funciones::RespuestaJson(4, "Debe iniciar session");
}
print_r(json_encode($respuesta));
