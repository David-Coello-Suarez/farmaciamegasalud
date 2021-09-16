<?
include_once("util/system/conexion.php");
if (file_exists("config.php")) {
    include_once("config.php");
} else {
    include_once("../config.php");
}

$conexion = new Conexion();
$conexion->DBConexion();

$consulta = $conexion->DBConsulta("SELECT * FROM Categorias");

$pagina = "inicio";

if( isset($_GET["pagina"]) && !empty($_GET['pagina']) )
{
    $pagina = $_GET["pagina"];
}

$random = rand();

include "inc/cabpie/cab.php";
include "inc/$pagina.php";
include "inc/cabpie/pie.php";