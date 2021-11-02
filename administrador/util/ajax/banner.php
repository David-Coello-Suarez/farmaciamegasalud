<?
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
ini_set('display_startup_errors', 1);
require_once("../funciones/session.php");

$session = new Session();

if ($session->checkSession()) {

    require_once("../class/banner.php");

    $banner = new Banners();
    $metodo = $_POST['metodo'];
    unset($_POST['metodo']);

    switch ($metodo) {
        case 'CCTB':
            $respuesta = $banner->CargarTipoBanner();
            break;
        case 'CTB':
            $respuesta = $banner->BannerTipo($_POST);
            break;
        case 'CNB':
            $respuesta = $banner->CrearBanner($_POST, $_FILES['img']);
            break;
        case 'ACB':
            $respuesta = $banner->ActualizarBanner($_POST, $_FILES['img']);
            break;
        case 'AEB':
            $respuesta = $banner->CambiarEstado($_POST);
            break;

        default:
            $respuesta = Funciones::RespuestaJson(2, "No exite metodo seleccionado. '$metodo'");
            break;
    }
} else {
    $respuesta = Funciones::RespuestaJson(3, "Debe inicar session");
}

print_r(json_encode($respuesta));
