$(document).ready(function () {
    ObtenerSelected(CargarUsuarios)

    $(".tbodyUsuarios").on('click', 'input:checkbox', function () {
        var data = $(this).data()
        data.metodo = "AEU"

        if (data.estado == 1) {
            data.estado = 0
        } else {
            data.estado = 1
        }

        $.ajax({
            url: 'util/ajax/usuario.php',
            type: 'POST',
            dataType: 'json',
            data,
            error: function (err) { console.log(err) },
            success: function (response) {
                var { estado, mensaje, data } = response

                switch (estado) {
                    case 1:
                        ListarPaginaActual()
                        break
                }
            }
        })
    })

    $(".tbodyUsuarios").on('click', "button.btn", function () {
        var data = $(this).data();
        data.metodo = "OU"

        $.ajax({
            url: 'util/ajax/usuario.php',
            type: 'POST',
            dataType: 'json',
            data,
            error: function (err) { console.log(err) },
            success: function (response) {

                var { estado, data } = response

                switch (estado) {
                    case 1:
                        var { apellidos, fechaNacimiento, id, movil, nombres, usuario } = data.usuario

                        $("#nombres").val(nombres)
                        $("#apellidos").val(apellidos)
                        $("#fechaNac").val(fechaNacimiento)
                        $("#movil").val(movil)
                        $("#usuario").val(usuario)
                        $("#idusuario").val(Number(id))

                        $("button[type=submit]").html("Actualizar")

                        $("button#editarproducto-tab").tab("show")
                        break;
                }
            }
        })
    })

    $("#formUsuario").submit(function () {
        var guardar = true

        try {
            $(this).find("input.form-control").map(function (i, item) {
                var valor = $(item).val()

                if (valor == "") {
                    $(item).addClass("is-invalid")
                    throw "Todos los campos deben ser llenados correctamente";
                } else {
                    $(item).removeClass("is-invalid").addClass("is-valid")
                }
            })
        } catch (e) {
            guardar = !guardar
            swalMixin(e, "warning")
        }

        if (guardar) {
            let formData = new FormData($(this)[0]), metodo = "CNU"

            if (parseInt($("#idusuario").val()) > 0) {
                metodo = "AUC"
            }

            formData.append("metodo", metodo)

            $.ajax({
                type: 'POST',
                url: 'util/ajax/usuario.php',
                dataType: 'Json',
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                error: function (err) { console.log(err) },
                beforeSend: function () {
                    $("button[type=submit]").html("Procesando....").prop({ disabled: true })
                },
                success: function (response) {
                    var { estado, msj, data } = response
                    switch (estado) {
                        case 1:
                            if (parseInt($("#idusuario").val()) > 0) {
                                swalMixin(msj)
                            } else {
                                Swal.fire({
                                    icon: 'success',
                                    title: msj,
                                    html: data.contrasena
                                })
                            }
                            LimpiarFormulario()
                            ListarPaginaActual();
                            break
                        case 2:
                            swalMixin(msj, 'warning')
                            let mensaje = "Guardar"
                            if (parseInt($("#idusuario").val()) > 0) {
                                mensaje = "Actualizar"
                            }
                            $("button[type=submit]").html(mensaje).prop({ disabled: false })
                            break
                    }
                }
            })

        }


        return false
    })
})

const CargarUsuarios = (items, pagina = 1) => {
    $.ajax({
        url: 'util/ajax/usuario.php',
        type: 'POST',
        dataType: 'json',
        data: {
            metodo: 'OLU',
            items,
            pagina
        },
        beforeSend: function () {
            let table = `<tr> <td colspan=20 class='p-3 text-center'> <i class='fa fa-circle-o-notch fa-fw fa-spin'></i>  Cargando datos </td> </tr>`

            $(".tbodyUsuarios").html(table)
        },
        success: function (response) {
            var { estado, msj, data } = response

            switch (estado) {
                case 1:
                    var { paginacion, mostar, usuarios } = data, tbody = ""

                    usuarios.map((item) => {
                        tbody += `
                            <tr>
                                <td>
                                ${item['numeral']}
                                </td>
                                <td>
                                    <button type='button' data-id=${parseInt(item['id'])} class='btn btn-sm btn-success'>
                                        Editar
                                    </button>
                                </td>
                                <td style="cursor: pointer;">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" class="check" type="checkbox" id="flexSwitchCheckChecked" data-id=${parseInt(item['id'])} data-estado=${parseInt(item['estado'])} ${parseInt(item['estado']) == 1 ? 'checked' : ''}>
                                        <label class="form-check-label" for="flexSwitchCheckChecked">${parseInt(item['estado']) == 1 ? 'Activo' : 'Inactivo'}</label>
                                    </div>
                                </td>
                                <td>
                                ${item['nombres']}
                                </td>
                                <td>
                                ${item['apellidos']}
                                </td>
                                <td>
                                ${item['fechaNacimiento']}
                                </td>
                                <td>
                                ${item['movil']}
                                </td>
                                <td>
                                ${item['usuario']}
                                </td>
                            </tr>
                        
                        `
                    })

                    $(".tbodyUsuarios").html(tbody)
                    $(".paginacion").html(paginacion)
                    $(".mostrar").html(mostar)
                    break;
                case 2:
                    let table = `<tr> <td colspan=20 class='p-3 text-center'> ${msj} </td> </tr>`

                    $(".tbodyUsuarios").html(table)
                    break
            }
        }
    })
}

const ListarPaginaActual = () => {
    var items = parseInt($("#selectedItems :selected").val());
    let pagina = parseInt($(".pagination").find(".page-item.active >.page-link ").data("pagina"));
    CargarUsuarios(items, pagina)
}

const LimpiarFormulario = () => {
    $("button#listaproducto-tab").tab("show")
    $("button[type=submit]").html("Guardar").prop({ disabled: false })

    $("#idusuario").val(0)
    $("#formUsuario").trigger("reset");

    $("#formUsuario").find("input.form-control").removeClass("is-valid").removeClass("is-invalid")
}