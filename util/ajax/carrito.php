<?
include_once "../class/carrito.php";
include_once "../system/Funciones.php";

$carrito = new Carrito();
$metodo = $_POST['metodo'];

switch ($metodo) {
    case "APC":
        $idproducto = intval($_POST['idproducto']);
        $respuesta = $carrito->GuardarProductoCarrito($idproducto);
        break;
    case "OCP":
        $respuesta = $carrito->ObtenerProductoCarrito();
        break;
    case 'ACPC':
        $idcarrito = intval($_POST['carrito']);
        $cantidad = intval($_POST['cantidad']);
        $respuesta = $carrito->ActualizarCarrito($idcarrito, $cantidad);
        break;
    case 'EPC':
        $idcarrito = intval($_POST['carrito']);
        $respuesta = $carrito->EliminarCarritoProducto($idcarrito);
        break;
    case "APCA":
        $idcarrito = intval($_POST['idcarrito']);
        $cant = intval($_POST['cantidad']) + 1;
        $respuesta = $carrito->ActualizarCarrito($idcarrito, $cant);
        break;

    default:
        $respuesta = Funciones::RespuestaJson(3, "No existe el metodo seleccionado");
        break;
}

print_r(json_encode($respuesta));
