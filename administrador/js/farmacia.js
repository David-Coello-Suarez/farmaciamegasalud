$(document).ready(function () {
    ObtenerSelected()

    // SELECCIONAR ITEMS
    $("#selectedItems").change(function () {
        var items = parseInt($(this).val())
        ObtenerFarmacias(items, 1)
    })

    // CAMBIAR ESTADO
    $(".farmacias").on('click', '.btn-estado', function () {
        var data = $(this).data()

        if (data.estado == 1) {
            data.estado = 0
        } else {
            data.estado = 1
        }

        data.metodo = "AEF"

        $.ajax({
            url: 'util/ajax/farmacia.php',
            type: 'POST',
            dataType: 'Json',
            data,
            // error: function (err) { console.log(err) },
            success: function (response) {
                var { estado, msj, data } = response
                switch (estado) {
                    case 1:
                        Swal.fire({
                            icon: 'success',
                            text: `${msj}`,
                            confirmButtonText: 'Cerrar'
                        })
                        itemPaginaActual()
                        break;
                    case 2:
                        Swal.fire({
                            icon: 'warning',
                            text: `${msj}`,
                            confirmButtonText: 'Cerrar'
                        })
                        var items = Number($("#selectedItems :selected").val())
                        ObtenerFarmacias(items)
                        break
                }
            }
        })
    })

    // CAMBIAR DE PAGINA
    $(".pagination").on('click', 'button.btn-avanzar', function () {
        var items = Number($("#selectedItems :selected").val())
        var { pagina } = $(this).data()
        ObtenerFarmacias(items, pagina)
    })

    // AGREGAR NUEVA FARMACIA DOM
    $("#agregarmas").on('click', function () {
        $(".farmaciasInt .farmacia:last").clone().appendTo(".farmaciasInt")

        var total = Number($(".farmaciasInt").find(".farmacia").length)

        $(".farmaciasInt").find(".farmacia").each(function (index, item) {
            if (total == (index + 1)) {
                $(item).find("input,textarea").val("")
                $(item).find('img').attr({ src: `img/farmacias/no-farmacia.png?v=${new Date().getSeconds()}` })
            }
            $(item).find("button.btn-quitar").attr({ 'data-pos': index })
            if (index >= 0) {
                $(item).find("button.btn-quitar").removeClass("d-none");
            }
        })
    })

    // ELIMINAR TARJETA ACTUAL
    $(".farmaciasInt").on('click', 'button.btn-quitar', function () {
        var { pos } = $(this).data(),
            total = Number($(".farmaciasInt").find('.farmacia').length) - 1

        $(".farmaciasInt").find('.farmacia').each(function (index, item) {
            if (index == pos) {
                $(item).remove()
            } else {
                $(item).find("button.btn-quitar").attr({ 'data-pos': index })

                if (total == 1) {
                    $(item).find("button.btn-quitar").addClass("d-none");
                }
            }
        })
    })

    // ONCHANGE FILE
    $(".farmaciasInt").on('change', 'input[type=file]', function () {
        CargarImage(this)
    })

    // OBTENER Y ACTUALIZAR FARMACIA
    $(".farmacias").on('click', 'button.btn-editar', function () {
        var data = $(this).data()
        data.metodo = "OFS"

        $.ajax({
            url: 'util/ajax/farmacia.php',
            type: 'POST',
            dataType: 'json',
            data,
            // error: function (err) { console.log(err) },
            success: function (response) {
                var { estado, msj, data } = response
                switch (estado) {
                    case 1:
                        $("#idfarmacia").val(data['id'])
                        var imagen = data['imagen']
                        if (data['imagen'] == '') {
                            imagen = `img/farmacias/no-farmacia.png?v=${new Date().getUTCMilliseconds()}`
                        }
                        $("img#imgfarmacia").attr({ src: imagen })
                        $("textarea#direccion").val(data['direccion'])
                        $("textarea#referencia").val(data['referencia'])
                        $("input#telefono").val(data['telefono'])
                        $("input#extencion").val(data['ext'])
                        $("input#long").val(data['longitud'])
                        $("input#lat").val(data['latitud'])
                        $(`#ciudad option[value=${parseInt(data['idciudad'])}]`).prop({ selected: true })

                        $("#editarfarmacia-tab").tab("show")
                        $("#agregarmas").prop({ disabled: true })

                        $("#guardar").html(`<i class="fa fa-save me-2"></i> Actualizar Farmacia`)
                        break
                    case 2:
                        Swal.fire({
                            icon: 'warning',
                            text: `${msj}`,
                            confirmButtonText: 'Cerrar'
                        })
                        break
                }
            }
        })
    })

    // FORMULARIO PARA EDITAR O CREAR NUEVA FARMACIA
    $("#formularioFarmacia").submit(function () {
        var guardarFarmacia = false

        try {
            $(".farmaciasInt").find(".farmacia").each(function (index, item) {

                if (Number($("#idfarmacia").val()) == 0) {
                    if ($(item).find("input[type=file]").val() == "") {
                        $(item).find('img#imgfarmacia').addClass("border border-danger rounded-3")
                        throw "Debe seleccionar la imagen de la farmacia"
                    } else {
                        $(item).find('img#imgfarmacia').removeClass("border border-danger rounded-3")
                    }
                }

                $(item).find("textarea").each(function (index, itemInt) {
                    if ($(itemInt).val() == "") {
                        $(itemInt).addClass("is-invalid")
                        throw "La ciudad es requerida"
                    } else {
                        $(itemInt).removeClass("is-invalid")
                    }
                })

                $(item).find("input[type=tel]").each(function (index, itemIntTel) {
                    if ($(itemIntTel).val() == "" || $(itemIntTel).val() == 0) {
                        $(itemIntTel).addClass("is-invalid")
                        throw "La ciudad es requerida"
                    } else {
                        $(itemIntTel).removeClass("is-invalid")
                    }
                })

                $(item).find("input[type=text]").each(function (index, itemIntText) {
                    if ($(itemIntText).val() == "" || $(itemIntText).val() == 0) {
                        $(itemIntText).addClass("is-invalid")
                        throw "La ciudad es requerida"
                    } else {
                        $(itemIntText).removeClass("is-invalid")
                    }
                })

                if (Number($(item).find("select").val()) == 0) {
                    $(item).find("select").addClass("is-invalid")
                    throw "La ciudad es requerida"
                } else {
                    $(item).find("select").removeClass("is-invalid")
                }
            })
            guardarFarmacia = !guardarFarmacia
        } catch (error) {
            Swal.fire({
                icon: 'warning',
                text: `Algunos campos son requerido`,
                confirmButtonText: 'Cerrar'
            })
        }

        if (guardarFarmacia) {
            var formData = new FormData($(this)[0]);

            if (Number($("#idfarmacia").val()) == 0) {
                formData.append("metodo", "CNF");
            } else {
                formData.append("metodo", "AFS")
            }

            $.ajax({
                url: 'util/ajax/farmacia.php',
                type: 'POST',
                dataType: 'Json',
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                // error: function (err) { console.error(err) },
                beforeSend: function () {
                    $("#guardar").html(`<i class="fa fa-save me-2"></i> Procesando..!!`).prop({ disabled: true })
                },
                success: function (response) {
                    var { estado, msj, data } = response
                    switch (estado) {
                        case 1:
                            Swal.fire({
                                icon: 'success',
                                text: `${msj}`,
                                confirmButtonText: 'Cerrar'
                            })
                            itemPaginaActual()
                            LimparFormulario()
                            break
                    }
                }
            })
        }

        return false
    })
})

