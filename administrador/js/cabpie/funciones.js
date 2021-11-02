$(document).ready(function () {

    $("#formContrasena").submit(function () {
        var actualizar = true

        try {
            $(this).find("input.form-control").map((i, item) => {
                var input = $(item).val().trim()

                if (input == "") {
                    $(item).addClass("is-invalid")
                    throw "Debe llenar todos los campos"
                } else {
                    $(item).addClass("is-valid").removeClass("is-invalid")

                }
            })

            var passNueva = $(this).find("input#passNueva").val().trim(),
                passconfirm = $(this).find("input#passConfirm").val().trim()

            if (passNueva != passconfirm) {
                $(this).find("input#passNueva, input#passConfirm").addClass("is-invalid")
                throw 'Las nuevas contraseñas no coinciden'
            }
        } catch (e) {
            actualizar = !actualizar
            swalMixin(e, "warning")
        }

        if (actualizar) {
            console.log("actualizado")

            var formData = new FormData($(this)[0])
            formData.append("metodo", "AC")

            $.ajax({
                type: 'POST',
                url: 'util/ajax/login.php',
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
                            $("#cambiarContrasena").modal("hide")
                            $("#formContrasena").trigger("reset")
                            Swal.fire({
                                icon: 'success',
                                html: msj,
                                showDenyButton: false,
                                showCancelButton: false,
                                confirmButtonText: 'Ok!',
                            }).then((result) => {
                                window.location = "logout.php"
                            })
                            break
                        case 2:
                            swalMixin(msj, "warning")
                            $("button[type=submit]").html("Actualizar").prop({ disabled: false })
                            break
                    }

                }
            })

        }

        return false
    })

})


function CargarImage(element, formatoAdmin = ['png', 'jpeg', 'jpg']) {

    var imagenGuardada = element.files[0];

    if (!window.FileReader) {
        alert("El navegador no soporta la lectura de archivos");
        return
    }

    if (imagenGuardada != undefined) {
        // if (!(/\.(jpg|png|jpeg)$/i).test(imagenGuardada.name)) {
        var format = String(imagenGuardada['type'].split('/').pop())

        if (!formatoAdmin.includes(format)) {
            $(element).val("")
            Swal.fire({
                icon: 'info',
                title: 'Archivo incorrecto',
                text: `Error al adjuntar archivo, solo permitidas ${JSON.stringify(formatoAdmin)}`,
                confirmButtonText: 'Cerrar'
            })
        } else {
            var leerArchivo = new FileReader()

            var hermano = $(element).prev().find('img')

            if (hermano.length <= 0) {
                var aux = $(element).parent().parent().find('img')
                hermano = aux
            }

            leerArchivo.onload = function (elem) {
                $(hermano).attr({ "src": elem.target.result })
            }

            leerArchivo.readAsDataURL(imagenGuardada);
        }
    }
}

// OBTENER ITEMS SELECTED
function ObtenerSelected(callback) {
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
            callback(items)
        }
    })
}

const swalMixin = (mensaje, icon = "success") => {
    Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    }).fire({
        html: mensaje,
        icon,
    })
}
