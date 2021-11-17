<?
require_once("../funciones/session.php");

$session = new Session();

if ($session->checkSession()) {
    require_once("../class/farmacia.php");
    require_once("../funciones/Funciones.php");

    $farmacia = new Farmacia();
    $metodo = $_POST['metodo'];
    unset($_POST['metodo']);

    switch ($metodo) {
        case 'LTF':
            $items = intval($_POST['items']);
            $pagina = intval($_POST['pagina']);
            $ciudad = intval($_POST['ciudad']);

            $repuesta = $farmacia->ListarFarmacias($ciudad, $items, $pagina);
            break;
        case 'AEF':
            $idfarmacia =  intval($_POST['id']);
            $estado = intval($_POST['estado']);
            $repuesta = $farmacia->ActualizarEstado($idfarmacia, $estado);
            break;
        case 'OFS':
            $idfarmacia =  intval($_POST['id']);
            $repuesta = $farmacia->ObtenerFarmacia($idfarmacia);
            break;
        case 'AFS':
            $data = $_POST;
            $img = $_FILES['image'];
            $repuesta = $farmacia->ActualizarFarmacia($data, $img);
            break;
        case 'CNF':
            $data = $_POST;
            $img = $_FILES['image'];
            $repuesta = $farmacia->CrearFarmacias($data, $img);
            break;

        default:
            $repuesta = Funciones::RespuestaJson(2, "No existe metodo seleccionado '$metodo'");
            break;
    }
} else {
    $repuesta = Funciones::RespuestaJson(3, "Debe iniciar session");
}

print_r(json_encode($repuesta));
