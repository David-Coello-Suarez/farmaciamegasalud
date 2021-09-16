$(document).ready(function () {
    $("#formLogin").submit(function (event) {

        event.preventDefault();

        var formData = new FormData($(this)[0]);
        formData.append("metodo", "LG")

        $.ajax({
            url: 'util/ajax/login.php',
            type: 'POST',
            dataType: 'json',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            // error: function (err) { console.log(err) },
            beforeSend: function () {
                $('button[type=submit]').prop({ 'disabled': true }).html("Consultando....!!")
            },
            success: function (response) {
                switch (response.estado) {
                    case 1:
                        location.reload();
                        break;
                    case 2:
                        Swal.fire({
                            icon: 'warning',
                            title: 'Oops...',
                            text: response.msj,
                        })
                        $('button[type=submit]').prop({ 'disabled': false }).html("Iniciar Session")
                        break;
                    default:
                        $('button[type=submit]').prop({ 'disabled': false }).html("Iniciar Session")
                        break;
                }
            }

        })

        return false;
    })
})