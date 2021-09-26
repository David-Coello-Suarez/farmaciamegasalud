<?
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
ini_set('display_startup_errors', 1);

include_once('../system/conexion.php');
include_once('../system/Funciones.php');
include_once('correo.php');

if (file_exists('../../config.php')) {
    include_once('../../config.php');
} else {
    include_once('../../../config.php');
}

date_default_timezone_set('America/Guayaquil');

class CheckOut
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion->DBConexion();
    }

    public function EnviarFactura($data)
    {
        session_start();
        $ids = session_id();
        $productos = $this->conexion->DBConsulta("SELECT c.cantidad, p.* FROM Carrito AS c INNER JOIN Productos AS p ON c.idproducto = p.id WHERE c.idusuario = ?", false, array($ids));

        $cuerpoInt = "";
        $footerInt = "";

        if (count($productos) > 0) {
            $cont = 1;
            $totalReceta = 0;
            foreach ($productos as $items) {
                $punit = 0;
                $pUnitT = 0;

                if (intval($items['cantidad']) >= intval($items['combo'])) {
                    $punit = number_format($items['precioUnitPromo'], 2);
                    $pUnitT = number_format($items['precioUnitPromo'], 2) * intval($items['cantidad']);

                    $totalReceta += $pUnitT;
                } else {
                    $punit = number_format($items['precionormal'], 2);
                    $pUnitT = number_format($items['precionormal'], 2) * intval($items['cantidad']);

                    $totalReceta += $pUnitT;
                }

                $cuerpoInt .= "
                        <tr> 
                            <td style='font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px'>$cont</td> 
                            <td style='font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px'>" . ($items['codigo']) . "</td> 
                            <td style='font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px'>" . html_entity_decode($items['nombre']) . "</td> 
                            <td style='font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px'>" . (intval($items['cantidad']) >= intval($items['combo']) ? 'Si' : 'No') . "</td> 
                            <td style='font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px'>$ " . ($punit) . "</td> 
                            <td style='font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px'>" . (intval($items['cantidad'])) . "</td> 
                            <td style='font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px'>$ " . (number_format($pUnitT, 2)) . "</td> 
                        </tr>
                    ";

                $cont++;
            }

            // OBTENE EL IVA 
            $impuesto = $this->conexion->DBConsulta("SELECT valor FROM Parametros WHERE nombre = 'iva'", false);
            $imp = $impuesto['valor'];

            $iva = number_format(($totalReceta * $imp), 2);

            $footerInt .= "
                    <tr>
                      <td colspan='6' style='font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px'><b>Sub-Total:</b></td>
                      <td style='font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px'>$ " . (number_format($totalReceta, 2)) . "</td>
                    </tr>
                    <tr>
                      <td colspan='6' style='font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7p'><b>I.V.A (" . ($imp * 100) . " %)</b></td>
                      <td style='font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px'>$ " . ($iva) . "</td>
                    </tr>
                    <tr>
                      <td colspan='6' style='font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px'><b>Total:</b></td>
                      <td style='font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px'>$ " . (number_format($totalReceta, 2) + $iva) . "</td>
                    </tr>
                ";
        }

        $cliente = $data['nombres'] . " " . $data['apellidos'];
        $direccion = $data['address'];
        $telefono = $data['movil'];
        $correoCliente = $data['email'];

        $retiro = "";

        if ($data['tipoRetiro'] == 2) {
            $ciudad = intval($data['ciudades']);
            $farmacia = intval($data['farmacias']);

            $ciudadSql = $this->conexion->DBConsulta("SELECT ciudad FROM Ciudades WHERE id = $ciudad");
            $farmaciaSql = $this->conexion->DBConsulta("SELECT direccion FROM Farmacia WHERE id = $farmacia");

            $retiro = "
                <tr>
                    <td  colspan='6'  style='font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px'>
                        Retiro se realiza en local
                    </td>
                </tr>
                <tr>
                    <td  colspan='6'  style='font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px'>
                        Ciudad de retiro: ".$ciudadSql['ciudad']."
                    </td>
                    <td  colspan='6'  style='font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px'>
                        Farmacia de retiro: ".$farmaciaSql['direccion']."
                    </td>
                </tr>
            ";
        }

        $retiro .= "
            <tr>
                <td  colspan='6'  style='font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px'>
                    ".$data['comments']."
                </td>
            </tr>
        ";

        $cuerpo = Funciones::ArmarCorreo($cliente, $direccion, $telefono, $cuerpoInt, $footerInt, $retiro);

        $correo = new Correo();
        $estado = $correo->EnviarCorreo('bodega@farmaciasmegasalud.com', $correoCliente, $cuerpo);

        if ($estado) {
            $total = 0;
            foreach ($productos as $item) {
                $id = intval($item['id']);
                $codigo = intval($item['codigo']);

                $nuevoStock = intval($item['stock']) - intval($item['cantidad']);

                $actualizarStock =  $this->conexion->DBConsulta("UPDATE Productos SET stock = ? WHERE codigo = ? AND id = ?", true, array($nuevoStock, $codigo, $id));

                if ($actualizarStock) {

                    $vaciarCarrito = $this->conexion->DBConsulta("DELETE FROM Carrito WHERE idusuario = ?", true, array($ids));

                    if ($vaciarCarrito) {
                        $total++;
                    }
                }
            }

            if ($total == count($productos)) {
                return Funciones::RespuestaJson(1, 'Correo Enviado');
            }
        } else {
            return Funciones::RespuestaJson(2, 'No Correo Enviado');
        }
    }
}
