<?
class Funciones
{
    public static function RespuestaJson($estado = 3, $msj = "", $data = array())
    {
        $respuesta = new stdClass();
        $respuesta->estado = $estado;
        $respuesta->msj = $msj;
        $respuesta->data = $data;
        return $respuesta;
    }

    public static function Paginacion($totalItems = 100, $itemsForPage = 10, $pagina = 1)
    {
        $paginas = intval(ceil($totalItems / $itemsForPage));

        $paginacion = "<ul class='pagination'>";

        if ($paginas < 5) {
            for ($i = 0; $i < $paginas; $i++) {
                $paginacion .= "<li> <button type='button' class='btn btn-avanzar " . ($pagina == ($i + 1) ? 'active' : '') . "' data-pagina='" . ($i + 1) . "'>" . ($i + 1) . "</button> </li>";
            }
        } else if ($paginas >= 7) {
            if ($pagina < 3) {
                for ($i = 0; $i < 3; $i++) {
                    $paginacion .= "<li> <button type='button' class='btn btn-avanzar " . ($pagina == ($i + 1) ? 'active' : '') . "' data-pagina='" . ($i + 1) . "'>" . ($i + 1) . "</button> </li>";
                }
                $paginacion .= "<li> <button type='button' class='btn'>....</button></li>";
                $paginacion .= "<li> <button type='button' class='btn' data-pagina='" . ($pagina + 1) . "'>&gt;</button </li>";
                $paginacion .= "<li> <button type='button' class='btn' data-pagina='" . $paginas . "'>&gt;|</button> </li>";
            } else if (($paginas - 3) >= $pagina && $pagina >= 3) {
                $paginacion .= "<li> <button type='button' class='btn' data-pagina='1'>|&lt;</button> </li>";
                $paginacion .= "<li> <button type='button' class='btn' data-pagina='" . ($pagina - 1) . "'>&lt;</button </li>";
                $paginacion .= "<li> <button type='button' class='btn'>....</button></li>";
                for ($i = ($pagina - 2); $i < ($pagina + 1); $i++) {
                    $paginacion .= "<li> <button type='button' class='btn btn-avanzar " . ($pagina == ($i + 1) ? 'active' : '') . "' data-pagina='" . ($i + 1) . "'>" . ($i + 1) . "</button> </li>";
                }
                $paginacion .= "<li> <button type='button' class='btn'>....</button></li>";
                $paginacion .= "<li> <button type='button' class='btn' data-pagina='" . ($pagina + 1) . "'>&gt;</button </li>";
                $paginacion .= "<li> <button type='button' class='btn' data-pagina='" . $paginas . "'>&gt;|</button> </li>";
            } else {
                $paginacion .= "<li> <button type='button' class='btn' data-pagina='1'>|&lt;</button> </li>";
                $paginacion .= "<li> <button type='button' class='btn' data-pagina='" . ($pagina - 1) . "'>&lt;</button </li>";
                $paginacion .= "<li> <button type='button' class='btn'>....</button></li>";
                for ($i = ($paginas - 3); $i < ($paginas); $i++) {
                    $paginacion .= "<li> <button type='button' class='btn btn-avanzar " . ($pagina == ($i + 1) ? 'active' : '') . "' data-pagina='" . ($i + 1) . "'>" . ($i + 1) . "</button> </li>";
                }
            }
        }

        $paginacion .= '</ul>';

        return $paginacion;
    }