// OBTENER ITEMS SELECTED
function ObtenerSelected() {
    var items = 0
    $.ajax({
        url: 'util/ajax/parametro.php',
        type: 'POST',
        dataType: 'json',
        data: {
            metodo: 'PW',
            parametro: 'numeroItems'
        },
        // error: function (err) { console.log(err) },
        success: function (response) {
            switch (response.estado) {
                case 1:
                    var slect = "", value = parseInt(response.msj)
                    items = parseInt(response.msj)
                    for (var i = 0; i < 4; i++) {
                        slect += `<option value='${value}' ${i == 0 ? 'selected' : ''} >${value}</option>`
                        value += parseInt(response.msj)
                    }
                    // slect += `<option value="0">Todos</option>`
                    $("#selectedItems").html(slect)
                    break;

            }
        },
        complete: function () {
            ObtenerFarmacias(items)
        }
    })
}

// LISTAR FARMACIAS
function ObtenerFarmacias(items = 10, pagina = 1) {
    $.ajax({
        url: 'util/ajax/farmacia.php',
        type: 'POST',
        dataType: 'Json',
        data: {
            metodo: 'LTF',
            items,
            pagina
        },
        // error: function (err) { console.log(err) },
        success: function (response) {
            var { estado, msj, data } = response
            switch (estado) {
                case 1:
                    var farmacia = ""
                    data.farmacias.map(function (item) {
                        farmacia += `
                            <div class="col col-md-3 py-2 mx-auto">
                                <div class="card shadow-sm">
                                    <img src="${item['imagen']}?v=${new Date().getMilliseconds()}" />
                                    <div class="card-body">
                                        <p class="card-text">
                                        ${item['direccion']}
                                        </p>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">Ciudad: <strong>${item['ciudad']}</strong> </li>
                                        <li class="list-group-item">Telefono: ${item['telefono']} ext: ${item['ext']} </li>
                                        <li class="list-group-item">Referencia: ${item['referencia'] == "" ? "<br><br>" : item['referencia']} </li>
                                        <li class="list-group-item">
                                            Estado: <strong> ${parseInt(item['estado']) == 1 ? 'Activo' : 'Inactivo'} </strong>
                                        </li>
                                        <li class="list-group-item"> <a href="${item['googlemaps']}" target="_blank">Ver en el mapa</a> </li>
                                    </ul>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="btn-group">
                                                <button type="button" data-id=${item['id']} data-estado=${parseInt(item['estado'])} class="btn btn-estado btn-sm btn-outline-${parseInt(item['estado']) == 1 ? 'danger' : 'success'}">${parseInt(item['estado']) == 1 ? 'Inactivo' : 'Activo'}</button>
                                                <button type="button" data-id=${item['id']} class="btn btn-editar btn-sm btn-outline-warning">Editar</button>
                                            </div>
                                            <small class="text-muted">${moment(item['createdAt'], "YYYYMMDD").fromNow()}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `
                    })
                    $(".farmacias").html(farmacia)
                    $(".mostrar").html(data.mostrar)
                    $(".pagination").html(data.paginacion)
                    break
            }
        },
        complete: function () {
            ListarCiudades()
        }
    })
}

