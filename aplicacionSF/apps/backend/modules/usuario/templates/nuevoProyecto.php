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
            <th>Jefes nacionales</th>
            <td>
              <div class="well">
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
    <h2>Asignación de Regiones</h2>
    <p>Nombre de la región: <input type="text" class="span3" style="margin: 0 auto;" data-provide="typeahead" data-items="4" data-source='["Zona norte","Zona Centro","Zona Sur"]'></p>
    </br>
    <p> Zonas que incluye: <small>Presiona la tecla control y selecciona las localidades que correspondan</small> <div class="controls">
                <select multiple="multiple" id="multiSelect">
                  <option >Villarrica</option>
                  <option>Panguipulli</option>
                  <option>Calafquen</option>
                  <option>Lota</option>
                  <option>Alto Hospicio</option>
                </select>
              </div>
    </p>
  <button class="btn btn-primary">Agregar región</button>
  <hr>
  <!-- Esto se debe generar al momento agregarse una región, debiendo estar seleccionadas las opciones que se hayan elegido-->
  <h3>Lista de Regiones</h3>
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
  </div>
</div>
</div>