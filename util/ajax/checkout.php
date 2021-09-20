<?
include_once("../class/checkout.php");
include_once("../system/Funciones.php");

$checkout = new CheckOut();
$metodo = $_POST['metodo'];

unset($_POST['metodo']);

switch ($metodo) {
    case 'EP':
        $respuesta = $checkout->EnviarFactura($_POST);
        break;

    default:
        $respuesta = Funciones::RespuestaJson(2, "Metodo seleccionado no disponible '$metodo'");
        break;
}

print_r(json_encode($respuesta));
