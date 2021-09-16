<?
require_once("util/funciones/session.php");

$session = new Session();

$session->endSession();

?>

<script>
    window.location = "inicio"
</script>