    public static function ArmarCorreo($cliente = "David Coello", $direcion = "Guasmo", $phone = "0987654321", $tabla = "", $footerInt = '')
    {
        $armarTablaFactura = '
        
        <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
  <tbody>
  <tr>
    <td align="center" valign="top"><table class="contenttable" border="0" cellpadding="0" cellspacing="0" width="600" bgcolor="#ffffff" style="border-width: 8px; border-style: solid; border-collapse: separate; border-color:#ececec; margin-top:40px; font-family:Arial, Helvetica, sans-serif">
        <tbody><tr>
          <td><table border="0" cellpadding="0" cellspacing="0" width="100%">
              <tbody>
                <tr>
                  <td width="100%" height="40">&nbsp;</td>
                </tr>
                <tr>
                  <td valign="top" align="center"><a href="farmaciasmegasalud.com"><img alt="" src="cid:logo_2u" width="272" style="padding-bottom: 0; display: inline !important;"></a></td>
                </tr>
                <tr>
                  <td width="100%" height="40">&nbsp;</td>
                </tr>
                <tr>
              </tr></tbody>
            </table></td>
        </tr>
        <tr>
          <td><table border="0" cellpadding="0" cellspacing="0" width="100%">
              <tbody>
                <tr>
                  <td bgcolor="#01a161" align="center" style="padding:16px 10px; line-height:24px; color:#ffffff; font-weight:bold; background: orange !important"> 
                    Hola '.$cliente.' <br>
                    ¡Gracias por su orden!
                    </td>
                </tr>
                <tr>
              </tr></tbody>
            </table></td>
        </tr>
        <tr>
          <td class="tablepadding" style="padding:20px; font-size:14px; line-height:20px;">Aquí tienes un resumen de tu compra. Cuando enviemos el artículo, enviaremos una actualización con detalles.</td>
        </tr>
        <tr>
          <td class="tablepadding" style="border-top:1px solid #eaeaea;border-bottom:1px solid #eaeaea;padding:13px 20px;"><table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
              <tbody>
                <tr>
  
                  <td style="font-size:13px; font-family:Arial, Helvetica, sans-serif; color:#676767" align="right"><span style="color:#707070">Fecha pedido: </span><span style="color:#000000;display:inline-block">'.( date("d-m-Y") ).'</span></td>
                </tr>
              </tbody>
            </table></td>
        </tr>
        <tr>
          <td><table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
              <tbody>
                <tr>
                  <td><table class="tablefull" width="50%" cellpadding="0" cellspacing="0" border="0" align="left">
                      <tbody>
                        <tr>
                          <td class="tablepadding" style="padding:20px"><table width="100%" align="left" cellpadding="0" cellspacing="0" border="0">
                              <tbody>
                                <tr>
                                  <td valign="top" width="40" style="padding:3px 0 0 0"><i class="fa fa-home fa-2x"></i></td>
                                  <td style="font-size:13.5px; font-family:Arial, Helvetica, sans-serif; line-height:1.5;color:#000000"><span style="color:#909090">Dirección de entrega</span><br>
                                    '.$cliente.'<br>
                                    '.$direcion.'
                                    </td>
                                </tr>
                              </tbody>
                            </table></td>
                        </tr>
                      </tbody>
                    </table>
                    <table class="tablefull" width="50%" cellpadding="0" cellspacing="0" border="0" align="left">
                      <tbody>
                        <tr>
                          <td class="tablepadding" style="padding:20px"><table width="100%" align="left" cellpadding="0" cellspacing="0" border="0">
                              <tbody>
                                <tr>
                                  <td valign="top" width="40" style="padding:3px 0 0 0"><img src="phone-icon.png" width="22" height="20" alt=""></td>
                                  <td style="font-size:13.5px; font-family:Arial, Helvetica, sans-serif; line-height:1.5;color:#000000"><span style="color:#909090">Número de telefono</span><br>
                                    '.$phone.'</td>
                                </tr>
                              </tbody>
                            </table></td>
                        </tr>
                      </tbody>
                    </table>
                    </td>
                </tr>
              </tbody>
            </table></td>
        </tr>
        <tr>
          <td class="tablepadding" style="padding:20px;"><table class="" style="border-collapse:collapse;width:100%;border-top:1px solid #dddddd;border-left:1px solid #dddddd;">
              <thead>
                <tr>
                  <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:left;padding:7px;color:#222222">#</td>
                  <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:left;padding:7px;color:#222222">Código</td>
                  <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:left;padding:7px;color:#222222">Producto</td>
                  <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:right;padding:7px;color:#222222">Aplicar Oferta</td>
                  <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:right;padding:7px;color:#222222">P. Unit</td>
                  <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:right;padding:7px;color:#222222">Cantidad</td>
                  <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:right;padding:7px;color:#222222">P. Total</td>
                </tr>
              </thead>
              <tbody>
                '.$tabla.'
              </tbody>
              <tfoot>
                '.$footerInt.'
              </tfoot>
            </table></td>
        </tr>
      </tbody></table></td>
  </tr>
</tbody></table>
        
        ';

        return $armarTablaFactura;
    }
}
