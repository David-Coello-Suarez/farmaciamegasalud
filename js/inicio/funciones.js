$(document).ready(function () {
    ListarProductos()

    $(".productosCatalogo").on('click', 'button[type=button]', function () {
        var { idproducto } = $(this).data()

        // sumarUno(+1)
        AnadirCarrito(idproducto)
    })

})

function ListarProductos() {
    $.ajax({
        url: 'util/ajax/producto.php',
        type: 'POST',
        dataType: 'json',
        data: {
            metodo: 'LPW'
        },
        // error: function (error) { console.log(error) },
        success: function (response) {
            switch (response.estado) {
                case 1:
                    var { categoria } = response.data, tarjetas = ""

                    categoria.map(function (item) {

                        tarjetas += `
                            <h3 class="subtitle">${item['nombre']}</h3>
                            <div class="owl-carousel product_carousel" >
                        `
                        item['productos'].map(function (item) {

                            tarjetas += `
                                <div class="owl-item" >
                                    <div class="product-thumb clearfix">
                                        <div class="image"><a href="javascript:;"><img src="administrador/${item['imagen']}?v=${new Date().getMilliseconds()}" alt="jhonson-aceite" title="jhonson-aceite" class="img-responsive"></a></div>
                                        <div class="caption">
                                            <h4><a href="javascript:;">${item['nombre']}</a></h4>
                                            <p class="price">
                                                <span class="price-new">$ ${item['precioUnitPromo'] || '00.00'}</span>
                                                <span class="price-old">$ ${(item['precionormal'])}</span>
                                                <span class="saving">-${item['descuento']}%</span>
                                            </p>
                                            <!-- <div class="rating"> <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span> <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span> <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span> <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span> <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span> </div> -->
                                        </div>
                                        <div class="button-group">
                                            <button class="btn-primary" type="button" data-idproducto="${parseInt(item['id'])}"><span>Añadir al carrito</span></button>
                                        </div>
                                    </div>
                                </div>
                            `
                        })

                        tarjetas += `  
                            </div>
                        `
                    })

                    $(".productosCatalogo").html(tarjetas)
                    break;
            }
        },
        complete: function () {
            $(".productosCatalogo>.owl-carousel.product_carousel").owlCarousel({
                itemsCustom: [[320, 1], [600, 2], [768, 3], [992, 5], [1199, 5]],
                lazyLoad: true,
                navigation: true,
                navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                scrollPerPage: true
            });
        }
    })
}