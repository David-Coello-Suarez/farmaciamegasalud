$(document).ready(function () {

    ObtenerSelected(ObtenerParametros)

    $("#tbodyParametro").on("click", "button.btn-editar", function () {

        $(this).removeClass("btn-editar").addClass("btn-guardar").html("Guardar")

        var data = $(this).parent().parent()

        data.find("input#valor").attr({ readonly: false })
        data.find("textarea").attr({ readonly: false })
    })

    $("#tbodyParametro").on("click", "button.btn-guardar", function () {

        var data = $(this).data()
        data.metodo = "AP"

        var editadata = $(this).parent().parent()
        data.valor = editadata.find("input#valor").val()
        data.descripcion = editadata.find("textarea").val()

        $.ajax({
            type: 'POST',
            url: 'util/ajax/parametro.php',
            dataType: 'Json',
            data,
            // error: function (err) { console.log(err) },
            success: function (response) {
                var { estado, msj, data } = response
                switch (estado) {
                    case 1:
                        RecargarTabla()
                        break;
                    case 2:
                        Swal.fire({
                            icon: 'warning',
                            text: `${msj}`
                        })
                        break
                }
            }
        })
    })

    $("#selectedItems").on('change', function(){
        var items = Number($(this).val())

        ObtenerParametros(items)
    })


    $(".paginacion").on('click', 'a.page-link', function () {
        var { pagina } = $(this).data()
        var items = Number($("#selectedItems :selected").val())

        ObtenerParametros(items,pagina)
    })

})

function RecargarTabla() {
    var items = Number($("#selectedItems :selected").val())
    var { pagina } = ($('.paginacion').find("li.active > a").data())

    ObtenerParametros(items, pagina)
}

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
        // error: function (err) { console.log(err) },
        success: function (response) {
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
                                <td>
                                    <button type="button" class="btn btn-sm btn-success btn-editar" data-id=${Number(item['id'])}>
                                        Editar
                                    </button>
                                </td>
                                <td>
                                    <input type="text" readonly value="${item['nombre']}" class="form-control form-control-sm" />
                                </td>
                                <td>
                                    <input type="text" readonly value="${item['valor']}" class="form-control form-control-sm" id="valor"/>
                                </td>
                                <td>
                                    <textarea readonly class='form-control form-control-sm'>${item['descripcion']}</textarea>
                                </td>
                                <td class="text-center">
                                ${moment(item['createdAt'], "YYYYMMDD  HHmmii").fromNow()}
                                </td>
                                <td class="text-center">
                                ${moment(item['updatedAt'], "YYYYMMDD HHmmii").isValid() ? moment(item['updatedAt'], "YYYYMMDD HHmmii").fromNow() : ''}
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
