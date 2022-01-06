<?
include_once("../system/conexion.php");
include_once("../system/Funciones.php");

if (file_exists("../../config.php")) {
    include_once("../../config.php");
} else {
    include_once("../../../config.php");
}

class Drive
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion->DBConexion();
    }

    public function ListarPDF()
    {
        $sql = "SELECT * FROM DriveImg WHERE estado = ?";

        $execBusqueda = $this->conexion->DBConsulta($sql, false, array(1));

        $i = array();

        foreach ($execBusqueda as $item) {
            $item['direccion'] = html_entity_decode($item['url']);

            $i[] = $item;
        }

        $data['pdf'] = $i;
        return Funciones::RespuestaJson(1, "", $data);
    }
}
