<?

require_once("../funciones/session.php");
require_once("../funciones/Funciones.php");

$session = new Session();

if ($session->checkSession()) {


    require_once("../class/parrafo.php");

    $parrafo = new Parrafos();
    $metodo = $_POST['metodo'];

    unset($_POST['metodo']);
    switch ($metodo) {
        case 'OBP':
            $respuesta = $parrafo->ObtenerCabecera();
            break;
        case 'ODP':
            $respuesta = $parrafo->ObtenerDescripcion($_POST);
            break;
        case 'GTXT':
            $respuesta = $parrafo->GuardarDescripcion($_POST);
            break;


        default:
            $respuesta = Funciones::RespuestaJson(3, "El metodo seleccionado no existe", $_POST);
            break;
    }
} else {
    $respuesta = Funciones::RespuestaJson(4, "Debe iniciar session");
}
print_r(json_encode($respuesta));
