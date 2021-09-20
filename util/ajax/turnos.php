<?

require "../class/turnos.php";

$tiendas = new Turnos();

$metodo = $_POST['metodo'];

unset($_POST['metodo']);

switch ($metodo) {
    case 'LTW':
        $respuesta = $tiendas->ObtenerTiendas();
        break;
    case 'OTC':
        $respuesta = $tiendas->CiudadesActivas();
        break;
    case 'OTF':
        $respuesta = $tiendas->TiendasActivas($_POST);
        break;

    default:
        $respuesta = Funciones::RespuestaJson(3, "Metodo seleccionado no existe '$metodo'");
        break;
}

print_r(json_encode($respuesta));
