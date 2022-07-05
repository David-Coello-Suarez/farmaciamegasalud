<?
include_once("util/system/conexion.php");
if (file_exists("config.php")) {
    include_once("config.php");
} else {
    include_once("../config.php");
}

$conexion = new Conexion();
$conexion->DBConexion();

// OBTENER PARAMETROS 
$sql = $conexion->DBConsulta("SELECT * FROM Parametros", false, array(1));
$parametro = array();
foreach ($sql as $fila) {
    $parametro[trim($fila["nombre"])] = trim($fila['valor']);
}

$pagina = $parametro['paginadefault'];
if (isset($_GET["pagina"]) && !empty($_GET['pagina'])) {
    $pagina = $_GET["pagina"];
}

$consulta = $conexion->DBConsulta("SELECT * FROM Categorias");

$random = rand();

include "inc/cabpie/cab.php";
include "inc/$pagina.php";
include "inc/cabpie/pie.php";
