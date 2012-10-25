<div class="page-header">
    <h1>Crear/Editar Localidad</h1>
</div>


<div class="row">
  <div class="span8">
      <div class="well span8">
      <h2>Información general</h2>
      <table class=" table table-bordered table-striped table-condensed" class="btn">
        <tbody>
          <tr class ='normal'>
            <th>Nombre de la Localidad</th>
            <td><input type="text"/></td>
            <td rowspan="4"> <input type="text" class="search-query span2" placeholder="Search">
            <button class="btn btn-small">Search</button>
            <br></br>
            <img src="http://www.poderpda.com/wp-content/uploads/2012/03/Google-Maps-being-offline-doesnt-mean-being-lost.gif"></td>
          </tr>
          <tr class ='normal'>
            <th>Nombre de fantasía</th>
            <td><input type="text"/></td>
          </tr>
          <tr class ='normal'>
            <th>Descripción</th>
            <td><textarea class="input-xlarge" id="textarea" rows="3"/></textarea></td>
          </tr>
          <tr class ='normal'>
            <th>Coordenadas</th>
            <td><h4>Latitud</h4><input type="text"/><h4>Longitud</h4><input type="text"/></td>
          </tr>
        </tbody>
      </table>
      <?php echo link_to('Atrás', 'usuario/show') ?>      <button class="btn btn-inverse btn-small">Crear/Editar Localidad</button>
    </div>
  </div>
 </div>
</div>

<script type="text/javascript" src="/js/bootstrap-typeahead.js"></script>
<script type="text/javascript" src="/js/bootstrap-modal.js"></script>