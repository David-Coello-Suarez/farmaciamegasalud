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

    public static function ArmarCorreo()
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
                  <td valign="top" align="center"><a href="#"><img alt="" src="logo.png" width="272" style="padding-bottom: 0; display: inline !important;"></a></td>
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
                  <td bgcolor="#01a161" align="center" style="padding:16px 10px; line-height:24px; color:#ffffff; font-weight:bold"> Hi Jhone Cary<br>
                    Thank you for your order! </td>
                </tr>
                <tr>
              </tr></tbody>
            </table></td>
        </tr>
        <tr>
          <td class="tablepadding" style="padding:20px; font-size:14px; line-height:20px;">Here,s a summary of your purchase. When we ship the item, we will send an update with details.</td>
        </tr>
        <tr>
          <td class="tablepadding" style="border-top:1px solid #eaeaea;border-bottom:1px solid #eaeaea;padding:13px 20px;"><table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
              <tbody>
                <tr>
                  <td style="font-size:13px; font-family:Arial, Helvetica, sans-serif; color:#676767"><span style="color:#707070">Order ID: </span><a style="outline:none; color:#01a161; text-decoration:none;" href="#">13841888912</a></td>
                  <td style="font-size:13px; font-family:Arial, Helvetica, sans-serif; color:#676767" align="right"><span style="color:#707070">Placed on: </span><span style="color:#000000;display:inline-block">21 Jun, 2016</span></td>
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
                                  <td valign="top" width="40" style="padding:3px 0 0 0"><img src="home-icon.png" width="22" height="20" alt=""></td>
                                  <td style="font-size:13.5px; font-family:Arial, Helvetica, sans-serif; line-height:1.5;color:#000000"><span style="color:#909090">Delivery Address</span><br>
                                    Jhone Cary<br>
                                    A-205, Central Square<br>
                                    12 National Road<br>
                                    New Delhi<br>
                                    India</td>
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
                                  <td style="font-size:13.5px; font-family:Arial, Helvetica, sans-serif; line-height:1.5;color:#000000"><span style="color:#909090">Phone Number</span><br>
                                    (+91) 9898989898</td>
                                </tr>
                              </tbody>
                            </table></td>
                        </tr>
                      </tbody>
                    </table>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="left">
                      <tbody>
                        <tr>
                          <td class="tablepadding" style="border-top:1px solid #eaeaea;border-bottom:1px solid #eaeaea;padding:13px 20px;font-size:13.5px; font-family:Arial, Helvetica, sans-serif; line-height:1.5;color:#676767"><table width="100%" align="left" cellpadding="0" cellspacing="0" border="0">
                              <tbody>
                                <tr>
                                  <td><span style="color:#909090">Payment Type</span></td>
                                  <td align="right"><span style="color:#000000">by PayPal</span></td>
                                </tr>
                              </tbody>
                            </table></td>
                        </tr>
                      </tbody>
                    </table></td>
                </tr>
              </tbody>
            </table></td>
        </tr>
        <tr>
          <td class="tablepadding" style="padding:20px;"><table class="" style="border-collapse:collapse;width:100%;border-top:1px solid #dddddd;border-left:1px solid #dddddd;">
              <thead>
                <tr>
                  <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:left;padding:7px;color:#222222">Product</td>
                  <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:right;padding:7px;color:#222222">Qty</td>
                  <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:right;padding:7px;color:#222222">Price</td>
                  <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:right;padding:7px;color:#222222">Total</td>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px">Xitefun Causal Wear Fancy Shoes <br>
                    <span style="font-size:11px; color:#555;">Model: Product 114</span></td>
                  <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px">1</td>
                  <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px">$750.00</td>
                  <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px">$750.00</td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="3" style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px"><b>Sub-Total:</b></td>
                  <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px">$750.00</td>
                </tr>
                <tr>
                  <td colspan="3" style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px"><b>Flat Shipping Rate:</b></td>
                  <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px">$5.00</td>
                </tr>
                <tr>
                  <td colspan="3" style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px"><b>Total:</b></td>
                  <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px">$755.00</td>
                </tr>
              </tfoot>
            </table></td>
        </tr>
        <tr>
          <td><table width="100%" cellspacing="0" cellpadding="0" border="0" style="font-size:13px;color:#555555; font-family:Arial, Helvetica, sans-serif;">
              <tbody>
                <tr>
                  <td class="tablepadding" align="center" style="font-size:14px; line-height:22px; padding:20px; border-top:1px solid #ececec;"> Any Questions? Get in touch with our 24x7 Customer Care team.<br>
                    <a href="#" style="background-color:#01a161; color:#ffffff; padding:6px 20px; font-size:14px; font-family:Arial, Helvetica, sans-serif; text-decoration:none; display:inline-block; text-transform:uppercase; margin-top:10px;">Help</a></td>
                </tr>
                <tr> </tr>
              </tbody>
            </table></td>
        </tr>
        <tr>
          <td bgcolor="#fcfcfc" class="tablepadding" style="padding:20px 0; border-top-width:1px;border-top-style:solid;border-top-color:#ececec;border-collapse:collapse"><table width="100%" cellspacing="0" cellpadding="0" border="0" style="font-size:13px;color:#999999; font-family:Arial, Helvetica, sans-serif">
              <tbody>
                <tr>
                  <td align="center" class="tablepadding" style="line-height:20px; padding:20px;"> Marketshop Template, Unit 11, Central Square, Near <br>
                    National Highway, California, United States </td>
                </tr>
                <tr> </tr>
              </tbody>
            </table>
            <table align="center">
              <tbody><tr>
                <td style="padding-right:10px; padding-bottom:9px;"><a href="#" target="_blank" style="text-decoration:none; outline:none;"><img src="facebook.png" width="32" height="32" alt=""></a></td>
                <td style="padding-right:10px; padding-bottom:9px;"><a href="#" target="_blank" style="text-decoration:none; outline:none;"><img src="twitter.png" width="32" height="32" alt=""></a></td>
                <td style="padding-right:10px; padding-bottom:9px;"><a href="#" target="_blank" style="text-decoration:none; outline:none;"><img src="google_plus.png" width="32" height="32" alt=""></a></td>
                <td style="padding-right:10px; padding-bottom:9px;"><a href="#" target="_blank" style="text-decoration:none; outline:none;"><img src="pinterest.png" width="32" height="32" alt=""></a></td>
              </tr>
            </tbody></table></td>
        </tr>
      </tbody></table></td>
  </tr>
  <tr>
    <td><table width="100%" cellspacing="0" cellpadding="0" border="0" style="font-size:13px;color:#999999; font-family:Arial, Helvetica, sans-serif">
        <tbody>
          <tr>
            <td class="tablepadding" align="center" style="line-height:20px; padding:20px;"> 2016 MarketShop Template All Rights Reserved. </td>
          </tr>
          <tr> </tr>
        </tbody>
      </table></td>
  </tr>
</tbody></table>
        
        ';

        return $armarTablaFactura;
    }
}
