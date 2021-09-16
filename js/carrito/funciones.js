$(document).ready(function () {
    Carrito()

    $("#tbodycarrito").on("click", '.btn-restar, .btn-sumar', function () {
        var cantidad = 0, pasar = false
        if ($(this).hasClass("btn-restar")) {
            var cantidadSelect = $(this).next("input[type=text]").val()
            if ((cantidadSelect - 1) > 0) {
                cantidad = (cantidadSelect - 1);
                $(this).next("input[type=text]").val(cantidad)
                pasar = true;
            } else {
                console.log("Elemento minimo a llevar es 1")
            }

        } else {
            cantidad = parseInt($(this).prev("input[type=text]").val()) + 1;
            $(this).prev("input[type=text]").val(cantidad)
            pasar = true;
        }

        var { carrito } = $(this).data();

        if (pasar) {
            $.ajax({
                url: "util/ajax/carrito.php",
                type: 'POST',
                dataType: 'json',
                data: {
                    metodo: "ACPC",
                    cantidad,
                    carrito
                },
                success: function (response) {
                    switch (response.estado) {
                        case 1:
                            Carrito()
                            ObtenerCarrito()
                            break;
                        case 2:
                            Swal.fire({
                                title: 'Stock no disponible',
                                text: response.msj,
                                icon: 'warning'
                            })
                            Carrito()
                            ObtenerCarrito()
                            break;
                    }
                }
            })
        }
    })

    $("#tbodycarrito").on("click", '.btn-eliminar', function () {
        var { carrito } = $(this).data();

        $.ajax({
            url: "util/ajax/carrito.php",
            type: 'POST',
            dataType: 'json',
            data: {
                metodo: 'EPC',
                carrito
            },
            // error: function (err) { console.log(err) },
            success: function (response) {
                switch (response.estado) {
                    case 1:
                        Carrito()
                        ObtenerCarrito()
                        break;
                }
            }
        })
    })
})

function Carrito() {
    $.ajax({
        url: "util/ajax/carrito.php",
        type: 'POST',
        dataType: 'json',
        data: {
            metodo: 'OCP',
        },
        // error: function (err) { console.log(err) },
        success: function (response) {
            switch (response.estado) {
                case 1:
                    var tbody = "", { data } = response;
                    data.carrito.map(function (item, index) {
                        tbody += `<tr>`
                        tbody += `<td class='text-center'>${index + 1}</td>`
                        tbody += `<td class='text-center'> <button type='button' class="btn btn-danger btn-eliminar" data-carrito="${parseInt(item['idcarrito'])}"> <i class='fa fa-trash'></i> </button> </td>`
                        tbody += `<td> <img src="administrador/${item['imagen']}?v=${new Date().getSeconds()}" alt="Imagen del producto" width=50 height=50/> </td>`
                        tbody += `<td> <a href="producto?id=${parseInt(item['id'])}">${item['nombre']}</a> </td>`
                        tbody += `<td> ${item['categoria']} </td>`
                        tbody += `<td> ${item['aplicaOferta'] ? 'Si' : 'No'} </td>`
                        tbody += `<td class='text-center'> $  <strong>${item['precio']}</strong> </td>`
                        tbody += `<td class='text-center'> <button type="button" class="btn btn-restar btn-danger btn-sm" title="Restar" data-carrito="${parseInt(item['idcarrito'])}">-</button> <input type="text" readonly value="${parseInt(item['cantidad'])}" style="width: 5rem"/> <button type="button" title="Sumar" class="btn btn-sumar btn-success btn-sm"data-carrito="${parseInt(item['idcarrito'])}">+</button> </td>`
                        tbody += `<td class='text-center'> $  <strong>${item['ptotal']}</strong> </td>`
                        tbody += `</tr>`
                    })

                    $("#tbodycarrito").html(tbody)
                    $(".subtotalc").html(`$ ${data.subtotal}`)
                    $(".ivac").html(`$ ${data.ivaSumado}`)
                    $(".totalc").html(`$ ${data.total}`)
                    break
                case 2:
                    $("#tbodycarrito").html(`<tr> <td  colspan="10"  style="padding: 2rem; text-align: center"> No hay productos </td> </tr>`)
                    $(".subtotalc").html(`$ 00.00`)
                    $(".ivac").html(`$ 00.00`)
                    $(".totalc").html(`$ 00.00`)
                    break;
            }
        }
    })
}