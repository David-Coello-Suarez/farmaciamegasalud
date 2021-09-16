<?
include_once("../system/conexion.php");

if (file_exists("../../config.php")) {
    include_once("../../config.php");
} else {
    include_once("../../../config.php");
}

class Parametros
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion->DBConexion();
    }

    public function ParametrosWeb()
    {
        $parametro = array();
        $params = $this->conexion->DBConsulta("SELECT * FROM ParametrosWeb", false, array(1));

        foreach ($params as $items) {
            $parametro[trim($items['nombre'])] = trim($items['valor']);
        }

        return $parametro;
    }
}
