<?
include_once("../funciones/conexion.php");
include_once("../funciones/Funciones.php");

if (file_exists("../../config.php")) {
    include_once("../../config.php");
} else {
    include_once("../../../config.php");
}

date_default_timezone_set("America/Guayaquil");

class Farmacia
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion->DBConexion();
    }

    public function ListarFarmacias($items, $pagina)
    {
        $totalFarmacias = $this->conexion->DBConsulta("SELECT COUNT(*) AS total FROM Farmacia", false);

        $total = intval($totalFarmacias['total']);

        if ($total > 0) {
            $inicia = intval(($pagina - 1) * $items);

            $sqlItems = "SELECT * FROM Farmacia ORDER BY createdAt DESC LIMIT $inicia, $items";

            $farmcias = $this->conexion->DBConsulta($sqlItems, false, array(1));

            $cont = intval($inicia + 1);
            $itemInt = array();

            foreach ($farmcias as $item) {
                $idfarmacia = intval($item['id']);

                $ciudad = $this->conexion->DBConsulta("SELECT c.ciudad FROM FarmaciaCiudades AS fc INNER JOIN Ciudades AS c ON fc.idCiudad = c.id WHERE fc.idFarmacia = $idfarmacia", false);
                $item['ciudad'] = ucfirst(strtolower($ciudad['ciudad']));

                $item['pos'] = $cont;

                $item['id'] = $idfarmacia;

                if ($item['updatedAt'] == null) {
                    $item['updatedAt'] = "";
                }

                if (!file_exists("../../" . $item['imagen']) || $item['imagen'] == "") {
                    $item['imagen'] = "img/farmacias/no-farmacia.png";
                }

                $cont++;
                $itemInt[] = $item;
            }

            $data['farmacias'] = $itemInt;
            $data['paginacion'] = Funciones::Paginacion($total, $items, $pagina);
            $data['mostrar'] = Funciones::MostrandoInfo($cont, $inicia, $total, $items);

            return Funciones::RespuestaJson(1, "", $data);
        } else {
            return Funciones::RespuestaJson(2, "No hay farmacia disponible");
        }
    }

    public function ActualizarEstado($idfarmacia, $estado)
    {
        $date = date("Y-m-d H:i:s");

        $sql = "UPDATE Farmacia SET estado = ?, updatedAt = ? WHERE id = ?";

        $cambiarEstado = $this->conexion->DBConsulta($sql, true, array($estado, $date, $idfarmacia));

        if ($cambiarEstado) {
            return Funciones::RespuestaJson(1, "Estado cambiado con éxito");
        } else {
            return Funciones::RespuestaJson(2, "Error al actualizar estado");
        }
    }

    public function ObtenerFarmacia($idfarmacia)
    {
        $farmacia = $this->conexion->DBConsulta("SELECT * FROM Farmacia WHERE id = $idfarmacia", false);

        if ($farmacia) {
            $farmacia['id'] = intval($farmacia['id']);
            $idfarmacia = intval($farmacia['id']);
            $ciudad = $this->conexion->DBConsulta("SELECT c.id FROM FarmaciaCiudades AS fc INNER JOIN Ciudades AS c ON fc.idCiudad = c.id WHERE fc.idFarmacia = $idfarmacia", false);
            $farmacia['idciudad'] = intval($ciudad['id']);
            return Funciones::RespuestaJson(1, "", $farmacia);
        } else {
            return Funciones::RespuestaJson(2, "No existe farmacia");
        }
    }

    public function ActualizarFarmacia($data, $img)
    {
        $i = 0;
        $idfarmacia = intval($data['idfarmacia']);

        $exiteFarmacia = $this->conexion->DBConsulta("SELECT * FROM Farmacia WHERE id = $idfarmacia ");

        if ($exiteFarmacia) {

            $direccion = htmlentities($data['direccion'][$i]);
            $referencia = htmlentities($data['referencia'][$i]);
            $telefono = intval($data['telefono'][$i]);
            $extencion = intval($data['extencion'][$i]);
            $googlemaps = htmlentities($data['googlemaps'][$i]);
            $idciudad = intval($data['ciudad'][$i]);
            $fechaUpdate = date("Y-m-d H:i:s");

            $sql = "UPDATE Farmacia SET direccion = ?, telefono = ?, ext = ?, referencia = ?, googlemaps = ?, updatedAt = ?";
            $dataInt = array($direccion, $telefono, $extencion, $referencia, $googlemaps, $fechaUpdate);

            if ($img['name'][$i] != "") {
                $sql .= ", imagen = ?";
                if ($exiteFarmacia['imagen'] == "") {
                    $dataInt[] = Funciones::SubirImg("farmacias", $img['type'][$i], $img['tmp_name'][$i], $idfarmacia);
                } else {
                    $eliminaImgActual = Funciones::EliminarArchivo($exiteFarmacia['imagen']);
                    if ($eliminaImgActual) {
                        $dataInt[] = Funciones::SubirImg("farmacias", $img['type'][$i], $img['tmp_name'][$i], $idfarmacia);
                    } else {
                        $dataInt[] = Funciones::SubirImg("farmacias", $img['type'][$i], $img['tmp_name'][$i], $idfarmacia);
                    }
                }
            }

            $sql .= " WHERE id = ?";
            $dataInt[] = $idfarmacia;

            $actualizarFarmacia = $this->conexion->DBConsulta($sql, true, $dataInt);

            if ($actualizarFarmacia) {
                $obtenerFarmaciaCiudad = $this->conexion->DBConsulta("SELECT * FROM FarmaciaCiudades WHERE idFarmacia = $idfarmacia", false);

                if ($obtenerFarmaciaCiudad) {
                    $idfarmaciaCiudad = intval($obtenerFarmaciaCiudad['id']);

                    $actualizarUbicacion = $this->conexion->DBConsulta(
                        "UPDATE FarmaciaCiudades SET idCiudad = ?, updatedAt = ? WHERE id = ? AND idFarmacia = ?",
                        true,
                        array($idciudad, $fechaUpdate, $idfarmaciaCiudad, $idfarmacia)
                    );

                    if ($actualizarUbicacion) {
                        return Funciones::RespuestaJson(1, "Actualizado con éxito");
                    }
                } else {
                    return Funciones::RespuestaJson(2, "No se pudo obtener la ciudad a la que se va asignar la farmacia");
                }
            } else {
                return Funciones::RespuestaJson(2, "Error al actualizar la farmacia");
            }
        }
    }

    public function CrearFarmacias($data, $img)
    {
        $sql = "INSERT INTO Farmacia (direccion, telefono, ext, referencia, googlemaps) VALUES (?,?,?,?,?)";
        $total = 0;

        $totalInt = count($data['direccion']);

        for ($i = 0; $i < $totalInt; $i++) {

            $direccion = htmlentities($data['direccion'][$i]);
            $referencia = htmlentities($data['referencia'][$i]);
            $telefono = intval( str_replace(" ","", $data['telefono'][$i]));
            $extencion = intval($data['extencion'][$i]);
            $googlemaps = htmlentities($data['googlemaps'][$i]);
            $idciudad = intval($data['ciudad'][$i]);

            $dataInt = array($direccion, $telefono, $extencion, $referencia, $googlemaps);

            $crearNuevaFarmacia = $this->conexion->DBConsulta($sql, true, $dataInt);
            if ($crearNuevaFarmacia) {
                $idfarmacia = $this->conexion->UltimoInsert();

                $nombreImg = Funciones::SubirImg("farmacias", $img['type'][$i], $img['tmp_name'][$i], $idfarmacia);

                $updateImg = $this->conexion->DBConsulta("UPDATE Farmacia SET imagen = ? WHERE id = ?", true, array($nombreImg, $idfarmacia));

                if ($updateImg) {
                    $guardarLocation = $this->conexion->DBConsulta("INSERT INTO FarmaciaCiudades (idFarmacia, idCiudad) VALUES  (?,?)", true, array($idfarmacia, $idciudad));

                    if ($guardarLocation) {
                        $total++;
                    }
                }
            }
        }

        if ($totalInt == $total) {
            return Funciones::RespuestaJson(1);
        } else {
            return Funciones::RespuestaJson(2, "Error al guardar");
        }
    }
}
