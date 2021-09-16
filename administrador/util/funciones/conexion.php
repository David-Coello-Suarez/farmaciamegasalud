<?
class Conexion
{
    private $motor;
    private $usuario;
    private $servidor;
    private $database;
    private $conexion;
    private $contrasena;

    public function __construct()
    {
        $this->motor = DBMOTOR;
        $this->servidor = DBHOST;
        $this->database = DBDATA;
        $this->usuario = DBUSUARIO;
        $this->contrasena = DBCLAVE;
    }

    public function DBConexion()
    {
        try {
            $pdo = new PDO($this->motor . ':host=' . $this->servidor . ';dbname=' . $this->database . ';', $this->usuario, $this->contrasena);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conexion = $pdo;
        } catch (PDOException $e) {
            // Funciones::logs(2, "DBConexion.txt", "Error de conexion => " . $e->getMessage());
            die("Error de conexión. " . $e);
        }
    }

    public function DBConsulta($sql, $tipo = false, $data = array())
    {
        try {
            $sqli = $this->conexion->prepare($sql);
            if ($tipo) {
                $data = $sqli->execute($data);
            } else {
                if ($tipo == false && intval(count($data)) > 0) {
                    $sqli->execute($data);
                    $data = $sqli->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    $sqli->execute();
                    $data = $sqli->fetch(PDO::FETCH_ASSOC);
                }
            }
            return $data;
        } catch (Exception $e) {
            // Funciones::logs(2, "DBConsulta.txt", "( " . $sql . " ) => " . $e->getMessage());
            die("Error de petición. (" . $sql . ") => " . $e->getMessage());
        }
    }


    public function UltimoInsert()
    {
        return $this->conexion->lastInsertId();
    }

    public function __destruct()
    {
        if ($this->conexion) {
            $this->conexion = null;
        }
    }
}
