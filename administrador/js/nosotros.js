$(document).ready(function () {
    ObtenerCabeceraParrafo()

    ClassicEditor
        .create(document.querySelector('#editor')).then(newEditor => window.editor = newEditor)

    $("#formNosotros").submit(function (event) {
        event.preventDefault()

        var guardar = true

        try {
            if (window.editor.getData() == "") {
                alert("El parrafo no puede estar vacio")
            }
        } catch (e) {
            guardar = !guardar
            swalMixin(e, "warning")
        }

        if (guardar) {
            var formData = new FormData($(this)[0])
            formData.append("metodo", "GTXT")

            $.ajax({
                url: 'util/ajax/parrafo.php',
                data: formData,
                dataType: 'Json',
                type: 'POST',
                cache: false,
                contentType: false,
                processData: false,
                error: function (err) { console.log(err) },
                beforeSend: function(){
                    $("button:submit").html("Procesando..!!").prop({disabled: true})
                },
                success: function (response) {
                    
                    var { estado, msj } = response

                    switch (estado) {
                        case 1:
                            $("button:submit").html("Guardar").prop({disabled: false})
                            swalMixin("Éxito");
                            ObtenerCabeceraParrafo()
                            break
                    }
                }
            })
        }

        return false
    })
})

const ObtenerCabeceraParrafo = () => {
    let id = 0
    $.ajax({
        url: 'util/ajax/parrafo.php',
        data: {
            metodo: 'OBP'
        },
        dataType: 'Json',
        type: 'POST',
        error: function (err) { console.log(err) },
        success: function (response) {
            var { estado, msj, data } = response

            switch (estado) {
                case 1:
                    var { cabecera } = data, option = ""

                    cabecera.map((item, i) => {
                        if (i == 0) { id = Number(item['idParrafo']) }

                        option += `<option value="${Number(item['idParrafo'])}">${item['tituloParrafo']}</option>`
                    })

                    $("#tipoParrafo").html(option)
                    break;
            }
        },
        complete: function () {
            ObtenerDetalle(id)
        }
    })
}

const ObtenerDetalle = (id = 0) => {
    $.ajax({
        url: 'util/ajax/parrafo.php',
        data: {
            metodo: 'ODP',
            id
        },
        dataType: 'Json',
        type: 'POST',
        error: function (err) { console.log(err) },
        success: function (response) {
            var { estado, msj, data } = response
            switch (estado) {
                case 1:
                    var { descripcion } = data

                    window.editor.setData(descripcion.descripcion)
                    break;
            }
        }
    })
}