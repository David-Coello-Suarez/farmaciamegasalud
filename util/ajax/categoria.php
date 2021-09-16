<?
include_once "../class/categoria.php";

$categoria = new Categorias();
$metodo = $_POST['metodo'];

switch ($metodo) {
    case "LCWA":
        $respuesta = $categoria->ListarCategoriasWeb();
        break;
}

print_r(json_encode($respuesta));
