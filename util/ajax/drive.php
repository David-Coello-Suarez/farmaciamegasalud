<?
include_once "../class/drive.php";

$categoria = new Drive();
$metodo = $_POST['metodo'];

switch ($metodo) {
    case "LPDF":
        $respuesta = $categoria->ListarPDF();
        break;
}

print_r(json_encode($respuesta));
