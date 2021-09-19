<ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="listaproducto-tab" data-bs-toggle="tab" data-bs-target="#listaproducto" type="button" role="tab" aria-controls="listaproducto" aria-selected="true">Lista de Productos</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link " id="editarproducto-tab" data-bs-toggle="tab" data-bs-target="#editarproducto" type="button" role="tab" aria-controls="editarproducto" aria-selected="false">Editar Producto</button>
    </li>
</ul>

<div class="tab-content py-2" id="myTabContent">
    <div class="tab-pane fade show active" id="listaproducto" role="tabpanel" aria-labelledby="listaproducto-tab">
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
                <caption>Lista de productos
                </caption>
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
                            Código
                        </th>
                        <th class="text-center">
                            Imagen
                        </th>
                        <th class="text-center">
                            Nombre
                        </th>
                        <th class="text-center">
                            Categoria
                        </th>
                        <th class="text-center">
                            Stock
                        </th>
                        <th class="text-center">
                            # Productos en Combo
                        </th>
                        <th class="text-center">
                            P.V.P ($)
                        </th>
                        <th class="text-center">
                            Descuento (%)
                        </th>
                        <th class="text-center">
                            P. Oferta ($)
                        </th>
                    </tr>
                </thead>
                <tbody class="tbodyProducto">
                    <tr>
                        <td colspan="20" class="text-center p-3">
                            No hay productos
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
    <div class="tab-pane fade" id="editarproducto" role="tabpanel" aria-labelledby="editarproducto-tab">
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-outline-info" id="agregarmas">
                    <i class="fa fa-plus me-2"></i> Añadir producto
                </button>
            </div>
        </div>

        <form id="formProductos">
            <input type="hidden" id="metodoutilizar" value="0" />
            <div class="album pt-3 bg-light">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 fila">
                    <div class="col mx-lg-auto tarjeta">
                        <input type="hidden" name="idproducto[]" id="idproducto" value="0" />
                        <div class="card shadow-sm">
                            <img class="bd-placeholder-img card-img-top" id="imgproducto" width="100%" height="225" src="img/producto/no-producto.png?v=<? echo $random; ?>" />
                            <div class="mx-3">
                                <input type="file" class="form-control" id="image" name="image[]" accept="image/png,image/jpg,image/jpeg" />
                            </div>
                            <div class="card-body">
                                <div class="form-floating">
                                    <textarea class="form-control form-control-sm" required placeholder="Leave a comment here" name="nombre[]" id="nombre" style="height: 70px;"></textarea>
                                    <label for="nombre">Nombre</label>
                                </div>
                                <div class="row g-2 mt-0">
                                    <div class="col">
                                        <div class="form-floating">
                                            <input type="number" class="form-control form-control-sm" id="codigo" required placeholder="00001" name="codigo[]" min="1">
                                            <label for="codigo">Código</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating">
                                            <input type="number" class="form-control form-control-sm" id="stock" required placeholder="00001" name="stock[]" min="1">
                                            <label for="stock">Stock</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mt-0">
                                    <div class="col">
                                        <div class="form-floating">
                                            <input type="number" class="form-control form-control-sm" required id="pvp" placeholder="0.01" name="pvp[]" step="0.01" onkeypress="return filterFloat(event,this)">
                                            <label for="pvp">P.V.P ($)</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating">
                                            <input type="number" class="form-control form-control-sm" required id="combo" class="combo" placeholder="00001" name="combo[]" min="1" onkeyup="habilitarDesc(this)">
                                            <label for="combo"># Producto en combo</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mt-0">
                                    <div class="col">
                                        <div class="form-floating">
                                            <input type="number" disabled class="form-control form-control-sm" id="descuento" required placeholder="1" name="descuento[]" min="1" step="0.01" max="100" onkeypress="return filterFloat(event,this)" onkeyup="calcularOferta(this)">
                                            <label for="descuento">Descuento (%)</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating">
                                            <input type="number" readonly class="form-control form-control-sm" id="oferta" pattern="^[0-9]+(.[0-9]+)?$" required placeholder="0.01" name="oferta[]" min="0.01">
                                            <label for="oferta">P. Oferta ($)</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mt-0">
                                    <div class="col">
                                        <div class="form-floating">
                                            <select class="form-select" required id="categoria" name="categoria[]"></select>
                                            <label for="categoria">Seleccione la categoria</label>
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
                        Guardar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>