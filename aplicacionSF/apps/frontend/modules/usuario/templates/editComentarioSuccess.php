<div class="page-header">
    <h1>Editar un Comentario</h1>
</div>


<div class="row">

  <div class="span5">
      <div class="well">
      <h2>Información del comentario</h2>
      <table class=" table table-bordered table-striped table-condensed" class="btn">
        <tbody>
          <tr class ='normal'>
            <th>Nombre</th>
            <td><input type="text"/></td>
          </tr>
          <tr class ='normal'>
            <th>Descripción</th>
            <td><textarea class="input-xlarge" id="textarea" rows="3"/></textarea></td>
          </tr>
          <tr class ='normal'>
            <th>Prioridad</th>
            <td><select name="prioridad">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                </select>
			</td>
          </tr>
          <tr class ='normal'>
            <th>Estado</th>
            <td><select name="estado">
                <option value="inactivo">Inactivo</option>
                <option value="proceso">En Proceso</option>
                <option value="terminado">Terminado</option>
            </select>
            </td>
          </tr>
          <tr class ='normal'>
            <th>Tipo</th>
            <td><select name="tipo">
                <option value="espiritual">Espiritual</option>
                <option value="material">Material</option>
            </select>
            </td>
          </tr>
        </tbody>
      </table>
      <button class="btn btn-primary">Modificar comentario</button>
    </div>
  </div>
</div>


