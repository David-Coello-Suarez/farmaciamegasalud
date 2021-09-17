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
            var { estado, msj, data } = response, tbody = ""
            switch (estado) {
                case 1:
                    var { mostrar, paginacion, parametros } = data

                    parametros.map(function (item) {
                        tbody += `
                            <tr>
                                <td>
                                    ${item['pos']}
                                </td>
                            </tr>
                        `
                    })

                    $(".paginacion").html(paginacion)
                    $(".mostrar").html(mostrar)
                    break
            }
            $("#tbodyParametro").html(tbody)
        }
    })
}
