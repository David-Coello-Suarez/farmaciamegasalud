<?
include_once("../class/login.php");
include_once("../funciones/Funciones.php");

$login = new Login();
$metodo = $_POST['metodo'];

switch ($metodo) {
    case 'LG':
        $usuario = html_entity_decode($_POST['usuario']);
        $contrasena = hash( "sha256", html_entity_decode($_POST['contrasena']));

        $respuesta = $login->VerificarUsuario($usuario, $contrasena);
        break;
    case 'AC':
        $respuesta = $login->ActualizarContrasena($_POST);
        break;

    default:
        $respuesta = Funciones::RespuestaJson(3, "Metodo seleccionado no existe");
        break;
}

print_r(json_encode($respuesta));
