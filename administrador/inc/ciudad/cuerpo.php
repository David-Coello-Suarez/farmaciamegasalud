<ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="listacategoria-tab" data-bs-toggle="tab" data-bs-target="#listacategoria" type="button" role="tab" aria-controls="listacategoria" aria-selected="true">Lista de ciudades</button>
    </li>
</ul>

<div class="tab-content py-2" id="myTabContent">
    <div class="tab-pane fade show active" id="listacategoria" role="tabpanel" aria-labelledby="listacategoria-tab">
        <div class="row">
            <div class="col-md-2">
                <div class="form-floating">
                    <select class="form-select form-select-sm" id="selectedItems"></select>
                    <label for="selectedItems">Mostrar: </label>
                </div>
            </div>
            <div class="col-md-2">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    <i class="fa fa-plus me-2"></i> Agregar
                </button>

                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <form id="GuardarCiudad">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Agregar m&aacute;s ciudades</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="LimpiarFormulario()"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row g-2 mt-0 Ciudades">
                                        <div class="col-6 mx-auto ciudad">
                                            <div class="input-group form-floating">
                                                <input type="text" class="form-control form-control-sm" id="ciudad" placeholder="Nombre de la ciudad" name="ciudad[]">
                                                <label for="ciudad">Ciudad</label>
                                                <span class="btnQuitar input-group-text">
                                                    <i class="fa fa-trash"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="LimpiarFormulario()">Cerrar</button>
                                    <button type="button" class="btn btn-outline-secondary" id="agregarmas">Agregar M&aacute;s</button>
                                    <button type="submit" class="btn btn-warning">Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped caption-top">
                <caption>Lista de ciudades</caption>
                <thead>
                    <tr>
                        <th class="text-center">
                            #
                        </th>
                        <th class="text-center">
                            Editar
                        </th>
                        <th class="text-center">
                            Nombre de la ciudad
                        </th>
                        <th class="text-center">
                            Estado
                        </th>
                        <th class="text-center">
                            creado
                        </th>
                        <th class="text-center">
                            Actualizado
                        </th>
                    </tr>
                </thead>
                <tbody class="tbodyCiudades">
                    <tr>
                        <td colspan="20" class="text-center p-3">
                            <i class="fa fa-circle-o-notch fa-fw fa-spin"></i> Cargando datos
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-md-6 text-center text-md-start paginacion"></div>
            <div class="col-md-6 mostrar text-center text-md-end"></div>
        </div>
    </div>
</div>