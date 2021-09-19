$(document).ready(function () {

    ObtenerSelected(ListarCategorias)

    // PAGINACION CLICK
    $(".paginacion").on('click', 'a.page-link', function () {
        var items = parseInt($("#selectedItems :selected").val());
        var { pagina } = $(this).data()
        ListarCategorias(items, pagina)
    })

    // CAMBIAR ESTADO
    $(".tbodyCategoria").on('click', 'input[type=checkbox]', function () {
        var data = $(this).data()

        if (data.estado == 1) {
            data.estado = 0
        } else {
            data.estado = 1
        }

        data.metodo = "AEC"

        $.ajax({
            url: 'util/ajax/categoria.php',
            data,
            type: 'POST',
            dataType: 'json',
            error: function (err) { console.log(err) },
            success: function (response) {
                var { estado, msj } = response
                switch (estado) {
                    case 1:
                        var items = parseInt($("#selectedItems :selected").val());
                        var { pagina } = $(this).data()
                        ListarCategorias(items, pagina)

                        Swal.fire({
                            icon: 'success',
                            text: `${msj}`
                        })
                        break;
                    case 2:
                        Swal.fire({
                            icon: 'warning',
                            text: `${msj}`
                        })
                        break;
                }
            }
        })
    })

    // OBTENER Y ACTUALIZAR CATEGORIA
    $(".tbodyCategoria").on('click', 'button[type=button].btn', function () {
        var data = $(this).data();
        data.metodo = 'OC'

        $.ajax({
            url: 'util/ajax/categoria.php',
            type: 'POST',
            dataType: 'Json',
            data,
            error: function (err) { console.log(err) },
            success: function (response) {
                console.log(response)
                var { estado, msj, data } = response
                switch (estado) {
                    case 1:
                        $("#nombre").val(data.categoria['nombre'])
                        $("button#editarcategoria-tab").tab("show")
                        $("#idcategoria").val(Number(data.categoria['id']))
                        $("#descripcion").val(data.categoria['descripcion'])
                        $("button#agregarmas").addClass("disabled not-allowed")
                        $("button[type=submit]").html(`<i class="fa fa-save me-2"></i> Actualizar Categoria`)
                        break;
                }
            }
        })
    })

    // FORMULARIO DE GUARDAR O ACTUALIZAR CATEGORIA
    $("#formCategoria").submit(function () {
        var formData = new FormData($(this)[0])

        if (Number($("#idcategoria").val()) == 0) {
            formData.append('metodo', 'CNC')
        } else {
            formData.append('metodo', 'ACS')
        }

        $.ajax({
            url: 'util/ajax/categoria.php',
            type: 'POST',
            dataType: 'Json',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            error: function (err) { console.log(err) },
            beforeSend: function () {
                $("#guardar").html("<i class='fa fa-undo me-2'></i>Procesando..!!").prop({ disabled: true })
            },
            success: function (response) {
                // console.log(response)
                var { estado, msj, data } = response
                switch (estado) {
                    case 1:
                        Swal.fire({
                            icon: 'success',
                            text: `Éxito`,
                            confirmButtonText: 'Cerrar'
                        })
                        LimpiarFormulario()
                        break;
                    case 2:
                        Swal.fire({
                            icon: 'success',
                            text: `${msj}`,
                            confirmButtonText: 'Cerrar'
                        })
                        break;
                }
            },
            complete: function () {
                $("#guardar").html(`<i class="fa fa-save me-2"></i> Actualizar Categoria`).prop({ disabled: false })

            }
        })

        return false
    })

    // AGREGAR NUEVA TARJETA
    $("#agregarmas").on('click', function () {
        var tarjeta = $(".tarjetasCategorias .categoria:last")

        tarjeta.clone().appendTo(".tarjetasCategorias")

        FormatearTarjeta()
    })

    // ELIMINAR TARJETA 
    $(".tarjetasCategorias").on('click', 'button.btn-quitar', function () {
        var { pos } = $(this).data(),
            total = parseInt($(".tarjetasCategorias").find('.categoria').length) - 1

        $(".tarjetasCategorias").find('.categoria').each(function (index, item) {
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

    // SELECCIONAR ITEMS
    $("#selectedItems").change(function () {
        var items = parseInt($(this).val())
        ListarCategorias(items, 1)
    })
})

// LIMPAR FORMULARIO
function LimpiarFormulario() {
    $("#idcategoria").val(0)
    $("#formCategoria").trigger("reset");
    $("button#listacategoria-tab").tab("show")
    $("#agregarmas").removeClass("disabled not-allowed")
    $(".tarjetasCategorias").find(".categoria").each(function (index, item) {
        if (index == 0) {
            $(item).find("input[type=text],textarea").val("")
        } else {
            $(item).remove()
        }
    })

    var items = Number($("#selectedItems :selected").val());
    ListarCategorias(items, 1)
}

// Listar Todas las categrorias
function ListarCategorias(items, pagina = 1) {
    $.ajax({
        url: 'util/ajax/categoria.php',
        type: 'POST',
        dataType: 'json',
        data: {
            metodo: 'OCA',
            pagina,
            items
        },
        success: function (response) {
            var { estado, msj, data } = response
            switch (estado) {
                case 1:
                    var tbody = "", cont = 0
                    data.categorias.map(function (item) {
                        tbody += `
                            <tr>
                                <td>
                                    ${item['pos']}
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-success" data-id=${item['id']}>
                                        <i class="fa fa-pencil me-2"></i> Editar
                                    </button>
                                </td>
                                <td style="cursor: pointer;">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked_${cont}" data-estado=${item['estado']} data-id=${item['id']}  ${item['estado'] == 1 ? 'checked' : ''}>
                                        <label class="form-check-label" for="flexSwitchCheckChecked_${cont}">${item['estado'] == 1 ? 'Activo' : 'Inactivo'}</label>
                                    </div>
                                </td>
                                <td>
                                    ${item['nombre']}
                                </td>
                                <td>
                                    ${item['descripcion']}
                                </td>
                                <td>
                                    ${item['createdAt']}
                                </td>
                                <td>
                                    ${item['updatedAt']}
                                </td>
                            </tr>
                        `
                        cont++;
                    })

                    $(".tbodyCategoria").html(tbody)
                    $(".paginacion").html(data.paginacion)
                    $(".mostrar").html(data.mostrar)
                    break;
                case 2:
                    var tbody = `
                        <tr>
                            <td colspan=10 class="text-center p-3">
                                ${msj || 'data'}
                            </td>
                        </tr>
                    `

                    $(".tbodyCategoria").html(tbody)
                    $(".paginacion").empty()
                    $(".mostrar").empty()
                    break;

            }
        }
    })
}

// VACIAR NUEVA TARJETA
function FormatearTarjeta() {

    var total = parseInt($(".tarjetasCategorias").find(".categoria").length)

    $(".tarjetasCategorias").find(".categoria").each(function (index, item) {

        if (total == parseInt(index + 1)) {
            $(item).find("input[type=text], textarea").val('')
        }

        $(item).find("button.btn-quitar").attr({ 'data-pos': index })

        if (index >= 0) {
            $(item).find("button.btn-quitar").removeClass("d-none");
        }
    })
}