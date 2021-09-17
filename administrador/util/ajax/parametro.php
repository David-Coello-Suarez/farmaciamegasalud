<?
require_once("../class/parametro.php");
require_once("../funciones/session.php");

$session = new Session();

if ($session->checkSession()) {

    $parametro = new Parametros();
    $metodo = $_POST['metodo'];

    switch ($metodo) {
        case 'PW':
            $parametroExt = strval($_POST['parametro']);
            $respuesta = $parametro->ObtenerParametro($parametroExt);
            break;
        case'OTP':
            $items = intval($_POST['items']);
            $pagina = intval($_POST['pagina']);
            $respuesta = $parametro->ObtenerParametros($items, $pagina);
            break;

        default:
            $respuesta = Funciones::RespuestaJson(2, "No existe metodo seleccionado '$metodo'");
            break;
    }
} else {
    $respuesta = Funciones::RespuestaJson(3, "Debe inicar session");
}
print_r(json_encode($respuesta));
