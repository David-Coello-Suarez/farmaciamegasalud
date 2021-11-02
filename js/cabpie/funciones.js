$(document).ready(function () {
    listarBanner()

    $('#menu .navbar-header > span').on("click", function () {
        $(this).toggleClass("active");
        $("#menu .navbar-collapse").slideToggle('medium');
        return false;
    });



    /*---------------------------------------------------
   Scroll to top
----------------------------------------------------- */
    $(function () {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 150) {
                $('#back-top').fadeIn();
            } else {
                $('#back-top').fadeOut();
            }
        });
    });
    $('#back-top').on("click", function () {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        return false;
    });


    /*---------------------------------------------------
       Main Menu
   ----------------------------------------------------- */
    $('#menu .nav > li > .dropdown-menu').each(function () {
        var menu = $('#menu .nav.navbar-nav').offset();
        var dropdown = $(this).parent().offset();

        var i = (dropdown.left + $(this).outerWidth()) - (menu.left + $('#menu .nav.navbar-nav').outerWidth());

        if (i > 0) {
            $(this).css('margin-left', '-' + (i + 5) + 'px');
        }
    });

    var $screensize = $(window).width();
    $('#menu .nav > li, #header .links > ul > li').on("mouseover", function () {

        if ($screensize > 991) {
            $(this).find('> .dropdown-menu').stop(true, true).slideDown('fast');
        }
        $(this).bind('mouseleave', function () {

            if ($screensize > 991) {
                $(this).find('> .dropdown-menu').stop(true, true).css('display', 'none');
            }
        });
    });
    $('#menu .nav > li div > ul > li').on("mouseover", function () {
        if ($screensize > 991) {
            $(this).find('> div').css('display', 'block');
        }
        $(this).bind('mouseleave', function () {
            if ($screensize > 991) {
                $(this).find('> div').css('display', 'none');
            }
        });
    });
    $('#menu .nav > li > .dropdown-menu').closest("li").addClass('sub');

    // Clearfix for sub Menu column
    $(document).ready(function () {
        $screensize = $(window).width();
        if ($screensize > 1199) {
            $('#menu .nav > li.mega-menu > div > .column:nth-child(6n)').after('<div class="clearfix visible-lg-block"></div>');
        }
        if ($screensize < 1199) {
            $('#menu .nav > li.mega-menu > div > .column:nth-child(4n)').after('<div class="clearfix visible-lg-block visible-md-block"></div>');
        }
    });
    $(window).resize(function () {
        $screensize = $(window).width();
        if ($screensize > 1199) {
            $("#menu .nav > li.mega-menu > div .clearfix.visible-lg-block").remove();
            $('#menu .nav > li.mega-menu > div > .column:nth-child(6n)').after('<div class="clearfix visible-lg-block"></div>');
        }
        if ($screensize < 1199) {
            $("#menu .nav > li.mega-menu > div .clearfix.visible-lg-block").remove();
            $('#menu .nav > li.mega-menu > div > .column:nth-child(4n)').after('<div class="clearfix visible-lg-block visible-md-block"></div>');
        }
    });

    // Clearfix for Brand Menu column
    $(document).ready(function () {
        $screensize = $(window).width();
        if ($screensize > 1199) {
            $('#menu .nav > li.menu_brands > div > div:nth-child(12n)').after('<div class="clearfix visible-lg-block"></div>');
        }
        if ($screensize < 1199) {
            $('#menu .nav > li.menu_brands > div > div:nth-child(6n)').after('<div class="clearfix visible-lg-block visible-md-block"></div>');
        }
        if ($screensize < 991) {
            $("#menu .nav > li.menu_brands > div > .clearfix.visible-lg-block").remove();
            $('#menu .nav > li.menu_brands > div > div:nth-child(4n)').after('<div class="clearfix visible-lg-block visible-sm-block"></div>');
            $('#menu .nav > li.menu_brands > div > div:last-child').after('<div class="clearfix visible-lg-block visible-sm-block"></div>');
        }
        if ($screensize < 767) {
            $("#menu .nav > li.menu_brands > div > .clearfix.visible-lg-block").remove();
            $('#menu .nav > li.menu_brands > div > div:nth-child(2n)').after('<div class="clearfix visible-lg-block visible-xs-block"></div>');
            $('#menu .nav > li.menu_brands > div > div:last-child').after('<div class="clearfix visible-lg-block visible-xs-block"></div>');
        }
    });
    $(window).resize(function () {
        $screensize = $(window).width();
        if ($screensize > 1199) {
            $("#menu .nav > li.menu_brands > div > .clearfix.visible-lg-block").remove();
            $('#menu .nav > li.menu_brands > div > div:nth-child(12n)').after('<div class="clearfix visible-lg-block"></div>');
        }
        if ($screensize < 1199) {
            $("#menu .nav > li.menu_brands > div > .clearfix.visible-lg-block").remove();
            $('#menu .nav > li.menu_brands > div > div:nth-child(6n)').after('<div class="clearfix visible-lg-block visible-md-block"></div>');
        }
        if ($screensize < 991) {
            $("#menu .nav > li.menu_brands > div > .clearfix.visible-lg-block").remove();
            $('#menu .nav > li.menu_brands > div > div:nth-child(4n)').after('<div class="clearfix visible-lg-block visible-sm-block"></div>');
            $('#menu .nav > li.menu_brands > div > div:last-child').after('<div class="clearfix visible-lg-block visible-sm-block"></div>');
        }
        if ($screensize < 767) {
            $("#menu .nav > li.menu_brands > div > .clearfix.visible-lg-block").remove();
            $('#menu .nav > li.menu_brands > div > div:nth-child(4n)').after('<div class="clearfix visible-lg-block visible-xs-block"></div>');
            $('#menu .nav > li.menu_brands > div > div:last-child').after('<div class="clearfix visible-lg-block visible-xs-block"></div>');
        }
    });


    /*---------------------------------------------------
        Product List
    ----------------------------------------------------- */
    $('#list-view').on("click", function () {
        $(".products-category > .clearfix.visible-lg-block").remove();
        $('#content .product-layout').attr('class', 'product-layout product-list col-xs-12');
        localStorage.setItem('display', 'list');
        // $('.btn-group').find('#list-view').addClass('selected');
        // $('.btn-group').find('#grid-view').removeClass('selected');

        $('.btn-group').find('#list-view').removeClass('selected');
        $('.btn-group').find('#grid-view').addClass('selected');
        return false;
    });

    /*---------------------------------------------------
       Product Grid
    ----------------------------------------------------- */
    $('#grid-view').on('click', function (e) {
        $('#content .product-layout').attr('class', 'product-layout product-grid col-lg-3 col-md-3 col-sm-4 col-xs-12');

        localStorage.setItem('display', 'grid');
        // $('.btn-group').find('#grid-view').addClass('selected');
        // $('.btn-group').find('#list-view').removeClass('selected');

        $('.btn-group').find('#grid-view').removeClass('selected');
        $('.btn-group').find('#list-view').addClass('selected');


    });


    if (localStorage.getItem('display') == 'list') {
        $('#list-view').trigger('click');
    } else {
        $('#grid-view').trigger('click');
    }

    ListarCategoriasCab()

    var message = "",
        hora = new Date().getHours()

    if (hora < 6) {
        message = "Buenos dias ....";
    } else if (hora < 12) {
        message = "Buenas tardes ..."
    } else if (hora > 19) {
        message = "Buenas noches ..."
    }

    $('#WABoton').floatingWhatsApp({
        phone: $("#contactWS").val().replace('', ' '), // Número WhatsApp Business
        popupMessage: 'Hola 👋 ¿Cómo podemos ayudarte?', // Mensaje pop up
        message, // Mensaje por defecto
        showPopup: true, // Habilita el pop up
        headerTitle: 'WhatsApp Chat', // Título del header
        headerColor: '#25D366', // Color del header
        buttonImage: '<img src="https://rawcdn.githack.com/rafaelbotazini/floating-whatsapp/3d18b26d5c7d430a1ab0b664f8ca6b69014aed68/whatsapp.svg" />', // Icono WhatsApp
        size: '50px', // Tamaño del icono
        position: "right", // Posición del icono
        avatar: 'https://www.w3schools.com/howto/img_avatar.png', // URL imagen avatar
        avatarName: 'Farmacias Mega Salud', // Nombre del avatar
        avatarRole: 'Soporte', // Rol del avatar
        zIndex: '99999',
    });
});


