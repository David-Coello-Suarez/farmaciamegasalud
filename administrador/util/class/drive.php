<?
include_once("../funciones/conexion.php");
include_once("../funciones/Funciones.php");

if (file_exists("../../config.php")) {
    include_once("../../config.php");
} else {
    include_once("../../../config.php");
}

date_default_timezone_set("America/Guayaquil");

class drive
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion->DBConexion();
    }

    public function ObtenerLinks()
    {
        $tipoBanner = $this->conexion->DBConsulta("SELECT * FROM DriveImg", false, array(1));

        if (count($tipoBanner) > 0) {
            $data['drive'] = $tipoBanner;
            return Funciones::RespuestaJson(1, "", $data);
        } else {
            return Funciones::RespuestaJson(2, "No hay datos para mostrar");
        }
    }

    public function ObtenerLink($data)
    {
        $id = intval($data['id']);

        $exec = $this->conexion->DBConsulta("SELECT * FROM DriveImg WHERE id = $id");

        if ($exec) {
            $dataInt['drive'] = $exec;
            return Funciones::RespuestaJson(1, "", $dataInt);
        }

        return Funciones::RespuestaJson(2, "Error al buscar");
    }
}
