<?
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
ini_set('display_startup_errors', 1);

include_once("../config.php");
include_once("util/funciones/session.php");
include_once("util/funciones/conexion.php");

$session = new Session();

$conexion = new Conexion();
$conexion->DBConexion();

$random = rand();

// OBTENER PARAMETROS
$sql = $conexion->DBConsulta("SELECT * FROM Parametros", false, array(1));
$parametro = array();
foreach ($sql as $fila) {
    $parametro[trim($fila["nombre"])] = trim($fila['valor']);
}


if ($session->checkSession()) {

    $pagina = $parametro['paginadefault'];
    if (isset($_GET["pagina"]) && !empty($_GET['pagina'])) {
        $pagina = $_GET["pagina"];
    }

    // OBTENER EL MENU
    $menu = $conexion->DBConsulta("SELECT nombre, ventana FROM Menu", false, array(1));

    // OBTENER LIBRERIA POR VENTANA
    $librerias = $conexion->DBConsulta("SELECT nombre, ventana, libreria FROM Menu WHERE ventana = ?", false, array($pagina));
    $arregloLib =  array();

    foreach ($librerias as $item) {
        $arregloLib['nombre'] = $item['nombre'];
        $arregloLib['ventana'] = $item['ventana'];
        $arregloLib['libreria'] = explode(",", $item['libreria']);
    }

    include_once("inc/cabpie/cab.php");
    include_once("inc/$pagina/cuerpo.php");
    include_once("inc/cabpie/pie.php");
} else {
    include_once("inc/login/cuerpo.php");
}
