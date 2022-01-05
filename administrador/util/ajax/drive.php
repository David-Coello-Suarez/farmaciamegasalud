<?
require_once("../funciones/session.php");

$session = new Session();

if ($session->checkSession()) {
    require_once "../class/drive.php";

    $drive = new drive();
    $metodo = $_POST['metodo'];
    unset($_POST['metodo']);

    switch ($metodo) {
        case 'LID':
            $respuesta = $drive->ObtenerLinks();
            break;
        case 'OI':
            $respuesta = $drive->ObtenerLink($_POST);
            break;

        default:
            $respuesta = Funciones::RespuestaJson(3, "No exite metodo seleccionado. '$metodo'");
            break;
    }
} else {
    $respuesta = Funciones::RespuestaJson(3, "Debe inicar session");
}

print_r(json_encode($respuesta));