function ListarCategoriasCab() {
    $.ajax({
        url: 'util/ajax/categoria.php',
        type: 'POST',
        dataType: 'json',
        data: {
            metodo: 'LCWA'
        },
        error: function (err) { console.log(err) },
        success: function (response) {
            switch (response.estado) {
                case 1:
                    var lista = "", { data } = response
                    data.map(function (item) {
                        lista += ` <li> <a href="categoria?id=${item['id']}">${item['nombre']}</a> </li> `;
                    })

                    $("#listaCategoria").html(lista);
                    break;
            }
        },
        complete: function () {
            ObtenerCarrito();
        }
    })
}

function ObtenerCarrito() {
    $.ajax({
        url: 'util/ajax/carrito.php',
        type: 'POST',
        dataType: 'json',
        data: {
            metodo: 'OCP'
        },
        error: function (err) { console.log(err) },
        success: function (response) {
            switch (response.estado) {
                case 1:
                    var tbody = "", { data } = response, cont = 0
                    data.carrito.map(function (item) {
                        tbody += `<tr>`
                        tbody += `<td class="text-left"><a href="producto?id=${parseInt(item['id'])}"><img class="img-thumbnail" width="50px" title="${item['nombre']}" src="administrador/${item['imagen']}?v=${new Date().getMilliseconds()}"></a></td>`
                        tbody += `<td class="text-center"><a href="producto?id=${parseInt(item['id'])}">${item['nombre']}</a></td>`
                        tbody += `<td class="text-center">${item['aplicaOferta'] ? 'Si' : 'No '}</td>`
                        tbody += `<td class="text-center">$ ${item['precio']}</td>`
                        tbody += `<td class="text-center">${item['cantidad']}</td>`
                        tbody += `<td class="text-center">$ ${item['ptotal']}</td>`
                        tbody += `</tr>`
                        cont++;
                    })
                    $("#tbody").html(tbody)
                    $(".subtotal").html(`$ ${data.subtotal}`)
                    $(".iva").html(`$ ${data.ivaSumado}`)
                    $(".total").html(`$ ${data.total}`)
                    $("#cart-total").html(`${cont} item(s) - $ ${data.total}`)
                    break;
                case 2:
                    $("#tbody").html(`<tr> <td colspan="10" style="padding: 1.5rem; text-align: center"> No hay producto</td> </tr>`)
                    $(".subtotal").html(`$ 00.00`)
                    $(".iva").html(`$ 00.00`)
                    $(".total").html(`$ 00.00`)
                    $("#cart-total").html(`0 item(s) - $ 00.00`)
                    break;
                    break;
            }
        }
    })
}

