<ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="listacategoria-tab" onclick="LimpiarFormulario()" data-bs-toggle="tab" data-bs-target="#listacategoria" type="button" role="tab" aria-controls="listacategoria" aria-selected="true">Lista de Categorias</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link " id="editarcategoria-tab" data-bs-toggle="tab" data-bs-target="#editarcategoria" type="button" role="tab" aria-controls="editarcategoria" aria-selected="false">Editar Categoria</button>
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
        </div>

        <div class="table-responsive">
            <table class="table table-striped caption-top">
                <caption>Lista de productos</caption>
                <thead>
                    <tr>
                        <th class="text-center">
                            #
                        </th>
                        <th class="text-center">
                            Editar
                        </th>
                        <th class="text-center">
                            Estado
                        </th>
                        <th class="text-center">
                            Nombre
                        </th>
                        <th class="text-center">
                            Descripción
                        </th>
                        <th class="text-center">
                            creado
                        </th>
                        <th class="text-center">
                            Actualizado
                        </th>
                    </tr>
                </thead>
                <tbody class="tbodyCategoria">
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-md-6 text-center text-md-start paginacion"></div>
            <div class="col-md-6 mostrar text-center text-md-end"></div>
        </div>
    </div>
    <div class="tab-pane fade" id="editarcategoria" role="tabpanel" aria-labelledby="editarcategoria-tab">
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-outline-warning" id="agregarmas">
                    <i class="fa fa-plus me-2"></i> Añadir Categoria
                </button>
            </div>
        </div>

        <form id="formCategoria">
            <input type="hidden" name="idcategoria" id="idcategoria" value="0" />
            <div class="album pt-3 bg-light">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 tarjetasCategorias">
                    <div class="col mx-lg-auto categoria">
                        <div class="card shadow">
                            <div class="card-header d-flex">
                                <h5 class="my-auto">Nueva Categoria</h5>
                                <button type="button" class="btn btn-outline-warning btn-sm ms-auto d-none btn-quitar" title="Quitar">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="row g-2 mt-0">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control form-control-sm" id="nombre" required placeholder="Nombre de la categoria" name="nombre[]">
                                            <label for="codigo">Nombre de la categoría</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control form-control-sm" required name="descripcion[]" id="descripcion" placeholder="Descipción de la categoria"></textarea>
                                            <label for="descripcion">Descripción de la categoría</label>
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
                        <i class="fa fa-save"></i> Guardar Categoria (s)
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>