<?
require_once("../funciones/session.php");

$session = new Session();

if ($session->checkSession()) {

    require_once("../class/categoria.php");

    $categoria = new Categoria();
    $metodo = $_POST['metodo'];
    unset($_POST['metodo']);

    switch ($metodo) {
        case 'LCA':
            $respuesta = $categoria->ListarCategoriaWeb();
            break;
        case 'OCA':
            $pagina = intval($_POST['pagina']);
            $itemsForPage = intval($_POST['items']);
            $respuesta = $categoria->ListarCategorias($pagina, $itemsForPage);
            break;
        case 'AEC':
            $respuesta = $categoria->ActualizarCategoria($_POST);
            break;
        case 'OC':
            $respuesta = $categoria->ObtenerCategoria(intval($_POST['id']));
            break;
        case 'ACS':
            $data = $_POST;
            $respuesta = $categoria->ActualizarCategoriaSeleccionada($data);
            break;
        case 'CNC':
            $data = $_POST;
            $respuesta = $categoria->NuevaCategoria($data);
            break;

        default:
            $respuesta = Funciones::RespuestaJson(3, "No exite metodo seleccionado. '$metodo'");
            break;
    }
} else {
    $respuesta = Funciones::RespuestaJson(3, "Debe inicar session");
}

print_r(json_encode($respuesta));
