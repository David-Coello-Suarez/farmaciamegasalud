 <!-- Breadcrumb Start-->
 <ul class="breadcrumb">
     <li><a href="inicio"><i class="fa fa-home"></i></a></li>
     <li><a href="#" class="tituloC"></a></li>
 </ul>
 <!-- Breadcrumb End-->
 <div class="row">
     <!--Left Part Start -->
     <aside id="column-left" class="col-sm-3 hidden-xs">
         <h3 class="subtitle">Categorias</h3>
         <div class="box-category">
             <ul id="cat_accordion" class="categoriasMenu">
             </ul>
         </div>
     </aside>
     <!--Left Part End -->
     <!--Middle Part Start-->
     <div id="content" class="col-sm-9">
         <h1 class="title titulo"></h1>
         <div class="product-filter">
             <div class="row">
                 <div class="col-md-4 col-sm-5">
                     <div class="btn-group">
                         <button type="button" id="list-view" class="btn btn-default" data-toggle="tooltip" title="Lista"><i class="fa fa-th-list"></i></button>
                         <button type="button" id="grid-view" class="btn btn-default" data-toggle="tooltip" title="Cuadricula"><i class="fa fa-th"></i></button>
                     </div>
                 </div>
                 <div class="col-md-5"></div>
                 <div class="col-sm-3" style="display: flex;align-items: flex-start;">
                     <label class="control-label" for="input-limit" style="margin-right: 1rem;">Mostrar:</label>
                     <!-- </div>
                 <div class="col-sm-2 text-right"> -->
                     <select id="input-limit" class="form-control">
                         <option value="25" selected="selected">25</option>
                         <option value="50">50</option>
                         <option value="75">75</option>
                         <option value="100">100</option>
                         <option value="0">Todos</option>
                     </select>
                 </div>
             </div>
         </div>
         <br />
         <div class="row products-category">
         </div>
         <div class="row">
             <div class="col-sm-6 text-left paginacion">
             </div>
             <div class="col-sm-6 text-right mostrar"></div>
         </div>
     </div>
     <!--Middle Part End -->