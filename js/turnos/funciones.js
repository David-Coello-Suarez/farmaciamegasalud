$(document).ready(function () {
    ListarTurnos()
})

function ListarTurnos() {
    $.ajax({
        url: 'util/ajax/turnos.php',
        type: 'POST',
        dataType: 'json',
        data: {
            metodo: 'LTW'
        },
        // error: function (err) { console.log(err) },
        success: function (response) {
            switch (response.estado) {
                case 1:
                    var tarjetas = "", { data } = response
                    data.cuidades.map(function(item){
                        tarjetas += `<h1 class="title">${item['ciudad']}</h1>`
                        tarjetas += `<div class="blog blog-grid">`
                        tarjetas += `<div class="row">`

                        item['farmacias'].map(function(itemInt){
                            tarjetas +=`<div class="col-md-4">`
                            tarjetas += `<div class="blog-entry">`

                            tarjetas += `<div class="image"> <a href="#"><img class="img-responsive" width="100%" height="200" src="img/farmacias/01.jpg?v=${new Date().getSeconds()}" alt=""></a> </div>`
                            tarjetas += `<h3 class="post_title_blog"><a href="#">${itemInt['direccion']}</a></h3>`
                            tarjetas += `<p class="description">Referncia: ${itemInt['referencia']}</p>`
                            tarjetas += `<a href="tel:04${itemInt['telefono'].replace(/\s+/g,"")},ext=${itemInt['ext']}" class="description">Telefono: ${itemInt['telefono']} Extención: ${itemInt['ext']}</a>`

                            tarjetas +=`</div>`
                            tarjetas += `</div>`
                        })

                        tarjetas += `</div>`
                        tarjetas += `</div>`
                    })
                    $("#content").html(tarjetas)
                    break
            }
        }
    })
}