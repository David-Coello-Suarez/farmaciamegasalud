<?
class Funciones
{
    public static function RespuestaJson($estado = 3, $msj = "", $data = array())
    {
        $respuesta = new stdClass();
        $respuesta->estado = $estado;
        $respuesta->msj = $msj;
        $respuesta->data = $data;
        return $respuesta;
    }

    public static function Paginacion($totalItems = 100, $itemsForPage = 10, $pagina = 1, $nombreFunction = "Listar")
    {
        $paginas = intval(ceil($totalItems / $itemsForPage));

        $paginacion = "";

        if ($paginas < 5) {
            for ($i = 0; $i < $paginas; $i++) {
                $paginacion .= "<li> <button type='button' class='btn btn-avanzar " . ($pagina == ($i + 1) ? 'active' : '') . "' data-pagina='" . ($i + 1) . "'>" . ($i + 1) . "</button> </li>";
            }
        } else if ($paginas >= 7) {
            if ($pagina < 3) {
                for ($i = 0; $i < 3; $i++) {
                    $paginacion .= "<li> <button type='button' class='btn btn-avanzar " . ($pagina == ($i + 1) ? 'active' : '') . "' data-pagina='" . ($i + 1) . "'>" . ($i + 1) . "</button> </li>";
                }
                $paginacion .= "<li> <button type='button' class='btn'>....</button></li>";
                $paginacion .= "<li> <button type='button' class='btn' data-pagina='" . ($pagina + 1) . "'>&gt;</button </li>";
                $paginacion .= "<li> <button type='button' class='btn' data-pagina='" . $paginas . "'>&gt;|</button> </li>";
            } else if (($paginas - 3) >= $pagina && $pagina >= 3) {
                $paginacion .= "<li> <button type='button' class='btn' data-pagina='1'>|&lt;</button> </li>";
                $paginacion .= "<li> <button type='button' class='btn' data-pagina='" . ($pagina - 1) . "'>&lt;</button </li>";
                $paginacion .= "<li> <button type='button' class='btn'>....</button></li>";
                for ($i = ($pagina - 2); $i < ($pagina + 1); $i++) {
                    $paginacion .= "<li> <button type='button' class='btn btn-avanzar " . ($pagina == ($i + 1) ? 'active' : '') . "' data-pagina='" . ($i + 1) . "'>" . ($i + 1) . "</button> </li>";
                }
                $paginacion .= "<li> <button type='button' class='btn'>....</button></li>";
                $paginacion .= "<li> <button type='button' class='btn' data-pagina='" . ($pagina + 1) . "'>&gt;</button </li>";
                $paginacion .= "<li> <button type='button' class='btn' data-pagina='" . $paginas . "'>&gt;|</button> </li>";
            } else {
                $paginacion .= "<li> <button type='button' class='btn' data-pagina='1'>|&lt;</button> </li>";
                $paginacion .= "<li> <button type='button' class='btn' data-pagina='" . ($pagina - 1) . "'>&lt;</button </li>";
                $paginacion .= "<li> <button type='button' class='btn'>....</button></li>";
                for ($i = ($paginas - 3); $i < ($paginas); $i++) {
                    $paginacion .= "<li> <button type='button' class='btn btn-avanzar " . ($pagina == ($i + 1) ? 'active' : '') . "' data-pagina='" . ($i + 1) . "'>" . ($i + 1) . "</button> </li>";
                }
            }
        }

        return $paginacion;
    }

    public static function SubirImg($folder = 'productos', $type, $tmpName, $numeroArchivo = 0, $extencionPer = array('png', 'jpg', 'jpeg'))
    {
        date_default_timezone_set("America/Guayaquil");

        $ruta = "../../img/";

        if (!file_exists($ruta . $folder)) {
            mkdir($ruta . $folder, 0777, true);
        }

        $ext = explode("/", $type)[1];

        if (in_array($ext, $extencionPer)) {
            $nombreFile = date("Y-m-d_H:i:s") . "_" . $numeroArchivo . "." . $ext;

            $moverImg = $ruta . $folder . "/" . $nombreFile;

            if (move_uploaded_file($tmpName, $moverImg)) {
                return "img/$folder/$nombreFile";
            }
        }
    }

    public static function EliminarArchivo($ruta = "")
    {
        if ($ruta != "") {
            if (unlink("../../$ruta")) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function MostrandoInfo($vueltas = 0, $inicio = 0, $total = 0, $items = 0)
    {
        $al = intval($vueltas - 1);
        $del = intval($inicio + 1);

        $paginaInt = intval(ceil($total / $items));
        $paginas = $paginaInt . " Página" . (($paginaInt > 1) ? 's' : '');

        $texto = "Mostrando del $del al $al de $total ($paginas)";

        return $texto;
    }
}
