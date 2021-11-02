<ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="listaproducto-tab" data-bs-toggle="tab" data-bs-target="#listaproducto" type="button" role="tab" aria-controls="listaproducto" aria-selected="true">Lista de usuarios</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link " id="editarproducto-tab" data-bs-toggle="tab" data-bs-target="#editarproducto" type="button" role="tab" aria-controls="editarproducto" aria-selected="false">Editar usuarios</button>
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
                <caption>Lista de usuarios
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
                            Nombres
                        </th>
                        <th class="text-center">
                            apellidos
                        </th>
                        <th class="text-center">
                            Fecha Nac.
                        </th>
                        <th class="text-center">
                            Móvil
                        </th>
                        <th class="text-center">
                            Correo electrónico
                        </th>
                    </tr>
                </thead>
                <tbody class="tbodyUsuarios">
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

    <div class="tab-pane fade" id="editarproducto" role="tabpanel" aria-labelledby="editarproducto-tab">

        <form id="formUsuario">
            <input type="hidden" id="idusuario" name="idusuario" value="0" />
            <div class="row">
                <div class="col-6 offset-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <p class="text-center m-0">
                                        Datos personales
                                    </p>
                                </div>
                            </div>

                            <div class="row g-2 mt-0">
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" class="form-control form-control-sm" id="nombres" name="nombres"  placeholder="Nombres">
                                        <label for="nombres">Nombres</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" class="form-control form-control-sm" id="apellidos" name="apellidos"  placeholder="apellidos">
                                        <label for="apellidos">Apellidos</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-2 mt-0">
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="date" class="form-control form-control-sm" id="fechaNac" name="fechaNac"  placeholder="Fecha Nac.">
                                        <label for="fechaNac">Fecha Nac.</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" class="form-control form-control-sm" id="movil" name="movil" placeholder="Móvil">
                                        <label for="movil">Móvil</label>
                                    </div>
                                </div>
                            </div>


                            <div class="row mt-2">
                                <div class="col-12">
                                    <p class="text-center m-0">
                                        Usuario
                                    </p>
                                </div>
                            </div>

                            <div class="row g-2 mt-0">
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" class="form-control form-control-sm" id="usuario" name="usuario" placeholder="Correo electrónico">
                                        <label for="usuario">Correo electrónico</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-sm btn-success">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>