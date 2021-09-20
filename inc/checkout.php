<!-- Breadcrumb Start-->
<ul class="breadcrumb">
    <li><a href="inicio"><i class="fa fa-home"></i></a></li>
    <li><a href="<? echo $pagina ?>"><? echo ucfirst($pagina) ?></a></li>
</ul>
<!-- Breadcrumb End-->

<div class="row">
    <!--Middle Part Start-->
    <form id="ConfirmarPedido">
        <div id="content" class="col-sm-12">
            <h1 class="title">Checkout</h1>
            <div class="row">
                <div class="col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><i class="fa fa-user"></i> Detalla tus datos personales</h4>
                        </div>
                        <div class="panel-body">
                            <fieldset id="account">
                                <div class="form-group required">
                                    <label for="input-payment-firstname" class="control-label">Nombres</label>
                                    <input type="text" class="form-control req" id="input-payment-firstname" placeholder="Nombres" value="" name="nombres">
                                </div>
                                <div class="form-group required">
                                    <label for="input-payment-lastname" class="control-label">Apellidos</label>
                                    <input type="text" class="form-control req" id="input-payment-lastname" placeholder="Apellidos" value="" name="apellidos">
                                </div>
                                <div class="form-group required">
                                    <label for="input-payment-email" class="control-label">Correo Eletr&oacute;nico</label>
                                    <input type="text" class="form-control req" id="input-payment-email" placeholder="Correo Eletr&oacute;nico" value="" name="email">
                                </div>
                                <div class="form-group required">
                                    <label for="input-payment-telephone" class="control-label">M&oacute;vil</label>
                                    <input type="text" class="form-control req" id="input-payment-telephone" placeholder="M&oacute;vil" value="" name="movil">
                                </div>
                                <div class="form-group">
                                    <label for="input-payment-fax" class="control-label">Fijo</label>
                                    <input type="text" class="form-control" id="input-payment-fax" placeholder="Fijo" value="" name="fijo">
                                </div>
                                <div class="form-group required">
                                    <label for="input-payment-address-1" class="control-label">Direcci&oacute;n</label>
                                    <input type="text" class="form-control req" id="input-payment-address-1" placeholder="Direcci&oacute;n" value="" name="address">
                                </div>
                            </fieldset>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><i class="fa fa-motorcycle"></i> Retiro en</h4>
                        </div>
                        <div class="panel-body">
                            <fieldset id="address" class="required">
                                <div class="form-group required">
                                    <label for="input-payment-country" class="control-label">Donde desea retirar su pedido</label>
                                    <select class="form-control" id="input-payment-country" name="tipoRetiro">
                                        <option value="1" selected>Enviar a domicilio</option>
                                        <option value="2">Retiro en local</option>
                                    </select>
                                </div>

                                <div class="form-group ciudades"></div>

                                <div class="form-group farmacias"></div>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><i class="fa fa-shopping-cart"></i> Shopping cart</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <td class="text-center">#</td>
                                                    <td class="text-center">Imagen</td>
                                                    <td class="text-left">Nombre Producto</td>
                                                    <td class="text-left">Cantidad</td>
                                                    <td class="text-right">Aplica Oferta</td>
                                                    <td class="text-right">Precio Unitario</td>
                                                    <td class="text-right">Total</td>
                                                </tr>
                                            </thead>
                                            <tbody class="carritoCheck">
                                                <tr>
                                                    <td class="p-3 text-center" colspan="10">
                                                        No ha seleccionado productos
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4 col-sm-offset-8">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <td class="text-right"><strong>Sub-Total:</strong></td>
                                                        <td class="text-right subtotalc">$ 0.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right impuesto"><strong>I.V.A. (12%):</strong></td>
                                                        <td class="text-right ivac">$ 0.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><strong>Total:</strong></td>
                                                        <td class="text-right totalc">$ 0.00</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><i class="fa fa-pencil"></i> Añadir comentarios sobre su pedido</h4>
                                </div>
                                <div class="panel-body">
                                    <textarea rows="4" class="form-control" id="confirm_comment" name="comments"></textarea>
                                    <br>
                                    <label class="control-label" for="confirm_agree">
                                        <input type="checkbox" checked="checked" value="1" required="" class="validate required" id="confirm_agree" name="confirm agree">
                                        <span> He leído y acepto los <a class="agree" href="#"><b>Terminos &amp; Condiciones</b></a></span> </label>
                                    <div class="buttons">
                                        <div class="pull-right">
                                            <input type="submit" class="btn btn-primary" id="button-confirm" value="Confirmar orden">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--Middle Part End -->
</div>