// AÑADIR AL CARRITO 
function AnadirCarrito(idproducto) {
    $.ajax({
        url: "util/ajax/carrito.php",
        type: 'POST',
        dataType: 'json',
        data: {
            metodo: "APC",
            idproducto,
        },
        // error: function (err) { console.log(err) },
        success: function (response) {
            switch (response.estado) {
                case 1:
                    ObtenerCarrito()
                    break;
                case 2:
                    Swal.fire({
                        title: response.msj,
                        text: 'Desea agregar otro ?',
                        icon: 'info',
                        confirmButtonText: 'Si'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var { id, cantidad } = response.data
                            ActulizarCantProd(id, cantidad)
                        } else {
                            ObtenerCarrito()
                        }
                    })
                    break
            }
        }
    })
}

function ActulizarCantProd(idcarrito, cantidad) {
    $.ajax({
        url: "util/ajax/carrito.php",
        type: 'POST',
        dataType: 'json',
        data: {
            metodo: "APCA",
            idcarrito,
            cantidad
        },
        // error: function (err) { console.log(err) },
        success: function (response) {
            switch (response.estado) {
                case 1:
                    ObtenerCarrito()
                    break;
                case 2:
                    Swal.fire({
                        title: 'Stock no disponible',
                        text: response.msj,
                        icon: 'warning'
                    })
                    break;
            }
        }
    })
}

const listarBanner = () => {
    $.ajax({
        url: 'util/ajax/banner.php',
        type: 'POST',
        dataType: 'json',
        data: {
            metodo: 'CBP'
        },
        error: function (err) { console.log(err) },
        success: function (response) {

            var { estado, data } = response

            switch (estado) {
                case 1:
                    let { bannersP } = data, bannerdiv = "";

                    bannersP.map((item) => {
                        bannerdiv += `
                        <div class="item"> <a href="javascript:;"><img class="img-responsive" src="administrador/${item['imagen']}?v=${new Date().getMilliseconds()}" alt="banner 1" /></a></div>
                        `
                    })

                    $(".slideshow").html(bannerdiv)
                    break
            }
        },
        complete: function () {
            $('.slideshow').owlCarousel({
                items: 6,
                autoPlay: 3000,
                singleItem: true,
                navigation: true,
                navigationText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
                pagination: false
            });

            listarBannerSecundario();
        }
    })

}

const listarBannerSecundario = () => {
    $.ajax({
        url: 'util/ajax/banner.php',
        type: 'POST',
        dataType: 'json',
        data: {
            metodo: 'CBS'
        },
        error: function (err) { console.log(err) },
        success: function (response) {
            
            var { estado, data } = response

            switch (estado) {
                case 1:
                    let { bannersS } = data, bannerdiv = "";

                    bannersS.map((item) => {
                        bannerdiv += `
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> <a href="#"><img title="sample-banner1" alt="sample-banner1" src="administrador/${item['imagen']}?v=${new Date().getMilliseconds()}"></a></div>
                        `
                    })

                    $(".seconds").html(bannerdiv)
                    break
            }
        },
    })
}