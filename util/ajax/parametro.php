<?
include_once("../class/parametroswb.php");

$params = new Parametros();
$metodo = $_POST['metodo'];

switch ($metodo) {
    case 'CLC':
        $param = $_POST['params'];
        $data = $params->ParametrosWeb();

        $respuesta = intval($data['numeroItems']);
        break;


    default:
        $respuesta = array("estado" => 3, "msg" => "No existe metodo seleccionado", "data" => array());
        break;
}

print_r(json_encode($respuesta));
