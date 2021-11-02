<?
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
ini_set('display_startup_errors', 1);

include_once("../funciones/session.php");
include_once("../funciones/conexion.php");
include_once("../funciones/Funciones.php");

if (file_exists("../../config.php")) {
    include_once("../../config.php");
} else {
    include_once("../../../config.php");
}

class Login
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion->DBConexion();
    }

    public function VerificarUsuario($usuario, $contrasena)
    {
        $usuario = $this->conexion->DBConsulta("
            SELECT CONCAT(mb.nombres, ' ', mb.apellidos) AS usuario, rl.nombreRol, us.id
            FROM UsuarioLogin AS us
            INNER JOIN Miembros AS mb
            ON us.idmiembro = mb.id
            INNER JOIN Rols AS rl
            ON us.idrol = rl.id
            WHERE us.usuario = '$usuario' AND us.contrasena = '$contrasena'
        ");

        if ($usuario) {
            $sesion = new Session();
            $sesion->createSession($usuario);

            return Funciones::RespuestaJson(1, "Usuario Loguedo");
        } else {
            return Funciones::RespuestaJson(2, "Usuario Incorrecto [ usuario - contraseña ]");
        }
    }

    public function ActualizarContrasena($data)
    {
        new Session();
        $idusuario = intval($_SESSION['usuario']['id']);

        $usuario = $this->conexion->DBConsulta("SELECT * FROM UsuarioLogin WHERE id = $idusuario");

        if ($usuario) {
            $passActual = hash("sha256", html_entity_decode($data['passActual']));
            
            if ($usuario['contrasena'] == $passActual) {
                $passNueva = hash("sha256", html_entity_decode($data['passNueva']));

                $cambiarPass = "UPDATE UsuarioLogin SET contrasena = ? WHERE id = ?";

                $execUpdatePass = $this->conexion->DBConsulta($cambiarPass, true, array($passNueva, $idusuario));

                if ($execUpdatePass) {
                    return Funciones::RespuestaJson(1, "Contraseña actualizado con éxito");
                } else {
                    return Funciones::RespuestaJson(2, "Error al actualizar la contraseña");
                }
            } else {
                return Funciones::RespuestaJson(2, "La contraseña actual no coincide con la aguardada en nuestro sistema");
            }
        }





        return Funciones::RespuestaJson(1, "", $_SESSION);
    }
}
