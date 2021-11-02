$(document).ready(function () {
    CargarSelected()

    $("#formBanner").on('change', 'input[type=file]', function () {
        CargarImage(this)
    })

    $("#formBanner").submit(function () {

        let formData = new FormData($(this)[0]),
            metodo = 'ACB'

        if (Number($("#idbanner").val()) == 0) {
            metodo = 'CNB'
        }

        formData.append("metodo", metodo)

        $.ajax({
            url: 'util/ajax/banner.php',
            type: 'POST',
            dataType: 'json',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            error: function (error) { console.log(error) },
            beforeSend: function () {
                $("button[type=submit]").html("Procesando..!!").prop({ disabled: true })
            },
            success: function (response) {

                var { estado, msj, data } = response

                switch (estado) {
                    case 1:
                        swalMixin(msj)
                        LimpiarForm();
                        break;
                    case 2:
                        $("button[type=submit]").html("Guardar").prop({ disabled: false })

                        swalMixin(msj, "warning")
                        break;
                }
            }
        })

        return false
    })

    // SELECCIONAR ITEMS
    $("#selectedItems").change(function () {
        let items = parseInt($(this).val()),
            pagina = parseInt($(".paginacion").find('.page-item.active>.page-link').data("pagina"))

        cargarBanner(items, pagina)
    })

    // PAGINA CLICK
    $(".paginacion").on('click', 'a.page-link', function () {
        var items = parseInt($("#selectedItems :selected").val());
        var { pagina } = $(this).data()
        cargarBanner(items, pagina)
    })


    $("#selectedTipoBanner").change(function () {
        let items = parseInt($("#selectedItems :selected").val()),
            pagina = parseInt($(".paginacion").find('.page-item>.page-link').data("pagina"))

        if (isNaN(pagina)) {
            pagina = 1
        }

        cargarBanner(items, pagina);
    })

    $(".banner").on("click", 'input:checkbox', function () {
        let data = $(this).data();
        data.metodo = "AEB"

        if (data.estado == 1) {
            data.estado = 0
        } else {
            data.estado = 1
        }

        $.ajax({
            url: 'util/ajax/banner.php',
            type: 'POST',
            dataType: 'json',
            data,
            success: function (response) {
                console.log(response)
                let { estado, msj } = response
                switch (estado) {
                    case 1:
                        let items = parseInt($("#selectedItems :selected").val()),
                            pagina = parseInt($(".paginacion").find('.page-item.active>.page-link').data("pagina"))

                        swalMixin(msj)
                        cargarBanner(items, pagina)
                        break;
                    case 2:
                        swalMixin(msj)
                        break;
                }
            }
        })
    })

    $(".banner").on("click", ".btn-editar", function () {
        let data = $(this).data()
        data.metodo = "OBS"

        $.ajax({
            url: 'util/ajax/banner.php',
            type: 'POST',
            dataType: 'json',
            data,
            success: function (response) {

                var { estado, msj, data } = response

                switch (estado) {
                    case 1:
                        let { idbannerDet, imagen, tipoBanner } = data

                        $("#idbanner").val(Number(idbannerDet))
                        $("img#imgPre").attr({ src: `${imagen}?v=${new Date().getMilliseconds()}` })
                        $(`#selectedTipoBannerForm option[value=${tipoBanner}]`).prop({ selected: true })
                        $("button[type=button].banner").html("Actualizar")

                        $("button#editarproducto-tab").tab("show")
                        break
                }
            }
        })
    })
})

const CargarSelected = () => {
    $.ajax({
        url: 'util/ajax/banner.php',
        type: 'POST',
        dataType: 'json',
        data: {
            metodo: 'CCTB'
        },
        success: function (response) {
            var { estado, msj, data } = response
            switch (estado) {
                case 1:
                    let { tipoBanner } = data, option = "";

                    tipoBanner.map((item, i) => {
                        option += `<option ${i == 0 ? 'selected' : ''} value='${parseInt(item['idbanner'])}'>${item['tipo_banner']}</option>`
                    })

                    $("#selectedTipoBanner, #selectedTipoBannerForm").html(option)
                    break
            }
        },
        complete: function () {
            ObtenerSelected(cargarBanner)
        }
    })
}

const cargarBanner = (items, pagina = 1) => {
    let idselected = parseInt($("#selectedTipoBanner :selected").val());

    $.ajax({
        url: 'util/ajax/banner.php',
        type: 'POST',
        dataType: 'json',
        data: {
            metodo: 'CTB',
            items,
            pagina,
            id: idselected
        },
        beforeSend: function () {
            let nodata = `
            <div class="text-center p-3">
            <i class="fa fa-circle-o-notch fa-fw fa-spin"></i> Cargando datos
            </div>
        `
            $(".banner").html(nodata)
            $(".mostrar").empty();
            $(".paginacion").empty();
        },
        success: function (response) {
            var { estado, msj, data } = response

            switch (estado) {
                case 1:
                    let { paginacion, mostrar, banners } = data, tarjeta = ""

                    banners.map((item, i) => {
                        tarjeta += `
                            <div class="col-4 mt-3">
                                <div class='card shadow-sm'>
                                    <img loading="lazy" id="imgPre" src="${item['imagen']}?v=${new Date().getMilliseconds()}" alt="" class="bd-placeholder-img card-img-top">
                                    <div class='card-body d-flex justify-content-between'>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" class="check" type="checkbox" id="flexSwitchCheckChecked" data-id=${parseInt(item['idbannerDet'])} data-estado=${parseInt(item['estado'])} ${parseInt(item['estado']) == 1 ? 'checked' : ''}>
                                        <label class="form-check-label" for="flexSwitchCheckChecked">${parseInt(item['estado']) == 1 ? 'Activo' : 'Inactivo'}</label>
                                    </div>

                                    <button type='button' data-id=${parseInt(item['idbannerDet'])} class='btn btn-sm btn-success btn-editar'>
                                        Editar
                                    </button>

                                    </div>
                                </div>
                            </div>
                        `
                    })

                    $(".banner").html(tarjeta)
                    $(".mostrar").html(mostrar);
                    $(".paginacion").html(paginacion);
                    break

                case 2:
                    let nodata = `
                        <div class="text-center p-3">
                            ${msj}
                        </div>
                    `
                    $(".banner").html(nodata)
                    $(".mostrar").empty();
                    $(".paginacion").empty();
                    break
            }
        }
    })
}

const LimpiarForm = () => {
    let item = parseInt($("#selectedItems :selected").val()),
        pagina = parseInt($(".paginacion").find('a.page-link').data("pagina"))

    cargarBanner(item, pagina)
    $("#idbanner").val(0)
    $("#formBanner").trigger("reset");
    $("button#listaproducto-tab").tab("show")
    $("button[type=submit]").html("Guardar").prop({ disabled: false })
    $("#formBanner").find("#imgPre").attr({ src: `img/producto/no-producto.png?v=${new Date().getSeconds()}` })
}