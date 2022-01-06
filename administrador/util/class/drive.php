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

    public function GuardarCambias($data, $img)
    {
        $id = intval($data['iddrive']);
        $orden = intval($data['orden']);
        $nombre = htmlentities($data['nombre']);
        $ubicacion = htmlentities($data['url']);

        $dataInt = array($nombre, $ubicacion);

        $imgData = "";

        if ($img['type'] != "") {
            $nombreImg = Funciones::SubirImg("drive", $img['type'], $img['tmp_name'], $id);
            $imgData = ", imagen = ?";
            array_push($dataInt, $nombreImg);
        }

        array_push($dataInt, $id);

        $sqlDrive = "UPDATE DriveImg SET nombre = ?, url = ? $imgData WHERE id = ?";

        $exec = $this->conexion->DBConsulta($sqlDrive, true, $dataInt);

        if ($exec) {
            return Funciones::RespuestaJson(1, "Éxito");
        } else {
            return Funciones::RespuestaJson(2, "Error al actualizar");
        }
    }
}
