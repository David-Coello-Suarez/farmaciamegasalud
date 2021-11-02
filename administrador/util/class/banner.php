<?
include_once("../funciones/conexion.php");
include_once("../funciones/Funciones.php");

if (file_exists("../../config.php")) {
    include_once("../../config.php");
} else {
    include_once("../../../config.php");
}

date_default_timezone_set("America/Guayaquil");

class Banners
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion->DBConexion();
    }

    public function CargarTipoBanner(): object
    {
        $tipoBanner = $this->conexion->DBConsulta("SELECT * FROM Banners", false, array(1));

        if (count($tipoBanner) > 0) {
            $data['tipoBanner'] = $tipoBanner;
            return Funciones::RespuestaJson(1, "", $data);
        } else {
            return Funciones::RespuestaJson(2, "No hay datos para mostrar");
        }
    }

    public function BannerTipo($data): object
    {
        $id = intval($data['id']);

        $listarBanner = "SELECT * FROM BannerDetalle WHERE tipoBanner = $id";

        $execListBanner = $this->conexion->DBConsulta($listarBanner, false, array(1));

        if (count($execListBanner) > 0) {
            $items = intval($data['items']);
            $pagina = intval($data['pagina']);

            $inicia = intval(intval($pagina - 1) * $items);

            $banners = $this->conexion->DBConsulta("$listarBanner LIMIT $inicia, $items", false, array(1));

            $cont = $inicia + 1;
            $dataInt = array();
            foreach ($banners as $item) {

                $item['cont'] = $cont;
                $cont++;

                $dataInt[] = $item;
            }

            $dataAux['mostrar'] = Funciones::MostrandoInfo($cont, $inicia, count($execListBanner), $items);
            $dataAux['banners'] = $dataInt;
            $dataAux['paginacion'] = Funciones::Paginacion(count($execListBanner), $items, $pagina);
            return Funciones::RespuestaJson(1, "", $dataAux);
        } else {
            return Funciones::RespuestaJson(2, "No hay datos para mostrar");
        }
    }

    public function CrearBanner($data, $img): object
    {
        $tipo = intval($data['selectedTipoBannerForm']);

        $imgbd  = Funciones::SubirImg('banner', $img['type'], $img['tmp_name']);

        list($width, $height) = getimagesize("../../$imgbd");

        $sqlGuardarImg = "INSERT INTO BannerDetalle (tipoBanner, imagen, alto, ancho) VALUE
                                        (?, ?, ?, ?)";

        if ($this->conexion->DBConsulta($sqlGuardarImg, true, array($tipo, $imgbd, $width, $height))) {
            return Funciones::RespuestaJson(1, "Creado con éxito");
        } else {
            return Funciones::RespuestaJson(2, "Error al crear");
        }
    }

    public function ActualizarBanner($data, $img): object
    {
        $id = intval($data['idbanner']);
        $tipo = intval($data['selectedTipoBannerForm']);

        $imagen = "";
        if ($img['type'] != "") {
            $buscar = $this->conexion->DBConsulta("SELECT imagen FROM BannerDetalle WHERE idbannerDet = $id", false);

            $borrar = Funciones::EliminarArchivo($buscar['imagen']);

            if ($borrar && file_exists("../../" . $buscar['imagen'])) {
                $imagen =  ", imagen = '" . Funciones::SubirImg('banner', $img['type'], $img['tmp_name'], $id) . "'";
            } else {
                $imagen =  ", imagen = '" . Funciones::SubirImg('banner', $img['type'], $img['tmp_name'], $id) . "'";
            }
        }

        $sqlGuardar = "UPDATE BannerDetalle SET tipoBanner = ?, fechaActual = now() $imagen WHERE idbannerDet = ?";

        if ($this->conexion->DBConsulta($sqlGuardar, true, array($tipo, $id))) {
            return Funciones::RespuestaJson(1, "Éxito al actualizar");
        }

        return Funciones::RespuestaJson(2, "Error al actualizar");
    }

    public function CambiarEstado($data)
    {
        $id = intval($data['id']);
        $estado = intval($data['estado']);

        $sqlCambiarEstado = "UPDATE BannerDetalle SET estado = ? WHERE idbannerDet = ?";

        $execCambiarEstadO = $this->conexion->DBConsulta($sqlCambiarEstado, true, array($estado, $id));

        if ($execCambiarEstadO) {
            return Funciones::RespuestaJson(1, "Cambiado con éxito");
        } else {
            return Funciones::RespuestaJson(2, "Error");
        }
    }

    public function BannerSeleccionado($data): object
    {
        $id = intval($data['id']);

        $execBanner = $this->conexion->DBConsulta("SELECT * FROM BannerDetalle WHERE idbannerDet = $id");

        if ($execBanner) {
            return Funciones::RespuestaJson(1, "", $execBanner);
        }

        return Funciones::RespuestaJson(2, "Error al buscar");
    }
}
