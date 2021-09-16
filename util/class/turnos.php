<?
include_once("../system/conexion.php");
include_once("../system/Funciones.php");

if (file_exists("../../config.php")) {
    include_once("../../config.php");
} else {
    include_once("../../../config.php");
}

class Turnos
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion->DBConexion();
    }

    public function ObtenerTiendas()
    {
        $nombreTiendas = $this->conexion->DBConsulta("SELECT DISTINCT fc.idCiudad, c.ciudad FROM FarmaciaCiudades AS fc INNER JOIN Ciudades AS c ON fc.idCiudad = c.id", false, array(1));

        if (count($nombreTiendas) > 0) {
            $data = array();

            foreach ($nombreTiendas as $item) {
                $item['farmacias'] = $this->conexion->DBConsulta("SELECT f.* FROM FarmaciaCiudades AS fc INNER JOIN Farmacia AS f ON fc.idFarmacia = f.id WHERE fc.idCiudad = ?", false, array(intval($item['idCiudad'])));
            
                $data[] = $item;
            }

            $items['cuidades'] = $data;

            return Funciones::RespuestaJson(1, "", $items);
        } else {
            return Funciones::RespuestaJson(2, "No hay tiendas para mostrar");
        }
    }
}
