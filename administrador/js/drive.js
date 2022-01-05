$(document).ready(function () {
    CargarImgDrive()

    $("#formBanner").on('change', 'input[type=file]', function () {
        CargarImage(this)
    })

    $(".imgDrive").on("click", ".btneditar", function () {
        const data = $(this).data()
        data.metodo = "OI"

        $.ajax({
            url: 'util/ajax/drive.php',
            type: 'POST',
            dataType: 'json',
            data,
            error: function (err) {
                console.log(err)
            },
            success: function (response) {

                var { estado, msj, data } = response
                switch (estado) {
                    case 1:
                        let { drive } = data
                        console.log(drive)

                        $("#imgDrive").attr({ src: `${drive.imagen}?v=${new Date().getMilliseconds()}` })
                        $("#iddrive").val(parseInt(drive.id))
                        $("#nombre").val(drive.nombre)
                        $("#url").val(drive.url)
                        $("#orden").val(drive.orden)

                        $("#exampleModal").modal("show")
                        break;
                }
            }
        })
    })
})

const CargarImgDrive = () => {

    $.ajax({
        url: 'util/ajax/drive.php',
        type: 'POST',
        dataType: 'json',
        data: {
            metodo: 'LID'
        },
        error: function (err) {
            console.log(err)
        },
        success: function (response) {

            var { estado, msj, data } = response, listaImagen = ""

            switch (estado) {
                case 1:
                    let { drive } = data

                    drive.map((item) => {
                        listaImagen += `
                            <div class="col">
                                <div class="card shadow-sm">
                                <img src='${item['imagen']}?v=${new Date().getMilliseconds()}' />

                                <div class="card-body">
                                    <p class="card-text">${item['nombre']}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                        <button type="button" data-id=${parseInt(item['id'])} class="btn btn-sm btn-outline-success btneditar">Editar</button>
                                        </div>
                                            <small class="text-muted">${moment(item['fechaCreacion'], "YYYYMMDD  HHmmii").fromNow()}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `
                    })
                    break;
                case 2:
                    break;
            }

            $(".imgDrive").html(listaImagen)
        }
    })
}