<ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="listafarmacia-tab" data-bs-toggle="tab" data-bs-target="#listafarmacia" type="button" role="tab" aria-controls="listafarmacia" aria-selected="true">Lista de Farmacias</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="editarfarmacia-tab" data-bs-toggle="tab" data-bs-target="#editarfarmacia" type="button" role="tab" aria-controls="editarfarmacia" aria-selected="false">Editar Farmacia</button>
    </li>
</ul>
<div class="tab-content py-2" id="myTabContent">
    <div class="tab-pane fade show active" id="listafarmacia" role="tabpanel" aria-labelledby="listafarmacia-tab">
        <div class="row">
            <div class="col-md-2">
                <div class="form-floating">
                    <select class="form-select form-select-sm" id="selectedItems"></select>
                    <label for="selectedItems">Mostrar: </label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-floating">
                    <select class="form-select form-select-sm" id="selectedCiudad"></select>
                    <label for="selectedItems">Ciudad: </label>
                </div>
            </div>
        </div>

        <div class="row farmacias mt-2">
            <div class="text-center p-3">
                <i class="fa fa-circle-o-notch fa-fw fa-spin"></i> Cargando datos
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 text-center text-md-start paginacion"></div>
            <div class="col-md-6 mostrar text-center text-md-end"></div>
        </div>
    </div>

    <div class="tab-pane fade" id="editarfarmacia" role="tabpanel" aria-labelledby="editarfarmacia-tab">
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-outline-warning" id="agregarmas">
                    <i class="fa fa-plus me-2"></i> Añadir Categoria
                </button>
            </div>
        </div>

        <form id="formularioFarmacia">
            <input type="hidden" name="idfarmacia" id="idfarmacia" value="0" />
            <div class="album pt-3 bg-light">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 farmaciasInt">
                    <div class="col mx-lg-auto farmacia">
                        <div class="card shadow-sm">
                            <div class="card-header d-flex">
                                <h5 class="my-auto">
                                    Nueva Farmacia
                                </h5>
                                <button type="button" class="btn btn-outline-warning btn-sm ms-auto d-none btn-quitar" title="Quitar">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            </div>
                            <img class="bd-placeholder-img card-img-top" id="imgfarmacia" width="100%" height="225" src="img/farmacias/no-farmacia.png?v=<? echo $random; ?>" />
                            <div class="mx-3 mt-2">
                                <input type="file" class="form-control" id="image" name="image[]" accept="image/png,image/jpg,image/jpeg" />
                            </div>
                            <div class="card-body">
                                <div class="form-floating mb-2">
                                    <textarea class="form-control form-control-sm" name="direccion[]" id="direccion" style="height: 70px;" placeholder="Dirección"></textarea>
                                    <label for="direccion">Dirección (*)</label>
                                </div>
                                <div class="form-floating">
                                    <textarea class="form-control form-control-sm" name="referencia[]" id="referencia" style="height: 70px;" placeholder="Referencia"></textarea>
                                    <label for="referencia">Referencia (*)</label>
                                </div>
                                <div class="row g-2 mt-0">
                                    <div class="col">
                                        <div class="form-floating">
                                            <input type="tel" class="form-control form-control-sm" id="telefono" placeholder="00001" name="telefono[]" onkeypress="return validarNumero(event);" />
                                            <label for="telefono">Telefono (*)</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating">
                                            <input type="tel" class="form-control form-control-sm" id="extencion" placeholder="00001" name="extencion[]" onkeypress="return validarNumero(event);" />
                                            <label for="extencion">Extención (*)</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mt-0">
                                    <div class="col">
                                        <div class="form-floating">
                                            <input type="text" class="form-control form-control-sm" id="googlemaps" placeholder="00001" name="googlemaps[]" />
                                            <label for="googlemaps">Dirección Google Maps (*)</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mt-0">
                                    <div class="col">
                                        <div class="form-floating">
                                            <select class="form-select" id="ciudad" name="ciudad[]"></select>
                                            <label for="farmacia">Seleccione la ciudad</label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-success" id="guardar">
                        <i class="fa fa-save me-2"></i> Guardar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>