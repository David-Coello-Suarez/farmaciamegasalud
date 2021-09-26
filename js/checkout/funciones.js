$(document).ready(function () {

    $("#input-payment-country").on('change', function () {
        var id = Number($(this).val())

        if (id == 2) {
            var data = { metodo: 'OTC' }

            $.ajax({
                url: 'util/ajax/turnos.php',
                type: 'POST',
                dataType: 'json',
                data,
                // error: function (err) { console.log(err) },
                success: function (response) {
                    var { estado, msj, data } = response,
                        flagdisabled = 'disabled',
                        option = "",
                        select = ""

                    switch (estado) {
                        case 1:
                            var { ciudades } = data
                            flagdisabled = ""
                            ciudades.map(function (item) {
                                option += `<option value='${item['id']}' ${item['id'] == 0 ? 'selected' : ''}>${item['ciudad']}</option>`
                            })
                            break
                        case 2:
                            option = "<option>No hay ciudad disponible</option>";
                            break
                    }

                    select += `<label for="input-payment-country1" class="control-label">Seleccione su ciudad</label>
                        <select class="form-control ciudades" id="input-payment-country1" ${flagdisabled} name="ciudades">
                        ${option}
                        </select>
                    `
                    $(".ciudades").html(select)
                }
            })
        } else {
            $(".ciudades,.farmacias").empty()
        }

    })

    $(".ciudades").on("change", 'select.ciudades', function () {
        var id = $(this).val();

        if (id > 0) {
            var data = { id, metodo: 'OTF' }
            $.ajax({
                url: 'util/ajax/turnos.php',
                type: 'POST',
                dataType: 'json',
                data,
                // error: function (err) { console.log(err) },
                success: function (response) {
                    var { estado, msj, data } = response,
                        flagdisabled = 'disabled',
                        option = ""

                    switch (estado) {
                        case 1:
                            var { farmacias } = data
                            flagdisabled = ""
                            farmacias.map(function (item) {
                                option += `<option value='${item['id']}' ${item['id'] == 0 ? 'selected' : ''}>${item['direccion']}</option>`
                            })
                            break
                        case 2:
                            option = "<option>No hay farmacias disponibles</option>";
                            break
                    }

                    var select = `<label for="input-payment-country12" class="control-label">Seleccione la farmacia a la cual va a retirar</label>
                        <select class="form-control farmacias" id="input-payment-country12" ${flagdisabled} name="farmacias">
                        ${option}
                        </select>
                    `
                    $(".farmacias").html(select)
                }
            })
        } else {
            alert("Debe seleccionar la ciudad")
        }
    })

    $("#ConfirmarPedido").submit(function () {
        var confirmarPedido = false

        try {
            $(this).find("input[type=text].req").each(function (index, item) {

                if ($(item).val() == "") {
                    $(item).css({ 'border': '1px solid red' })
                    throw "Todos los campos son necesarios";
                } else {
                    $(item).css({ 'border': '1px solid #ccc' })
                }
            })
            confirmarPedido = !confirmarPedido
        } catch (e) {
            alert(e)
        }

        if (confirmarPedido) {
            var formData = new FormData($(this)[0])
            formData.append("metodo", 'EP')

            $.ajax({
                url: 'util/ajax/checkout.php',
                type: 'POST',
                dataType: 'Json',
                data: formData,
                cahce: false,
                processData: false,
                contentType: false,
                error: function (err) { console.log(err) },
                success: function (response) {
                    console.log(response)
                    var {estado} = response
                    switch(estado){
                        case 1:
                            alert("Pedido realizado con exito");
                            window.location = "";
                            break
                    }
                }
            })
        }

        return false;
    })

    CargarCarrito()
})

function CargarCarrito() {
    $.ajax({
        url: "util/ajax/carrito.php",
        type: 'POST',
        dataType: 'json',
        data: {
            metodo: 'OCP',
        },
        // error: function (err) { console.log(err) },
        success: function (response) {
            var { estado, msj, data } = response

            switch (estado) {
                case 1:
                    var tbody = "", { carrito, iva, ivaSumado, subtotal, total } = data

                    carrito.map(function (item, index) {
                        tbody += `
                            <tr>
                                <td>
                                    ${index + 1}
                                </td>
                                <td class="text-center">
                                    <a href="producto?id=${Number(item['id'])}">
                                        <img src="administrador/${item['imagen']}?v=${new Date().getSeconds()}" alt="${item['nombre']}" title="${item['nombre']}" class="img-thumbnail" width='50'>
                                    </a>
                                </td>
                                <td class="text-center">
                                    ${item['nombre']}
                                </td>
                                <td class="text-center">
                                    ${item['cantidad']}
                                </td>
                                <td class="text-center">
                                    <strong>${item['aplicaOferta'] ? 'Si' : 'No'}</strong>
                                </td>
                                <td class="text-center">
                                    $  <strong>${item['precio']}</strong> 
                                </td>
                                <td class="text-center">
                                    $  <strong>${item['ptotal']}</strong> 
                                </td>
                            </tr>                        
                        `
                    })

                    $(".carritoCheck").html(tbody)
                    $(".subtotalc").html(`$ ${subtotal}`)
                    $(".ivac").html(`$ ${ivaSumado}`)
                    $(".totalc").html(`$ ${total}`)
                    $(".impuesto").html(`<strong>I.V.A. (${iva * 100} %):</strong>`)
                    break;
            }
        }
    })
}