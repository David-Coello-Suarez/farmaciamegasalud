<!-- Breadcrumb Start-->
<ul class="breadcrumb">
    <li><a href="inicio"><i class="fa fa-home"></i></a></li>
    <li><a href="<? echo $pagina?>"><? echo ucfirst($pagina) ?></a></li>
</ul>
<!-- Breadcrumb End-->

<div class="row">
    <!--Middle Part Start-->
    <div id="content" class="col-sm-9">
        <h1 class="title">Contáctenos</h1>
        <h3 class="subtitle">Nuestra ubicación</h3>
        <div class="row">
            <div class="col-sm-4">
                <div class="contact-info">
                    <div class="contact-info-icon"><i class="fa fa-map-marker"></i></div>
                    <div class="contact-detail">
                        <h4>Guayaquil</h4>
                        <address>
                            <?
                                echo $parametro['direccionLocal']
                            ?>
                        </address>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="contact-info">
                    <div class="contact-info-icon"><i class="fa fa-phone"></i></div>
                    <div class="contact-detail">
                        <h4>Telefono</h4>
                        Telefóno: <? echo $parametro['contacto'] ?><br>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="contact-info">
                    <div class="contact-info-icon"><i class="fa fa-clock-o"></i></div>
                    <div class="contact-detail">
                        <h4>Los horarios de apertura</h4>
                        Lun. - Vier. <br/>
                        8:00 a 16:00
                    </div>
                </div>
            </div>
        </div>
        <form class="form-horizontal">
            <fieldset>
                <h3 class="subtitle">Envianos un email</h3>
                <div class="form-group required">
                    <label class="col-md-2 col-sm-3 control-label" for="input-name">Tu nombre</label>
                    <div class="col-md-10 col-sm-9">
                        <input type="text" name="name" value="" id="input-name" class="form-control" />
                    </div>
                </div>
                <div class="form-group required">
                    <label class="col-md-2 col-sm-3 control-label" for="input-email">Dirección de E-Mail</label>
                    <div class="col-md-10 col-sm-9">
                        <input type="text" name="email" value="" id="input-email" class="form-control" />
                    </div>
                </div>
                <div class="form-group required">
                    <label class="col-md-2 col-sm-3 control-label" for="input-enquiry">Consulta</label>
                    <div class="col-md-10 col-sm-9">
                        <textarea name="enquiry" rows="10" id="input-enquiry" class="form-control"></textarea>
                    </div>
                </div>
            </fieldset>
            <div class="buttons">
                <div class="pull-right">
                    <input class="btn btn-primary" type="submit" value="Enviar" />
                </div>
            </div>
        </form>
    </div>
    <!--Middle Part End -->
</div>