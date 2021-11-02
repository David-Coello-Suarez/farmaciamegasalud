<?
include_once("../system/conexion.php");
include_once("../system/Funciones.php");

if (file_exists("../../config.php")) {
    include_once("../../config.php");
} else {
    include_once("../../../config.php");
}

class Banner
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion->DBConexion();
    }

    public function ListarBannerPrincipal()
    {
        $sql = "SELECT * FROM BannerDetalle WHERE estado = ? AND tipoBanner = ?";

        $execBusqueda = $this->conexion->DBConsulta($sql, false, array(1, 1));

        $data['bannersP'] = $execBusqueda;
        return Funciones::RespuestaJson(1, "", $data);
    }

    public function ListarBannerSecondario()
    {
        $sql = "SELECT * FROM BannerDetalle WHERE estado = ? AND tipoBanner = ?";

        $execBusqueda = $this->conexion->DBConsulta($sql, false, array(1, 2));

        $data['bannersS'] = $execBusqueda;
        return Funciones::RespuestaJson(1, "", $data);
    }
}
