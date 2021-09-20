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

    public function ListarTodasCiudades($pagina, $items)
    {
        $ciudades = $this->conexion->DBConsulta("SELECT COUNT(*) AS total FROM Ciudades", false);

        $totalCiudades = intval($ciudades['total']);

        if ($totalCiudades > 0) {
            $inicia = intval(($pagina - 1) * $items);

            $ciudadesItems = $this->conexion->DBConsulta("SELECT * FROM Ciudades LIMIT $inicia, $items", false, array(1));

            $cont = intval($inicia + 1);
            $itemsInt = array();

            foreach ($ciudadesItems as $item) {
                $item['pos'] = $cont;
                $item['id'] = intval($item['id']);

                $item['ciudad'] = ucfirst($item['ciudad']);

                if ($item['updatedAt'] == null) {
                    $item['updatedAt'] = "";
                }

                $cont++;
                $itemsInt[] = $item;
            }

            $data['ciudades'] = $itemsInt;
            $data['paginacion'] = Funciones::Paginacion($totalCiudades, $items, $pagina);
            $data['mostrar'] = Funciones::MostrandoInfo($cont, $inicia, $totalCiudades, $items);

            return Funciones::RespuestaJson(1, "", $data);
        } else {
            return Funciones::RespuestaJson(2, "No hay datos para mostrar");
        }
    }

    public function ActualizarCiudad($data)
    {

        $id = intval($data['id']);
        $ciudad = htmlentities($data['ciudad']);
        $date = date("Y-m-d H:i:s");

        $actualizarCiudad = $this->conexion->DBConsulta("UPDATE Ciudades SET ciudad = ?, updatedAt = ? WHERE id = ?", true, array($ciudad, $date, $id));

        if ($actualizarCiudad) {
            return Funciones::RespuestaJson(1, "Actualizado con éxito");
        } else {
            return Funciones::RespuestaJson(2, "Error al actualizar");
        }
    }

    public function CrearNuevaCiudad($data)
    {
        $total = 0;
        $existe = array();
        $ciudad = intval(count($data['ciudad']));

        $sql = "INSERT INTO Ciudades (ciudad) VALUES (?)";

        for ($i = 0; $i < $ciudad; $i++) {
            $ciudadInt = htmlentities($data['ciudad'][$i]);

            $verificarSiExite = $this->conexion->DBConsulta("SELECT * FROM Ciudades WHERE ciudad = '$ciudadInt'", false, array(12));

            if ($verificarSiExite) {
                $existe[] = $ciudadInt;
            } else {
                $GuardarCiudad = $this->conexion->DBConsulta($sql, true, array($ciudadInt));

                if ($GuardarCiudad) {
                    $total++;
                }
            }
        }

        if ($total == $ciudad) {
            return Funciones::RespuestaJson(1, "Registrados con éxito");
        } elseif (count($existe) > 0) {
            $dataInt['existe'] = $existe;
            return Funciones::RespuestaJson(2, "Ya existen algunas ciudades", $dataInt);
        } else {
            return Funciones::RespuestaJson(3, "Error al registrar");
        }
    }

    public function ActualizarEstadoCiudad($data)
    {
        $id = intval($data['id']);
        $date = date("Y-m-d H:i:s");
        $estado = intval($data['estado']);

        $actualizarEstado = $this->conexion->DBConsulta("UPDATE Ciudades SET estado = ?, updatedAt = ? WHERE id = ?", true, array($estado, $date, $id));

        if ($actualizarEstado) {
            return Funciones::RespuestaJson(1);
        } else {
            return Funciones::RespuestaJson(2, "Error al actualizar");
        }
    }
}
