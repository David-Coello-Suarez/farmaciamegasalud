<?
    $extraerParrafo = $conexion->DBConsulta("SELECT * FROM ParrafoDetalle WHERE idParrafo = 1", false);
?>

<div class="text-center h4">
    <? print_r( html_entity_decode($extraerParrafo['descripcion']) ) ?>
</div>