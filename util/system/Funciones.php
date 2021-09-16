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

        $paginacion = "<ul class='pagination'>";

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

        $paginacion .= '</ul>';

        return $paginacion;
    }
}
