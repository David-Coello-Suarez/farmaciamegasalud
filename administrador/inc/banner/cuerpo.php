<ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="listaproducto-tab" data-bs-toggle="tab" data-bs-target="#listaproducto" type="button" role="tab" aria-controls="listaproducto" aria-selected="true">Lista de banners</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link " id="editarproducto-tab" data-bs-toggle="tab" data-bs-target="#editarproducto" type="button" role="tab" aria-controls="editarproducto" aria-selected="false">Editar banner</button>
    </li>
</ul>
<style>
    select {
        font-family: 'FontAwesome', 'Second Font name';
    }

    select option.text-center {
        -webkit-animation: fa-spin 2s infinite linear;
        animation: fa-spin 2s infinite linear;
    }
</style>
<div class="tab-content py-2" id="myTabContent">
    <div class="tab-pane fade show active" id="listaproducto" role="tabpanel" aria-labelledby="listaproducto-tab">
        <div class="row">
            <div class="col-md-2">
                <div class="form-floating">
                    <select class="form-select form-select-sm" id="selectedTipoBanner">
                        <option class="text-center">&#xf1ce; </option>
                    </select>
                    <label for="selectedTipoBanner">Tipo de banner: </label>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-floating">
                    <select class="form-select form-select-sm" id="selectedItems">
                        <option class="text-center">&#xf1ce; </option>
                    </select>
                    <label for="selectedItems">Mostrar: </label>
                </div>
            </div>
        </div>

        <div class="row mt-2 banner mb-2">
            <div class="text-center p-3">
                <i class="fa fa-circle-o-notch fa-fw fa-spin"></i> Cargando datos
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 text-center text-md-start paginacion"></div>
            <div class="col-md-6 mostrar text-center text-md-end"></div>
        </div>
    </div>

    <div class="tab-pane fade" id="editarproducto" role="tabpanel" aria-labelledby="editarproducto-tab">

        <div class="row">
            <div class="col-4 offset-4">
                <form id="formBanner">
                    <input type="hidden" id="idbanner" name="idbanner" value="0">
                    <div class="card shadow-sm">
                        <img id="imgPre" src="img/producto/no-producto.png?v=<? echo rand() ?>" alt="" class="bd-placeholder-img card-img-top">
                        <div class="mx-3 mt-2">
                            <input type="file" name="img" id="img" class="d-none" accept="image/png,image/jpg,image/jpeg" />
                            <label for="img" class="btn btn-sm btn-success w-100">Seleccionar banner</label>
                        </div>

                        <div class="card-body">
                            <div class="form-floating">
                                <select class="form-select form-select-sm" id="selectedTipoBannerForm" name="selectedTipoBannerForm">
                                    <option class="text-center">&#xf1ce; </option>
                                </select>
                                <label for="selectedTipoBannerForm">Tipo de banner: </label>
                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-sm btn-success">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>