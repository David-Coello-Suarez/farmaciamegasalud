$(document).ready(function () {
    ObtenerSelected(ObtenerListas)
    ListarCategoria()

    // AÑADIR PRODUCTOS
    $("#agregarmas").on('click', function (event) {
        event.preventDefault()
        var tarjeta = $(".fila .tarjeta:last")

        tarjeta.clone().appendTo(".fila")

        FormatearTarjeta()
    })

    // GUARDAR PRODUCTOS
    $("#formProductos").submit(function (event) {
        event.preventDefault();
        var guardar = false
        try {
            $("input[type=number]").each(function (index, item) {
                if ($(item).val() < 0) {
                    $(item).toggleClass("is-invalid")
                    throw 'Debe llenar correctamente los campos'
                }
            })

            $("textarea").each(function (index, item) {
                if ($(item).val() == "") {
                    $(item).toggleClass("is-invalid")
                    throw 'Debe llenar correctamente los campos'
                }
            })

            $("select#categoria").each(function (index, item) {
                if (parseInt($(item).val()) == 0 || $(item).val() == null) {
                    $(item).toggleClass("is-invalid")
                    throw 'Debe seleccionar la categoria'
                } else {
                    $(item).toggleClass("is-valid")
                }
            })

            if (parseInt($("#idproducto").val()) == 0) {
                $("input[type=file]").each(function (index, item) {
                    if ($(item).val() == "") {
                        throw 'Debe seleccionar la imagen'
                    }
                })
            }

            guardar = !guardar
        } catch (error) {
            Swal.fire({
                icon: 'warning',
                text: `${error}`,
                confirmButtonText: 'Cerrar'
            })
        }

        if (guardar) {
            var formData = new FormData($(this)[0])

            if (parseInt($("#idproducto").val()) > 0) {
                formData.append('metodo', 'APC')
            } else {
                formData.append('metodo', 'CNP')
            }

            $.ajax({
                url: 'util/ajax/producto.php',
                type: 'POST',
                dataType: 'json',
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                error: function (error) { console.log(error) },
                beforeSend: function () {
                    $("#guardar").html("Procesando..!!").prop({ disabled: true })
                },
                success: function (response) {
                    // console.log(response)
                    switch (response.estado) {
                        case 1:
                            Swal.fire({
                                icon: 'success',
                                text: `${response.msj}`,
                                confirmButtonText: 'Cerrar'
                            })
                            LimpiarForm()
                            var items = parseInt($("#selectedItems :selected").val());
                            var { pagina } = $(this).data()
                            ObtenerListas(items, pagina)
                            break;
                        case 2:
                            Swal.fire({
                                icon: 'info',
                                text: `${response.msj}`,
                                confirmButtonText: 'Cerrar'
                            })
                            var data = response.data
                            $(".fila").find(".tarjeta").each(function (index, item) {
                                var codigo = parseInt($(item).find("input#codigo").val());

                                if (parseInt(data[index]['codigo']) != codigo) {
                                    $(item).remove()
                                }
                            })
                            $("#guardar").html("Guardar").prop({ disabled: false })
                            break;
                        default:
                            Swal.fire({
                                icon: 'warning',
                                text: `${response.mensaje}`,
                                confirmButtonText: 'Iniciar Session'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location()
                                } else {
                                    window.location();
                                }
                            })
                            break;
                    }
                }
            })
        }

        return false
    })

    $(".fila").on('change', 'input[type=file]', function () {
        CargarImage(this)
    })

    // CAMBIAR DE ESTADO
    $('.tbodyProducto').on('click', '#flexSwitchCheckChecked', function () {
        var data = $(this).data()

        if (data.estado == 1) {
            data.estado = 0
        } else {
            data.estado = 1
        }

        data.metodo = 'AEP'

        $.ajax({
            url: 'util/ajax/producto.php',
            data,
            type: 'POST',
            dataType: 'json',
            error: function (error) { console.log(error) },
            success: function (response) {
                switch (response.estado) {
                    case 1:
                        ObtenerListas();
                        break;
                    case 2:
                        Swal.fire({
                            icon: 'warning',
                            text: `${response.mensaje}`,
                            confirmButtonText: 'Iniciar Session'
                        })
                        break;
                }
            }
        })
    });

    // EDITAR PRODUCTO
    $(".tbodyProducto").on('click', 'button[type=button]', function () {
        var data = $(this).data()
        data.metodo = "OP"

        $.ajax({
            url: 'util/ajax/producto.php',
            type: 'POST',
            dataType: 'json',
            data,
            // error: function (error) { console.log(error) },
            success: function (response) {
                switch (response.estado) {
                    case 1:
                        var { codigo, combo, descuento, id, imagen, nombre, precioDescue, precionormal, stock, idcategoria } = response.data;

                        $("input#codigo").val(parseInt(codigo)).prop({ readonly: true })
                        $("input#combo").val(combo)
                        $("input#descuento").val(descuento).prop({ disabled: false })
                        $("input#idproducto").val(parseInt(id))
                        $("img#imgproducto").attr({ src: `${imagen}?v=${new Date().getTime()}` })
                        $("textarea#nombre").val(nombre)
                        $("input#oferta").val(precioDescue)
                        $("input#pvp").val(precionormal)
                        $("input#stock").val(stock)
                        $(`select#categoria option[value=${parseInt(idcategoria)}]`).prop({ selected: true })

                        $("button#agregarmas").prop({ disabled: true })

                        $("button#editarproducto-tab").tab("show")
                        break;
                }
            }
        })
    })

    // SELECCIONAR ITEMS
    $("#selectedItems").change(function () {
        var items = parseInt($(this).val())
        ObtenerListas(items, 1)
    })

    // PAGINA CLICK
    $(".pagination").on('click', 'a.page-link', function () {
        var items = parseInt($("#selectedItems :selected").val());
        var { pagina } = $(this).data()
        ObtenerListas(items, pagina)
    })
})

