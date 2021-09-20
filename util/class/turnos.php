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

    public function CiudadesActivas()
    {
        $ciudades = $this->conexion->DBConsulta("SELECT id, ciudad FROM Ciudades WHERE estado = ?", false, array(1));

        if (count($ciudades) > 0) {
            $ciudadesItems = array();

            foreach ($ciudades as $item) {
                $item['id'] = intval($item['id']);
                $item['ciudad'] = html_entity_decode($item['ciudad']);

                $ciudadesItems[] = $item;
            }

            array_unshift($ciudadesItems, array('id' => 0, 'ciudad' => 'Seleccione la ciudad'));

            $data['ciudades'] = $ciudadesItems;
            return Funciones::RespuestaJson(1, "", $data);
        } else {
            return Funciones::RespuestaJson(2, "No hay ciudades disponibles");
        }
    }

    public function TiendasActivas($data)
    {
        $id = intval($data['id']);

        $sql = "
            SELECT f.direccion, f.id
            FROM FarmaciaCiudades AS fc
            INNER JOIN Farmacia AS f
            ON fc.idFarmacia = f.id
            WHERE fc.idCiudad = ?
            AND f.estado = ?
        ";

        $farmacias = $this->conexion->DBConsulta($sql, false, array($id, 1));

        if (count($farmacias) > 0) {
            $farmaciasInt = array();

            foreach ($farmacias as $item) {
                $item['id'] = intval($item['id']);
                $item['direccion'] = ucfirst(html_entity_decode($item['direccion']));

                $farmaciasInt[] = $item;
            }

            array_unshift($farmaciasInt, array('id' => 0, 'direccion' => 'Seleccione la farmacia'));

            $dataInt['farmacias'] = $farmaciasInt;

            return Funciones::RespuestaJson(1, "", $dataInt);
        } else {
            return Funciones::RespuestaJson(2, "No hay farmacias disponibles");
        }
    }
}
