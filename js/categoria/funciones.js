$(document).ready(function () {
    var params = new URLSearchParams(location.search), id = params.get('id');
    LimiteItems(id)

    $("#input-limit").on('change', function () {
        Productos(id, 1, parseInt($(this).val()))
    })

    $(".paginacion").on("click", ".btn-avanzar", function () {
        var { pagina } = $(this).data(),
            limite = parseInt($("#input-limit :selected").val())

        Productos(id, pagina, limite)
    })

    // CARRITO
    $(".products-category").on("click", ".anadir", function () {
        var { idp } = $(this).data()

        AnadirCarrito(idp)
    })
})

function LimiteItems(id) {
    var item = 0
    $.ajax({
        url: "util/ajax/producto.php",
        type: 'POST',
        dataType: 'json',
        data: {
            metodo: "CLC",
            params: "numeroItems"
        },
        // error: function (err) { console.log(err) },
        success: function (response) {
            switch (response.estado) {
                case 1:
                    var selectOption = "", i = 0, value = response.data.numero;
                    item = response.data.numero;

                    for (i; i < 3; i++) {
                        var selected = ""
                        if (i == 0) {
                            selected = "selected"
                        }

                        selectOption += `<option value="${value}" ${selected}>${value}</option>`

                        value = parseInt(value) + response.data.numero
                    }
                    selectOption += `<option value='0'>Todos</option>`
                    $("#input-limit").html(selectOption)
                    break;
            }
        },
        complete: function () {
            Productos(id, 1, item)
        }
    })
}

function Productos(id, pagina = 1, limite) {
    $.ajax({
        url: "util/ajax/producto.php",
        type: 'POST',
        dataType: 'json',
        data: {
            metodo: 'LCP',
            id,
            pagina,
            limite
        },
        // error: function (err) { console.log(err) },
        success: function (response) {   
            switch (response.estado) {
                case 1:
                    var cardProd = "",
                        { data } = response,
                        vista = "product-layout product-list col-xs-12"


                    if (localStorage.getItem("display") == "grid") {
                        vista = "product-layout product-grid col-lg-3 col-md-3 col-sm-4 col-xs-12";
                    }

                    data.productos.map(function (item) {
                        cardProd += `
                            <div class="${vista}">
                                <div class="product-thumb">
                                    <div class="image"><a href="producto?id=${parseInt(item['id'])}"><img src="administrador/${item['imagen']}?v=${new Date().getSeconds()}" width="200" heigth="200" alt="${item['descripcion']}" title="${item['descripcion']}" class="img-responsive" /></a></div>
                                    <div>
                                        <div class="caption">
                                            <h4><a href="producto?id=${parseInt(item['id'])}">${item['nombre']}</a></h4>
                                            <p class="price"> 
                                                <span class="price-new">$ ${item['precioUnitPromo'] || '00.00'}</span>
                                                <span class="price-old">$ ${item['precionormal']}</span>
                                                <span class="saving">-${item['descuento']}%</span>
                                                <span class="price-tax">Stock: ${item['stock']}</span> 
                                            </p>
                                            <span class="price-tax">Descuento aplica a partir de ${item['combo']} productos </span>
                                        </div>
                                        <div class="button-group">
                                            <button class="btn-primary anadir" type="button" data-idp="${parseInt(item['id'])}" ><span>AÑADIR AL CARRITO</span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `
                    })
                    $(".products-category").html(cardProd)
                    $(".paginacion").html(data.paginacion)
                    $(".mostrar").html(data.mostrando)
                    break;
            }
        },
        complete: function () {
            ListarCategorias(id)
        }
    })
}

function ListarCategorias(id = 1) {
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
                    var categorias = "", { data } = response, nombreCategoria = ""

                    data.map(function (item) {
                        categorias += `
                            <li>
                                <a class="${id == parseInt(item['id']) && 'active'}" href="categoria?id=${item['id']}">${item['nombre']}</a> </span>
                            </li>
                        `
                        if (id == parseInt(item['id'])) {
                            nombreCategoria = item['nombre']
                        }
                    })

                    $(".titulo, .tituloC").html(nombreCategoria)
                    $(".categoriasMenu").html(categorias)
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