// FUNCION PARA VACIAR FORMULARIO
function LimpiarForm() {
    $("#idproducto").val(0)
    $("#formProductos").trigger("reset");
    $("button#listaproducto-tab").tab("show")
    $("#guardar").html("Guardar").prop({ disabled: false })
    $("img#imgproducto").attr({ src: `img/producto/no-producto.png?v=${new Date().getTime()}` })

    $(".fila").find(".tarjeta").each(function (index, item) {
        if (index == 0) {
            $(item).find("input[type=number], textarea, input[type=file]").val('')
            $(item).find("input#descuento").prop({ 'disabled': true })

            $(item).find("input#oferta").val("")

            $(item).find('img,input[type=file]').attr({ 'data-input': index })

            $(item).find("img").attr({ src: `img/producto/no-producto.png?v=${new Date().getSeconds()}` })
        } else {
            $(item).remove()
        }
    })
}

// LISTAR PRODUCTOS
function ObtenerListas(items, pagina = 1) {
    $.ajax({
        url: 'util/ajax/producto.php',
        type: 'POST',
        dataType: 'json',
        data: {
            metodo: 'OLP',
            items,
            pagina
        },
        success: function (response) {
            switch (response.estado) {
                case 1:
                    var { paginacion, mostar, producto } = response.data, tbody = ""
                    producto.map(function (item) {
                        var desc = item['descuento']
                        var descuentoFT = String(desc).split('.');

                        if (parseInt(descuentoFT[1]) > 0 && parseInt(descuentoFT[0]) == 0) {
                            desc = (desc * 100);
                            var lengtdecimal = String(desc).split('.')
                            lengtdecimal.pop()
                            if (lengtdecimal.length == 0) {
                                var aux = desc.toFixed(0)
                                desc = aux
                            } else {
                                var aux = desc.toFixed(2)
                                desc = aux
                            }
                        }

                        tbody += `
                            <tr>
                                <td>
                                    ${item['numeral']}
                                </td>
                                <td>
                                    <button type='button' data-id=${parseInt(item['id'])} data-codigo=${parseInt(item['codigo'])} class='btn btn-sm btn-success'>
                                        Editar
                                    </button>
                                </td>
                                <td style="cursor: pointer;">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" class="check" type="checkbox" id="flexSwitchCheckChecked" data-id=${parseInt(item['id'])} data-codigo=${parseInt(item['codigo'])} data-estado=${parseInt(item['estado'])} ${parseInt(item['estado']) == 1 ? 'checked' : ''}>
                                        <label class="form-check-label" for="flexSwitchCheckChecked">${parseInt(item['estado']) == 1 ? 'Activo' : 'Inactivo'}</label>
                                    </div>
                                </td>
                                <td>
                                    ${parseInt(item['codigo'])}
                                </td>
                                <td>
                                    <img src='${item['imagen']}?v=${new Date().getSeconds()}' width='75' class="img-thumbnail"/>
                                </td>
                                <td>
                                    ${item['nombre']}
                                </td>
                                <td>
                                    ${item['categoria']}
                                </td>
                                <td>
                                    ${parseInt(item['stock'])}
                                </td>
                                <td>
                                    ${parseInt(item['combo'])}
                                </td>
                                <td>
                                    $ ${item['precionormal']}
                                </td>
                                <td>
                                    ${desc} %
                                </td>
                                <td>
                                    $ ${item['precioDescue']}
                                </td>
                            </tr>
                        `
                    })

                    $(".tbodyProducto").html(tbody)
                    $(".pagination").html(paginacion)
                    $(".mostrar").html(mostar)
                    break;
                case 2:
                    $(".tbodyProducto").html(`<tr> <td colspan="20" class="text-center p-3"> No hay productos </td>  </tr>`)
                    $(".pagination").empty()
                    $(".mostrar").html(mostar)
                    break;
            }
        }
    })
}

