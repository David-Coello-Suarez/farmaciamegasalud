<?
ini_set('display_errors',1);
ini_set('error_reporting', E_ALL);
ini_set('display_startup_errors',1);
require_once("../funciones/session.php");

$session = new Session();

if ($session->checkSession()) {
    require_once("../class/ciudades.php");
    require_once("../funciones/Funciones.php");

    $ciudades = new Ciudad();
    $metodo = $_POST['metodo'];
    unset($_POST['metodo']);

    switch ($metodo) {
        case 'LCA':
            $repuesta = $ciudades->ListarCiudades();
            break;

        default:
            $repuesta = Funciones::RespuestaJson(2, "No existe metodo seleccionado '$metodo'");
            break;
    }
} else {
    $repuesta = Funciones::RespuestaJson(3, "Debe iniciar session");
}

print_r(json_encode($repuesta));
