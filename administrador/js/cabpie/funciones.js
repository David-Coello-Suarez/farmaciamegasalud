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
