$(document).ready(function () {

    ObtenerSelected(ListarCiudades)

    $(".tbodyCiudades").on("click", "button.btn-editar", function () {

        $(this).removeClass("btn-editar").addClass("btn-guardar").html("<i class='fa fa-save me-1'></i> Guardar").parent().parent().find("input#ciudad").attr({ readonly: false })

    })

    // ACTUALIZAR CIUDAD
    $(".tbodyCiudades").on("click", "button.btn-guardar", function () {

        var button = $(this),
            input = $(button).parent().parent().find("input#ciudad").val()

        if (input == "") {
            Swal.fire({
                icon: 'warning',
                text: `No se permiten valor vacios`,
                confirmButtonText: 'Cerrar'
            })
        } else {
            var data = $(button).data()
            data.ciudad = input
            data.metodo = "AC"

            $.ajax({
                type: 'POST',
                data,
                url: 'util/ajax/ciudades.php',
                dataType: 'Json',
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
                            ListarCiudadesItems()
                            break;
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
        }

    })

    $(".tbodyCiudades").on("click", "input[type=checkbox]", function () {
        var data = $(this).data()

        if (data.estado == 1) {
            data.estado = 0
        } else {
            data.estado = 1
        }

        data.metodo = "AEC"

        $.ajax({
            url: 'util/ajax/ciudades.php',
            type: 'POST',
            dataType: 'Json',
            data,
            success: function (response) {
                var {estado, msj, data} = response

                switch(estado){
                    case 1:
                        ListarCiudadesItems()
                        break;
                }
            }
        })
    })

    $(".Ciudades").on("click", " .btnQuitar", function () {
        var { pos } = $(this).data()

        $(".Ciudades").find(".ciudad").each(function (index2, item) {
            if (index2 == pos) {
                $(item).remove()
            } else {
                $(item).find(".btnQuitar").attr({ 'data-pos': index2 })
            }
        })
    })

    $(".paginacion").on('click', 'a.page-link', function () {
        var { pagina } = $(this).data()

        ListarCiudadesItems(pagina)
    })

    $("#agregarmas").on('click', function () {
        var tarjeta = $(".Ciudades .ciudad:last")

        tarjeta.clone().appendTo(".Ciudades")

        var total = parseInt($(".Ciudades").find(".ciudad").length)

        $(".Ciudades").find(".ciudad").each(function (index, item) {

            if (total == parseInt(index + 1)) {
                $(item).find("input#ciudad").val("");
            }
            $(item).find(".btnQuitar").attr({ 'data-pos': index })

        })

    })

    $("#GuardarCiudad").submit(function () {
        var guardar = false

        try {
            $(this).find("input[type='text']").each(function (index, item) {
                if ($(item).val() == "") {
                    $(item).addClass("is-invalid")
                    throw "Ningun campo debe estar vacio"
                } else {
                    $(item).removeClass("is-invalid")
                }
            })
            guardar = !guardar
        } catch (e) {
            Swal.fire({
                icon: 'warning',
                text: `${e}`,
                confirmButtonText: 'Cerrar'
            })
        }

        if (guardar) {
            var formData = new FormData($(this)[0])
            formData.append("metodo", "RNC")

            $.ajax({
                url: 'util/ajax/ciudades.php',
                type: 'POST',
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false,
                data: formData,
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
                            $("#staticBackdrop").modal("hide")
                            LimpiarFormulario()
                            ListarCiudadesItems()
                            break;
                        case 2:
                            Swal.fire({
                                icon: 'warning',
                                text: `${msj}`,
                                confirmButtonText: 'Cerrar'
                            })
                            MostrarExistente(data['existe'])
                            break;
                    }
                }
            })
        }

        return false
    })
})

function ListarCiudadesItems(pagina = 0) {
    var items = Number($("#selectedItems :selected").val())
    if (pagina == 0) {
        pagina = $(".paginacion").find("li.active > a").data("pagina")
    }

    ListarCiudades(items, pagina)
}

function ListarCiudades(items, pagina = 1) {
    $.ajax({
        url: 'util/ajax/ciudades.php',
        type: 'POST',
        dataType: 'json',
        data: {
            metodo: 'LC',
            pagina,
            items
        },
        // error: function (err) { console.log(err) },
        success: function (response) {
            var { estado, msj, data } = response
            // console.log(response)
            switch (estado) {
                case 1:
                    var { ciudades, mostrar, paginacion } = data, cont = 0, tbody = ""

                    ciudades.map(function (item) {
                        tbody += `
                            <tr>
                                <td>
                                    ${item['pos']}
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-success btn-editar" data-id=${item['id']}>
                                        <i class="fa fa-pencil me-2"></i> Editar
                                    </button>
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm" id="ciudad" readonly value="${item['ciudad']}" />
                                </td>
                                <td style="cursor: pointer;" class="text-center">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked_${cont}" data-estado=${item['estado']} data-id=${item['id']}  ${item['estado'] == 1 ? 'checked' : ''}>
                                        <label class="form-check-label" for="flexSwitchCheckChecked_${cont}">${item['estado'] == 1 ? 'Activo' : 'Inactivo'}</label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    ${moment(item['createdAt'], "YYYYMMDD  HHmmii").fromNow()}
                                </td>
                                <td class="text-center">
                                    ${moment(item['updatedAt'], "YYYYMMDD HHmmii").isValid() ? moment(item['updatedAt'], "YYYYMMDD HHmmii").fromNow() : ''}
                                </td>
                            </tr>
                        `
                        cont++
                    })

                    $(".tbodyCiudades").html(tbody)
                    $(".paginacion").html(paginacion)
                    $(".mostrar").html(mostrar)
                    break
                case 2:
                    $(".tbodyCiudades").html(`<tr> <td colspan=10 class='p-4 text-center'> ${msj}</td> </tr>`)
                    $(".paginacion").empty()
                    $(".mostrar").empty()
                    break;
            }
        }
    })
}

function MostrarExistente(data) {
    $(".Ciudades").find(".ciudad").each(function (index, item) {

        var dataInput = $(item).find("input#ciudad").val();

        if (dataInput != data[index]) {
            $(item).remove()
        }
    })
}

function LimpiarFormulario() {
    $(".Ciudades").find(".ciudad").each(function (index, item) {

        if (index == 0) {
            $(item).find("input#ciudad").val("");
        } else {
            $(item).remove()
        }
    })
}