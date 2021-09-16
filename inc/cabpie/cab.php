<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="img/ico.ico?v=<? echo $random ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" />

    <link rel="stylesheet" href="css/stylesheet.css?v=<? print_r($random) ?>" />
    <link rel="stylesheet" href="css/stylesheet-skin3.css?v=<? print_r($random) ?>" />

    <link rel="stylesheet" href="css/cabpie/owl.carousel.css?v=<? print_r($random) ?>" />

    <link rel="stylesheet" href="css/cabpie/style.css?v=<? print_r($random) ?>" />
    <link rel="stylesheet" href="css/<? print_r($pagina); ?>.css?v=<? print_r($random) ?>" />

    <title>Farmacia Mega Salud</title>
</head>

<body>

    <div class="wrapper-wide">
        <div id="header">
            <!-- Top Bar Start-->
            <nav id="top" class="htop">
                <div class="container">
                    <div class="row"> <span class="drop-icon visible-sm visible-xs"><i class="fa fa-align-justify"></i></span>
                        <div class="pull-left flip left-top">
                            <div class="links">
                                <ul>
                                    <li class="mobile"><i class="fa fa-phone"></i>+593 96 157 5000</li>
                                    <li class="email"><a href="mailto:info@farmaciamegasalud.com"><i class="fa fa-envelope"></i>info@farmaciamegasalud.com</a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- <div id="top-links" class="nav pull-right flip">
                            <ul>
                                <li><a href="login">Iniciar Session</a></li>
                                <li><a href="register">Registrate</a></li>
                            </ul>
                        </div> -->
                    </div>
                </div>
            </nav>
            <!-- Top Bar End-->
            <!-- Header Start-->
            <header class="header-row">
                <div class="container">
                    <div class="table-container">
                        <!-- Logo Start -->
                        <div class="col-table-cell col-lg-4 col-md-4 col-sm-12 col-xs-12 inner">
                            <div id="logo"><a href="inicio"><img class="img-responsive" src="img/icons-v2.png?v=<? print_r($random); ?>" title="Inicio" alt="Inicio"></a></div>
                        </div>
                        <!-- Logo End -->
                        <!-- Search Start-->
                        <div class="col-table-cell col-lg-5 col-md-5 col-md-push-0 col-sm-6 col-sm-push-6 col-xs-12">
                            <div id="search" class="input-group">
                                <input id="filter_name" type="text" name="search" value="" placeholder="Buscar...." class="form-control input-lg">
                                <button type="button" class="button-search"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <!-- Search End-->
                        <!-- Mini Cart Start-->
                        <div class="col-table-cell col-lg-3 col-md-3 col-md-pull-0 col-sm-6 col-sm-pull-6 col-xs-12 inner">
                            <div id="cart">
                                <button type="button" data-toggle="dropdown" data-loading-text="Loading..." class="heading dropdown-toggle"> <span class="cart-icon pull-left flip"></span> <span id="cart-total">0 item(s) - $0.00</span></button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <table class="table tbProducto">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        Imagen
                                                    </th>
                                                    <th>
                                                        Nombre producto
                                                    </th>
                                                    <th>
                                                        Aplica Oferta
                                                    </th>
                                                    <th>
                                                        P. Unit.
                                                    </th>
                                                    <th>
                                                        Cant.
                                                    </th>
                                                    <th>
                                                        P. Total
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody">
                                                <tr>
                                                    <td colspan="6" style="padding: 1.5rem; text-align:center">
                                                        No a seleccionado ningun producto del catalogo
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </li>
                                    <li>
                                        <div>
                                            <table class="table table-bordered detalleFactura">
                                                <tbody>
                                                    <tr>
                                                        <td class="text-right"><strong>Sub-Total</strong></td>
                                                        <td class="text-right subtotal">$ 0.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><strong>IVA (12%)</strong></td>
                                                        <td class="text-right iva">$ 0.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><strong>Total</strong></td>
                                                        <td class="text-right total">$ 0.00</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <p class="checkout"><a href="carrito" class="btn btn-warning"><i class="fa fa-shopping-cart"></i> Ver carrito</a>&nbsp;&nbsp;&nbsp;<a href="checkout" class="btn btn-warning"><i class="fa fa-share"></i> Checkout</a></p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Mini Cart End-->
                    </div>
                </div>
            </header>
            <!-- Header End-->
            <!-- Main Menu Start-->
            <nav id="menu" class="navbar">
                <div class="container">
                    <div class="navbar-header"> <span class="visible-xs visible-sm"> Menu <b></b></span></div>
                    <div class="collapse navbar-collapse navbar-ex1-collapse">
                        <ul class="nav navbar-nav">
                            <li><a class="home_link" title="Home" href="inicio"><span>Home</span></a></li>
                            <li class="dropdown sub"><a>Comprar por categorías</a>
                                <div class="dropdown-menu">
                                    <ul id="listaCategoria">
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a href="turnos">Nuestras Farmacias</a>
                            </li>

                            <li class="contact-link"><a href="contactanos">Contactenos</a></li>
                            <!-- <li class="custom-link-right"><a href="#" target="_blank">Ofertas especiales</a></li> -->
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Main Menu End-->
        </div>
        <div id="container">
            <div class="container">