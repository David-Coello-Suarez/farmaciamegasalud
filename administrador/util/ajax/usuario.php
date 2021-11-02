<?
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

require_once("../funciones/session.php");
require_once("../funciones/Funciones.php");

$session = new Session();

if ($session->checkSession()) {

    require_once("../class/usuario.php");

    $usuario = new Usuario();
    $metodo = $_POST['metodo'];

    // unset($_POST['metodo']);
    switch ($metodo) {
        case 'OLU':
            $items = intval($_POST['items']);
            $pagina = intval($_POST['pagina']);
            $respuesta = $usuario->ListarUsuarios($pagina, $items);
            break;
        case 'AEU':
            $id = intval($_POST['id']);
            $estado = intval($_POST['estado']);
            $respuesta = $usuario->CambiarEstado($id, $estado);
            break;
        case 'OU':
            $id = intval($_POST['id']);
            $respuesta = $usuario->ObtenerUsuario($id);
            break;
        case 'AUC':
            $respuesta = $usuario->ActualizarUsuario($_POST);
            break;
        case 'CNU':
            $respuesta = $usuario->CrearUsuario($_POST);
            break;

        default:
            $respuesta = Funciones::RespuestaJson(2, "El metodo seleccionado no existe", $_POST);
            break;
    }
} else {
    $respuesta = Funciones::RespuestaJson(4, "Debe iniciar session");
}
print_r(json_encode($respuesta));
