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
    </div>
</div>