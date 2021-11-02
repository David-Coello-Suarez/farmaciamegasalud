<?
include_once "../class/banner.php";
include_once "../system/Funciones.php";

$banner = new Banner();
$metodo = $_POST['metodo'];

switch ($metodo) {
    case 'CBP':
        $respuesta = $banner->ListarBannerPrincipal();
        break;
    case 'CBS':
        $respuesta = $banner->ListarBannerSecondario();
        break;

    default:
        $respuesta = Funciones::RespuestaJson(3, "No existe el metodo seleccionado");
        break;
}

print_r(json_encode($respuesta));
