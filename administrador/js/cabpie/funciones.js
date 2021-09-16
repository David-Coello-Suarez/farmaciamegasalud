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