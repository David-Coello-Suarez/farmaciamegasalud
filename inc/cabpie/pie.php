</div>
</div>
<!--Footer Start-->
<footer id="footer">
    <div class="fpart-first">
        <div class="container">
            <div class="row">
                <div class="contact col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <h5>Detalles de contacto</h5>
                    <ul>
                        <li class="address"><i class="fa fa-map-marker"></i><? echo $parametro['direccionLocal'] ?></li>
                        <li class="mobile"><i class="fa fa-phone"></i><? echo $parametro['contacto'] ?></li>
                        <li class="email"><i class="fa fa-envelope"></i>Enviar correo electrónico a través de nuestra <a href="mailto:<? echo $parametro['correoInfo'] ?>">Contacta con nosotros</a>
                    </ul>
                </div>
                <div class="column col-lg-2 col-md-2 col-sm-3 col-xs-12">
                    <h5>Información</h5>
                    <ul>
                        <li><a href="nosotros">Sobre Nosotros</a></li>
                        <li><a href="turnos">Turnos</a></li>
                        <!-- <li><a href="about-us.html">Privacy Policy</a></li>
                           <li><a href="about-us.html">Terms &amp; Conditions</a></li> -->
                    </ul>
                </div>
                <div class="column col-lg-2 col-md-2 col-sm-3 col-xs-12">
                    <h5>Servicio al cliente</h5>
                    <ul>
                        <li><a href="contactanos">Contáctenos</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="fpart-second">
        <div class="container">
            <div id="powered" class="clearfix">
                <div class="powered_text pull-left flip">
                    <p><a href="https://www.instagram.com/rohi_os/?hl=es" >CopyRigth © <? print_r(date("Y")); ?> Rohi Os</a></p>
                </div>
                <div class="" style="width: 100%; text-align:center"> 
                    <a href="https://www.facebook.com/farmaciasMegaSalud/" target="_blank"> 
                        <img data-toggle="tooltip" src="img/social/facebook.png?v=<? print_r($random) ?>" alt="Facebook" title="Facebook" width="40px">
                    </a> 
                    <a href="https://www.instagram.com/farmaciasmegasalud/?utm_medium=copy_link" target="_blank">
                         <img data-toggle="tooltip"width="40px"  src="https://www.masdemascotitas.com/wp-content/uploads/2020/11/instagram-mas-de-mascotitas-mx.png?v=<? print_r($random) ?>" alt="Instagram" title="Instagram"> 
                    </a> 
                </div>
            </div>
        </div>
    </div>
    <div id="WABoton"></div>
    <div id="back-top"><a data-toggle="tooltip" title="Back to Top" href="javascript:void(0)" class="backtotop"><i class="fa fa-chevron-up"></i></a></div>
</footer>
<!--Footer End-->
</div>

<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" language="javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script type="text/javascript" language="javascript" src="js/accordion.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>

<script type="text/javascript" language="javascript" src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript" language="javascript" src="js/cabpie/funciones.js?v=<? print_r($random); ?>"></script>
<?
if (file_exists("js/$pagina/funciones.js")) {
    echo "<script type='text/javascript' language='javascript' src='js/$pagina/funciones.js?v=$random'></script>";
}
?>
<!-- Enlazar JS Floating WhatsApp -->
<script type="text/javascript" src="https://rawcdn.githack.com/jerfeson/floating-whatsapp/0310b4cd88e9e55dc637d1466670da26b645ae49/floating-wpp.min.js"></script>
</body>

</html>