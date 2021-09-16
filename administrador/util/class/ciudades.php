<?
include_once("../funciones/conexion.php");
include_once("../funciones/Funciones.php");

if (file_exists("../../config.php")) {
    include_once("../../config.php");
} else {
    include_once("../../../config.php");
}

date_default_timezone_set("America/Guayaquil");

class Ciudad
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion->DBConexion();
    }

    public function ListarCiudades()
    {
        $sql = "SELECT id, ciudad FROM Ciudades WHERE estado = ?";

        $ciudades = $this->conexion->DBConsulta($sql, false, array(1));

        if (count($ciudades) > 0) {
            $items = array();
            foreach ($ciudades as $item) {
                $item['id'] = intval($item['id']);
                $item['ciudad'] = ucfirst(strtolower(html_entity_decode($item['ciudad'])));

                $items[] = $item;
            }
            array_unshift($items, array('id' => 0, 'ciudad' => 'Seleccione la ciudad'));
            $data['ciudades'] = $items;
            return Funciones::RespuestaJson(1, "", $data);
        } else {
            return Funciones::RespuestaJson(2, "No hay ciudades para mostrar");
        }
    }
}
