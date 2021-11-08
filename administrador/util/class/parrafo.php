<?

include_once("../funciones/conexion.php");
include_once("../funciones/Funciones.php");

if (file_exists("../../config.php")) {
    include_once("../../config.php");
} else {
    include_once("../../../config.php");
}

date_default_timezone_set("America/Guayaquil");

class Parrafos
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion->DBConexion();
    }

    public function ObtenerCabecera()
    {
        $cabecera = $this->conexion->DBConsulta("SELECT * FROM Parrafos", false, array(1));

        if (count($cabecera) > 0) {
            $data['cabecera'] = $cabecera;

            return Funciones::RespuestaJson(1, "", $data);
        } else {
            return Funciones::RespuestaJson(2, "No hay datos para mostrar");
        }
    }

    public function ObtenerDescripcion($data)
    {
        $id = intval($data['id']);

        $descripcion = $this->conexion->DBConsulta("SELECT * FROM ParrafoDetalle WHERE idParrafo = $id");

        if ($descripcion) {
            $descripcion['descripcion'] = html_entity_decode($descripcion['descripcion']);

            $dataInt['descripcion'] = $descripcion;
            return Funciones::RespuestaJson(1, "", $dataInt);
        } else {
            return Funciones::RespuestaJson(2, "No hay datos");
        }
    }

    public function GuardarDescripcion($data)
    {
        $id = intval($data['tipoparrafo']);
        $descripcion = htmlentities($data['nosotros']);

        $sql = "UPDATE ParrafoDetalle SET descripcion = ? WHERE idParrafo = ?";

        $exeUpdate = $this->conexion->DBConsulta($sql, true, array($descripcion, $id));

        if ($exeUpdate) {
            return Funciones::RespuestaJson(1);
        } else {
            return Funciones::RespuestaJson(2, "Error al actualizar");
        }
    }
}
