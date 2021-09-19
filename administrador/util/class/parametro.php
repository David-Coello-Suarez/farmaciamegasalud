<?
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
ini_set('display_startup_errors', 1);

include_once("../funciones/conexion.php");
include_once("../funciones/Funciones.php");

if (file_exists("../../config.php")) {
    include_once("../../config.php");
} else {
    include_once("../../../config.php");
}

date_default_timezone_set("America/Guayaquil");

class Parametros
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion->DBConexion();
    }

    public function ObtenerParametro($params = "")
    {
        $parametro = array();
        $parametros = $this->conexion->DBConsulta("SELECT * FROM Parametros", false, array(1));
        foreach ($parametros as $item) {
            $parametro[trim($item['nombre'])] = trim($item['valor']);
        }

        return Funciones::RespuestaJson(1, $parametro["$params"]);
    }

    public function ObtenerParametros($itemForPage , $pagina)
    {
        $parametros = $this->conexion->DBConsulta("SELECT * FROM Parametros", false, array(1));

        $totalParametros = count($parametros);

        if ($totalParametros > 0) {
            $inicia = intval(($pagina - 1) * $itemForPage);

            $cont = intval($inicia + 1);
            $itemInt = array();

            $parametrosInt =  $this->conexion->DBConsulta("SELECT * FROM Parametros LIMIT $inicia, $itemForPage", false, array(1));

            foreach ($parametrosInt as $item) {
                $item['pos'] = $cont;

                $cont++;
                $itemInt[] = $item;
            }


            $data['parametros'] = $itemInt;
            $data['paginacion'] = Funciones::Paginacion($totalParametros, $itemForPage, $pagina);
            $data['mostrar'] = Funciones::MostrandoInfo($cont, $inicia, $totalParametros, $itemForPage);

            return Funciones::RespuestaJson(1, "", $data);
        } else {
            return Funciones::RespuestaJson(2, "No hay datos para mostrar");
        }
    }

    public function ActualizarParametro($id, $valor, $desc)
    {
        $data = date("Y-m-d H:i:s");

        $sqlUpdate = "UPDATE Parametros SET valor = ?, descripcion = ?, updatedAt = ? WHERE id = ?";

        $guardar = $this->conexion->DBConsulta($sqlUpdate, true, array($valor, $desc, $data, $id));

        if ($guardar) {
            return Funciones::RespuestaJson(1);
        } else {
            return Funciones::RespuestaJson(2, "Error al actualizar");
        }
    }
}