// LISTAR CIUDADES ACTIVAS
function ListarCiudades() {
    $.ajax({
        url: 'util/ajax/ciudades.php',
        type: 'POST',
        dataType: 'Json',
        data: {
            metodo: 'LCA'
        },
        // error: function (err) { console.log(err) },
        success: function (response) {
            var { estado, msj, data } = response, options = "", optionDisabled = true
            switch (estado) {
                case 1:
                    var { ciudades } = data
                    if (ciudades.length > 0) {
                        optionDisabled = !optionDisabled;
                        ciudades.map(function (item, index) {
                            options += `<option value="${item['id']}" ${index == 0 ? 'disabled selected' : ''}>${item['ciudad']}</option>`
                        })
                    }
                    break
                case 2:
                    options = `<option selected>${msj}</option>`;
                    break
            }
            $("#ciudad").prop({ disabled: optionDisabled }).html(options)
        }
    })
}

// OBTENER ITEM Y PAGINA ACTUAL
function itemPaginaActual() {
    var { pagina } = $(".pagination").find("button[type=button].active").data()
    var items = Number($("#selectedItems :selected").val())
    ObtenerFarmacias(items, pagina)
}

// LIMPIAR FORMULARIO
function LimparFormulario() {
    $("#idfarmacia").val(0)
    $("#listafarmacia-tab").tab("show")
    $("#formularioFarmacia").trigger("reset")
    $("#agregarmas").prop({ disabled: false })
    $("#guardar").html(`<i class="fa fa-save me-2"></i> Guardar`).prop({ disabled: false })


    $(".farmaciasInt").find(".farmacia").each(function (index, item) {
        if (index == 0) {
            $(item).find("input,textarea").val("")
            $(item).find("img").attr({
                src: `img/farmacias/no-farmacia.png?v=${new Date().getUTCMilliseconds()}`
            })
            $(item).find(`select#farmacia option[value=0]`).prop({ selected: true })

        } else {
            $(item).remove()
        }
    })
}

// VALIDAR SOLO NUMEROS
function validarNumero(evt) {

    // code is the decimal ASCII representation of the pressed key.
    var code = (evt.which) ? evt.which : evt.keyCode;

    if (code == 8) { // backspace.
        return false;
    } else if (code >= 48 && code <= 57) { // is a number.
        return true;
    } else { // other keys.
        return false;
    }
}

// VALIDAR LONGITUD Y LATITUD
function ValidarCoordinadas(evt, valor, longlat) {
    var code = (evt.which) ? evt.which : evt.keyCode, pasar = false

    if ((code >= 48 && code <= 57) || code == 45 || code == 43 || code == 46 || code == 44) { // is a number.
        pasar = true;
    }

    console.log(valor)

    if (pasar) {

        var regexpLong = new RegExp('^-?([1-8]?[1-9]|[1-9]0)\\.{1}\\d{1,6}')

        if (regexpLong.test(valor)) {
            console.log("Segundo")
            $(evt.target).removeClass("is-invalid")
            return true
        } else {
            $(evt.target).addClass("is-invalid")
            return false
        }
    } else {
        return false
    }
}