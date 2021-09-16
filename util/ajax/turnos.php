<?
require "../class/turnos.php";
$tiendas = new Turnos();

$metodo = $_POST['metodo'];

switch($metodo){
    case 'LTW':
        $respuesta = $tiendas->ObtenerTiendas();
        break;
}

print_r(json_encode($respuesta));