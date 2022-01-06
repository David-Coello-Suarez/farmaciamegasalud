<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 imgDrive"></div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-lg">
        <form id="formDrive">
            <input type="hidden" name="iddrive" id="iddrive" value="0">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <div class="row">
                            <div class="col-6 text-center">
                                <img class="img-fluid" id="imgDrive">
                                <hr>
                                <label for="img" class="btn btn-outline-success w-100">Selecciona la imagen</label>
                                <input type="file" name="img" id="img" class="d-none" accept="image/png,imge/jpeg,image/jpg">
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <textarea name="nombre" id="nombre" class="form-control form-control-sm" required placeholder="Nombre de imagen"></textarea>
                                            <label for="nombre">Nombre Imagen (*)</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <textarea name="url" id="url" class="form-control form-control-sm h-auto" rows="6" required placeholder="Dirección de archivo"></textarea>
                                            <label for="url">Url de archivo (*)</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="number" name="orden" id="orden" min=1 class="form-control form-control-sm">
                                            <label for="orden">Orden de visualización</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-outline-secondary cerrar" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-sm btn-success guardar">Guardar cambios</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- <textarea name="" id="" cols="30" rows="10"></textarea> -->