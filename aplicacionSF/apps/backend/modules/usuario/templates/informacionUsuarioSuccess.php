<div class="page-header">
    <h1>Crea un nuevo Proyecto<small> En este proceso también crearás una instancia anual del proyecto</small></h1>
</div>


<div class="row">

  <div class="span5">
      <div class="well">
      <h2>Información general</h2>
      <table class=" table table-bordered table-striped table-condensed" class="btn">
        <tbody>
          <tr class ='normal'>
            <th>Nombre del Proyecto</th>
            <td><input type="text"/></td>
          </tr>
          <tr class ='normal'>
            <th>Url del logo</th>
            <td><input type="text"/></td>
          </tr>
          <tr class ='normal'>
            <th>Página web</th>
            <td><input type="text"/></td>
          </tr>
          <tr class ='normal'>
            <th>Descripción</th>
            <td><textarea class="input-xlarge" id="textarea" rows="3"/></textarea></td>
          </tr>
          <tr class ='normal'>
            <th>versión</th>
            <td>1</td>
          </tr>
          <tr class ='normal'>
            <th>Año</th>
            <td><div class="controls">
                <select class="span2">
                  <option>2010</option>
                  <option>2011</option>
                  <option selected="selected">2012</option>
                  <option>2013</option>
                </select>
              </div></td>
          </tr>
          <tr class ='normal'>
            <th>Jefes nacionales</th>
            <td>
              <div>
                <input type="text" class="span3" style="margin: 0 auto;" data-provide="typeahead" data-items="4" data-source='["Jorge Mezzano","Diego Cabrera","Oscar Fuentes"]'>
              </div>
              La idea es que pueda seleccionar más de uno en este mismo imput como al agregar listas en un post de google plus.
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="span5">
    <div class="well">
    <h2>Asignación de Grupos</h2>

     <div id="myModal" class="modal hide ">
            <div class="modal-header">
              <button class="close" data-dismiss="modal">&times;</button>
              <h3>Crea un nuevo grupo</h3>
            </div>
            <div class="modal-body">
              <h4>Seleciona un nombre para el grupo</h4>
              <p>Nombres comunes son Zona Norte, Zona Centro y Zona Sur.</p>
              <input type="text" class="span3" style="margin: 0 auto;" data-provide="typeahead" data-items="4" data-source='["Zona norte","Zona Centro","Zona Sur"]'>

              <h4>Agrega las localidades que incluye</h4>
              <p>Presiona la tecla control y selecciona las localidades que correspondan.</p>
              <div class="controls">
                <select multiple="multiple" id="multiSelect">
                  <option >Villarrica</option>
                  <option>Panguipulli</option>
                  <option>Calafquen</option>
                  <option>Lota</option>
                  <option>Alto Hospicio</option>
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <a href="#" class="btn" data-dismiss="modal" >Cerrar</a>
              <a href="#" class="btn btn-primary">Crear Grupo</a>
            </div>
          </div>
          <a data-toggle="modal" href="#myModal" class="btn btn-primary btn-medium">Agregar Grupo</a>

  <hr>
  <!-- Esto se debe generar al momento agregarse una región, debiendo estar seleccionadas las opciones que se hayan elegido-->
  <h2>Grupos</h2>
  <h4>Zona Norte</h4>
    <div class="controls">
                <select class="span2">
                  <option>Villarrica</option>
                  <option>Panguipulli</option>
                  <option>Calafquen</option>
                  <option>Lota</option>
                  <option>Alto Hospicio</option>
                </select>
              </div>
    <button class="btn btn-warning">Editar Región</button>
    </br>
    <h5>Puedes agregar inmediatamente a los jefes de zona entrando a editar Region</h5>
    <hr>
     <button class="btn btn-inverse btn-large">Crear</button>
  </div>
</div>
</div>