<ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="listarParametros-tab" data-bs-toggle="tab" data-bs-target="#listarParametros" type="button" role="tab" aria-controls="listarParametros" aria-selected="true">Lista de parámetros</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link " id="editarParametro-tab" data-bs-toggle="tab" data-bs-target="#editarParametro" type="button" role="tab" aria-controls="editarParametro" aria-selected="false">Editar Parámetro</button>
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
                <caption>Lista de parametros</caption>
                <thead>
                    <tr>
                        <th class="text-center">
                            #
                        </th>
                        <th class="text-center">
                            Nombre parámetro
                        </th>
                        <th class="text-center">
                            Descripción
                        </th>
                        
                    </tr>
                </thead>
                <tbody id="tbodyParametro"></tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-md-6 text-center text-md-start paginacion">
                <!-- <ul class="d-inline-flex d-md-flex my-3 pagination">
                </ul> -->
            </div>
            <div class="col-md-6 mostrar text-center text-md-end"></div>
        </div>
    </div>
</div>