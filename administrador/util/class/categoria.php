<?
include_once("../funciones/conexion.php");
include_once("../funciones/Funciones.php");

if (file_exists("../../config.php")) {
    include_once("../../config.php");
} else {
    include_once("../../../config.php");
}

date_default_timezone_set("America/Guayaquil");

class Categoria
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion->DBConexion();
    }

    public function ListarCategoriaWeb()
    {
        $categoria = $this->conexion->DBConsulta("SELECT * FROM Categorias WHERE estado = ?", false, array(1));

        if (count($categoria) > 0) {
            array_unshift($categoria, array('id' => 0, 'nombre' => "Seleccione la categoria"));

            return Funciones::RespuestaJson(1, "", $categoria);
        } else {
            return Funciones::RespuestaJson(2, "No hay categoria disponible");
        }
    }

    public function ListarCategorias($pagina, $items)
    {
        $totalCategorias = $this->conexion->DBConsulta("SELECT COUNT(*) AS total FROM Categorias", false);

        if (intval($totalCategorias['total']) > 0) {

            $inicia = intval(intval($pagina - 1) * $items);

            $categorias = $this->conexion->DBConsulta("SELECT * FROM Categorias LIMIT $inicia, $items", false, array(1));

            $cont = intval($inicia + 1);
            $itemInt = array();

            foreach ($categorias as $item) {
                $item['pos'] = $cont;

                if ($item['updatedAt'] == null) {
                    $item['updatedAt'] = "";
                }

                $cont++;
                $itemInt[] = $item;
            }

            $del = intval($inicia + 1);
            $al = intval($cont - 1);
            $total = intval($totalCategorias['total']);
            $paginas = intval(ceil($total / $items));
            $paginas = $paginas . (($paginas == 1) ? " Página" : 'Páginas');

            $data['mostrar'] = "Mostrando del $del al $al de $total ($paginas)";
            $data['categorias'] = $itemInt;
            $data['paginacion'] = Funciones::Paginacion(intval($totalCategorias['total']), $items, $pagina);

            return Funciones::RespuestaJson(1, "", $data);
        } else {
            return Funciones::RespuestaJson(2, "No hay categoria disponible");
        }
    }

    public function ActualizarCategoria($data)
    {
        $id = intval($data['id']);
        $estado = intval($data['estado']);
        $date = date("Y-m-d H:i:s");

        $sql = "UPDATE Categorias SET estado = ?, updatedAt = ?  WHERE id = ?";
        $actualizarEstado = $this->conexion->DBConsulta($sql, true, array($estado, $date, $id));

        if ($actualizarEstado) {
            return Funciones::RespuestaJson(1, "Actualizado con éxito");
        } else {
            return Funciones::RespuestaJson(2, "Error al actualizar");
        }
    }

    public function ObtenerCategoria($idcategoria)
    {
        $categoria = $this->conexion->DBConsulta("SELECT * FROM Categorias WHERE id = $idcategoria");
        if ($categoria) {
            $data['categoria'] = $categoria;
            return Funciones::RespuestaJson(1, "", $data);
        } else {
            return Funciones::RespuestaJson(2, "No existe categoria");
        }
    }

    public function ActualizarCategoriaSeleccionada($data)
    {
        $i = 0;
        $id = intval($data['idcategoria']);
        $fecha = date("Y-m-d H:i:s");
        $nombre = htmlentities($data['nombre'][$i]);
        $descripcion = htmlentities($data['descripcion'][$i]);

        $sql = "UPDATE Categorias SET nombre = ?, descripcion = ?, updatedAt = ? WHERE id = ?";

        $update = $this->conexion->DBConsulta($sql, true, array($nombre, $descripcion, $fecha, $id));

        if ($update) {
            return Funciones::RespuestaJson(1);
        } else {
            return Funciones::RespuestaJson(2, "Error al actualizar");
        }
    }

    public function NuevaCategoria($data)
    {
        $sql = "INSERT INTO Categorias (nombre, descripcion) VALUES (?,?)";
        $total = 0;

        for ($i = 0; $i < count($data['nombre']); $i++) {
            $nombre = htmlentities($data['nombre'][$i]);
            $descripcion = htmlentities($data['descripcion'][$i]);

            $guardar = $this->conexion->DBConsulta($sql, true, array($nombre, $descripcion));

            if ($guardar) {
                $total++;
            }
        }

        if ($total == count($data['nombre'])) {
            return Funciones::RespuestaJson(1);
        } else {
            return Funciones::RespuestaJson(2, "Error al guardar");
        }
    }
}