// VACIAR NUEVA TARJETA
function FormatearTarjeta() {

    var total = parseInt($(".fila").find(".tarjeta").length)

    $(".fila").find(".tarjeta").each(function (index, item) {

        if (total == parseInt(index + 1)) {
            $(item).find("input[type=number], textarea, input[type=file]").val('')
            $(item).find("input#descuento").prop({ 'disabled': true })

            $(item).find("input#oferta").val("")

            $(item).find('img,input[type=file]').attr({ 'data-input': index })

            $(item).find("img").attr({ src: `img/producto/no-producto.png?v=${new Date().getSeconds()}` })
        } else {

            $(item).find('img,input[type=file]').attr({
                'data-input': index,
            })

        }
    })
}

// LISTAR CATEGORIA
function ListarCategoria() {
    $.ajax({
        url: 'util/ajax/categoria.php',
        type: 'POST',
        dataType: 'json',
        data: {
            metodo: 'LCA',
        },
        success: function (response) {
            switch (response.estado) {
                case 1:
                    var option = "", { data } = response
                    data.map(function (item) {
                        option += `<option value="${parseInt(item['id'])}" ${parseInt(item['id']) == 0 ? 'disabled selected' : ''
                            }> ${item['nombre']}</option>`
                    })
                    $("select#categoria").html(option)
                    break;
                case 2:
                    $("select#categoria").html(`< option > ${response.mensaje}</option > `).prop({ 'disabled': true })
                    break
            }
        }
    })
}

// HABILITAR DESCUENTO
function habilitarDesc(elemento) {
    var combo = parseInt($(elemento).val())

    if (combo > 1) {
        $(elemento).parent().parent().parent().parent().find("input#descuento").prop({ 'disabled': false })
    } else {
        $(elemento).parent().parent().parent().parent().find("input#descuento").prop({ 'disabled': true })
    }
}

// CALCULAR OFERTA
function calcularOferta(elemento) {
    var oferta = ($(elemento).val());

    if (oferta > 0) {

        var precioNormal = ($(elemento).parent().parent().parent().parent().find("input#pvp").val())

        if (precioNormal > 0) {
            var combo = parseInt($(elemento).parent().parent().parent().parent().find("input#combo").val())

            var subtotal = (precioNormal * combo)

            var descuentoDecimal = (oferta / 100)

            var restardescuento = (subtotal * descuentoDecimal)

            var ofertaFinal = (subtotal - restardescuento).toFixed(2);

            $(elemento).parent().parent().parent().parent().find("input#oferta").val(ofertaFinal)
        } else {
            Swal.fire({
                icon: 'warning',
                text: `El precio de venta al publico no ha sido establecido`,
                confirmButtonText: 'Cerrar'
            })
        }
    } else {
        $(elemento).parent().parent().parent().parent().find("input#oferta").val('0.00')
    }
}


// VALIDACION DE NUMERO
function filterFloat(evt, input) {
    // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
    var key = window.Event ? evt.which : evt.keyCode;
    var chark = String.fromCharCode(key);
    var tempValue = input.value + chark;
    if (key >= 48 && key <= 57) {
        if (filter(tempValue) === false) {
            return false;
        } else {
            return true;
        }
    } else {
        if (key == 8 || key == 13 || key == 0) {
            return true;
        } else if (key == 46) {
            if (filter(tempValue) === false) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}
function filter(__val__) {
    var preg = /^([0-9]+\.?[0-9]{0,2})$/;
    if (preg.test(__val__) === true) {
        return true;
    } else {
        return false;
    }
}