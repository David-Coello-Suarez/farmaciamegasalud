<?
include_once("../funciones/conexion.php");
include_once("../funciones/Funciones.php");

if (file_exists("../../config.php")) {
    include_once("../../config.php");
} else {
    include_once("../../../config.php");
}

class Usuario
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion->DBConexion();
    }

    public function ListarUsuarios($pagina = 1, $itemsForPage = 10)
    {
        $sql = "SELECT mb.id, mb.nombres, mb.apellidos, mb.fechaNacimiento, mb.movil, ul.usuario, ul.estado
        FROM UsuarioLogin AS ul
        INNER JOIN Miembros AS mb
        ON ul.idmiembro = mb.id";

        $totalItems = count($this->conexion->DBConsulta($sql, false, array(1)));

        if ($totalItems > 0) {
            $inicia = intval(($pagina - 1) * $itemsForPage);

            $sql .= " LIMIT $inicia, $itemsForPage";

            $consultarLimite = $this->conexion->DBConsulta($sql, false, array(1));

            $items = array();
            $cont = $inicia + 1;
            foreach ($consultarLimite as $item) {
                $item['numeral'] = $cont;
                $item['id'] = intval($item['id']);

                $items[] = $item;
                $cont++;
            }

            $paginas = intval(ceil($totalItems / $itemsForPage));

            $paginasInt = $paginas . ($paginas == 1 ? " Página" : ' Páginas');

            $data['usuarios'] = $items;
            $data['mostar'] = "Mostrando del " . ($inicia + 1) . " al " . ($cont - 1) . " de " . $totalItems . " ( $paginasInt ) ";
            $data['paginacion'] = Funciones::Paginacion($totalItems, $itemsForPage, $pagina);
            return Funciones::RespuestaJson(1, "", $data);
        } else {
            $data['mostar'] = "Mostrando del 0 al 0 de 0 ( 0 Páginas )";
            return Funciones::RespuestaJson(2, "No hay productos para mostrar", $data);
        }
    }

    public function CambiarEstado($id, $estado)
    {
        $sql = "UPDATE UsuarioLogin SET estado = ?, updatedAt = now() WHERE idmiembro = ?";

        $confirmarEstado = $this->conexion->DBConsulta($sql, true, array($estado, $id));

        if ($confirmarEstado) {
            return Funciones::RespuestaJson(1);
        } else {
            return Funciones::RespuestaJson(2, "Error al cambiar de estado");
        }
    }

    public function ObtenerUsuario($id)
    {
        $sql = "SELECT mb.id, mb.nombres, mb.apellidos, mb.fechaNacimiento, mb.movil, ul.usuario, ul.estado
        FROM UsuarioLogin AS ul
        INNER JOIN Miembros AS mb
        ON ul.idmiembro = mb.id WHERE ul.idmiembro = $id";

        $buscarUsuario = $this->conexion->DBConsulta($sql);

        if ($buscarUsuario) {
            $buscarUsuario['usuario'] = html_entity_decode($buscarUsuario['usuario']);
            $buscarUsuario['nombres'] = html_entity_decode($buscarUsuario['nombres']);
            $buscarUsuario['apellidos'] = html_entity_decode($buscarUsuario['apellidos']);

            $data['usuario'] = $buscarUsuario;
            return Funciones::RespuestaJson(1, "", $data);
        } else {
            return Funciones::RespuestaJson(2, "No hay usuario");
        }
    }

    public function ActualizarUsuario($data)
    {
        $id = intval($data['idusuario']);
        $nombres = htmlentities($data['nombres']);
        $usuario = htmlentities($data['usuario']);
        $apellidos = htmlentities($data['apellidos']);
        $fechaNac = date("Y-m-d", strtotime($data['fechaNac']));
        $movil = $data['movil'];

        $sql = "UPDATE Miembros SET nombres = ?, apellidos = ?, fechaNacimiento = ?, movil = ?, updatedAt = now() WHERE id = ?";

        $execUpdate = $this->conexion->DBConsulta($sql, true, array($nombres, $apellidos, $fechaNac, $movil, $id));

        if ($execUpdate) {
            $sqlUsuario = "UPDATE UsuarioLogin SET usuario = ?, updatedAt = now() WHERE idmiembro = ?";

            $execUsuario = $this->conexion->DBConsulta($sqlUsuario, true, array($usuario, $id));

            if ($execUsuario) {
                return Funciones::RespuestaJson(1, "Éxito al actualizar");
            } else {
                return Funciones::RespuestaJson(2, "Error al actualizar");
            }
        } else {
            return Funciones::RespuestaJson(2, "Error al actualizar los datos");
        }
    }

    public function CrearUsuario($data)
    {

        if (self::CalcularEdad($data)) {
            $nombres = htmlentities($data['nombres']);
            $usuario = htmlentities($data['usuario']);
            $apellidos = htmlentities($data['apellidos']);
            $movil = $data['movil'];
            $fechaNac =  date("Y-m-d", strtotime($data['fechaNac']));

            $sqlGuardar = "INSERT INTO Miembros (nombres, apellidos, movil, fechaNacimiento, createdAt) 
                            VALUES(?, ?, ?, ?, now())";

            $execGuardar = $this->conexion->DBConsulta($sqlGuardar, true, array($nombres, $apellidos, $movil, $fechaNac));

            if ($execGuardar) {
                $id = $this->conexion->UltimoInsert();

                $rol = isset($data['rol']) ? intval($data['rol']) : 1;
                $password = hash('sha256', isset($data['contrasena']) ? $data['contrasena'] : '12345');
                $passwordmsj = isset($data['contrasena']) ? $data['contrasena'] : '12345';

                $sqlGuardarUsuario = "INSERT INTO UsuarioLogin ( idrol, idmiembro, usuario, contrasena, createdAt)
                                    VALUES(?,?,?,?,Now())";

                $execGuardarUsuario = $this->conexion->DBConsulta($sqlGuardarUsuario, true, array($rol, $id, $usuario, $password));

                if ($execGuardarUsuario) {
                    $dataInt['contrasena'] = "La contraseña del usuario '$usuario' es '$passwordmsj' ";
                    return Funciones::RespuestaJson(1, "Usuario creado", $dataInt);
                }
            } else {
                return Funciones::RespuestaJson(2, "Error al crear el nuevo usuario");
            }
        } else {
            return Funciones::RespuestaJson(2, "Edad no permitida");
        }
    }

    private static function CalcularEdad($data): bool
    {
        date_default_timezone_set("America/Guayaquil");

        $fechaNac = date("Y-m-d", strtotime($data['fechaNac']));

        $fechaNacUsuario = new DateTime($fechaNac);
        $fechaActual = new DateTime();

        $anios = $fechaActual->diff($fechaNacUsuario);

        if (intval($anios->y) >= 18) {
            return true;
        }

        return false;
    }
}
