$(document).ready(function () {

    ObtenerSelected(ObtenerParametros)
})

function ObtenerParametros(items, pagina = 1) {
    $.ajax({
        type: 'POST',
        url: 'util/ajax/parametro.php',
        dataType: 'Json',
        data: {
            metodo: 'OTP',
            items,
            pagina
        },
        error: function (err) { console.log(err) },
        success: function (response) {
            console.log(response)
        }
    })
}
