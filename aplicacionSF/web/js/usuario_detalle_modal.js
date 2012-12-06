var UsuarioModal = (function(){
    //variables privadas
    var usuario, cargos, misiones;
    
    //metodos privados
    
    //Prepara a los usuarios para ser impresos
    var procesarUsuario = function procesarUsuario(info){
       var user = info;
       user.universidad  = (usuario['PastoralUniversidad']) ? usuario['PastoralUniversidad']:'Sin universidad';
       user.carrera      = (usuario['PastoralCarrera']) ? usuario['PastoralCarrera']:'Sin carrera';
       user.comuna       = (usuario['PastoralComuna']) ? usuario['PastoralComuna']: 'Sin comuna';
       user.movimiento   = (usuario['PastoralMovimiento']) ? usuario['PastoralMovimiento']:'Ninguno';
       user.email        = usuario['User'].email_address;
       return user;
    }
    return{        
        crear_modal: function crear_modal(usuario_id,append_to,mue_id){
            //Obtenemos la informacion del usuario
            $.get(routing.url_for('usuario', 'AjaxGetInfoUsuarioParaModal'), { usuario_id:usuario_id, mue_id:mue_id },
            function(data){
                usuario = procesarUsuario(data[0]);
                if(mue_id>0)
                    usuario.cuota = data[3];
                cargos = data[1];
                misiones = data[2];
            });
        }
    }
})()


$(function()
{
    $(".show_info_usuarios").click(function(){
        crear_modal(this.getAttribute('value'),$("#info_usuarios"),this.getAttribute('mue'));
        show_info_usuarios(this.getAttribute('value'));
    });
});
      
function crear_modal(usuario_id,append_to,mue_id)
{ 
   modal ="";
   $.get(routing.url_for('usuario', 'AjaxGetInfoUsuarioParaModal'), { usuario_id:usuario_id, mue_id:mue_id },
   function(data){
       usuario = data[0];
       cuota = "";
       if(mue_id>0)
          cuota = printRow("Cuota", data[3], "odd");
       universidad  = (usuario['PastoralUniversidad']) ? usuario['PastoralUniversidad']:'Sin universidad';
       carrera      = (usuario['PastoralCarrera']) ? usuario['PastoralCarrera']:'Sin carrera';
       comuna       = (usuario['PastoralComuna']) ? usuario['PastoralComuna']: 'Sin comuna';
       movimiento   = (usuario['PastoralMovimiento']) ? usuario['PastoralMovimiento']:'Ninguno';
       email        = usuario['User'].email_address;
       
       informacion_string = '                                                                       '+
          "<table class='table-compact table-bordered table-striped' style='text-align:left;'>"                    +
                printRow("Rut", usuario.rut, "odd")                                                  +
                printRow("Nombre", usuario.nombre, "even")                                           +
                printRow("Apellido Paterno", usuario.apellido_paterno, "odd")                        +
                printRow("Apellido Materno", usuario.apellido_materno, "even")                       +
                cuota                                                                                +
                printRow("Sexo", usuario.sexo, "even")                                               +
                printRow("Fecha de Nacimiento", usuario.fecha_nacimiento.split(" ")[0], "odd")                        +
                printRow("Colegio / Universidad", universidad.nombre, "even")                          +
                printRow("Carrera", carrera.nombre, "odd")                                           +
                printRow("A&ntilde;o Entrada / Curso", usuario.ano_ingreso, "even")                  +
                printRow("Comuna", comuna.nombre, "odd")                                             +
                printRow("Celular", usuario.telefono_celular, "even")                                +
                printRow("Email", email, "odd")                                                      +
                printRow("Movimiento / Espiritualidad", movimiento.nombre, "even")                     +
                printRow("Enfermedades / Alergias", usuario.enfermedades_alergias, "odd")              +
                printRow("Contacto de Emergencia", usuario.telefono_emergencia, "even")                 +
          "</table>"                                                                                 ;
       cargos = data[1];
       misiones = data[2];
       cargos_string = misiones_string = "";
       if(cargos.length>0)
       {
           cargos_string = "                                                                            "+
           "<table class='table table-bordered table-striped' style='text-align:left;'>                               "+
           "    <tr>                                                                                    "+
           "        <th>Cargo</th>                                                                      "+
           "        <th>Proyecto Version</th>                                                           "+
           "        <th>Grupo</th>                                                                      "+
           "        <th>Zona</th>                                                                       "+
           "    </tr>                                                                                   ";
           for(i=0;i<cargos.length;i++)
           {
                cargo = cargos[i];
                if(cargo.mision_id>0)
                {
                   cargos_string += ''+
                   "<tr>"+
                       "<td>"+cargo['PastoralCargo']['nombre']+"</td>"+
                       "<td>"+cargo['PastoralMision']['PastoralGrupo']['PastoralProyectoVersion']['PastoralProyecto']['nombre']+
                          " "+cargo['PastoralMision']['PastoralGrupo']['PastoralProyectoVersion']['version']+"</td>"+
                       "<td>"+cargo['PastoralMision']['PastoralGrupo']['nombre']+"</td>"+
                       "<td>"+cargo['PastoralMision']['PastoralLocalidadFantasia']['nombre']+"</td>"+
                   "</tr>";
                }
                else if(cargo.grupo_id>0)
                {
                   cargos_string += ''+
                   "<tr>"+
                       "<td>"+cargo['PastoralCargo']['nombre']+"</td>"+
                       "<td>"+cargo['PastoralGrupo']['PastoralProyectoVersion']['PastoralProyecto']['nombre']+
                          " "+cargo['PastoralGrupo']['PastoralProyectoVersion']['version']+"</td>"+
                       "<td>"+cargo['PastoralGrupo']['nombre']+"</td>"+
                       "<td></td>"+
                   "</tr>";
                }
                else if(cargo.proyecto_version_id>0)
                {
                   cargos_string += ''+
                   "<tr>"+
                       "<td>"+cargo['PastoralCargo']['nombre']+"</td>"+
                       "<td>"+cargo['PastoralProyectoVersion']['PastoralProyecto']['nombre']+
                          " "+cargo['PastoralProyectoVersion']['version']+"</td>"+
                       "<td></td>"+
                       "<td></td>"+
                   "</tr>";
                }
           }
           cargos_string += "</table>"    ;
       }
       
       if(misiones.length>0)
       {
           misiones_string = "                                                                          "+
           "<table class='table table-bordered table-striped' style='text-align:left;'>                               "+
           "    <tr>                                                                                    "+
           "        <th>Proyecto Version</th>                                                           "+
           "        <th>Grupo</th>                                                                      "+
           "        <th>Zona</th>                                                                       "+
           "        <th>Estado</th>                                                                     "+
           "    </tr>                                                                                   ";
           for(i=0;i<misiones.length;i++)
           {
               mue = misiones[i];
               misiones_string += ''+
               "<tr>"+
                   "<td>"+mue['PastoralMision']['PastoralGrupo']['PastoralProyectoVersion']['PastoralProyecto']['nombre']+
                      " "+mue['PastoralMision']['PastoralGrupo']['PastoralProyectoVersion']['version']+"</td>"+
                   "<td>"+mue['PastoralMision']['PastoralGrupo']['nombre']+"</td>"+
                   "<td>"+mue['PastoralMision']['PastoralLocalidadFantasia']['nombre']+"</td>"+
                   "<td>"+mue['PastoralEstadoPostulacion']['nombre']+"</td>"+
               "</tr>";
           }
       }
       
       modal = '                                                                                               '+
       '<div class="modal fade in hide" id="'+usuario.id+'_modal_usuario">                                     '+
       '<button type="button" class="close" data-dismiss="modal">x</button>                                    '+
       '   <div class="tabbable">                                                                              '+
       '       <ul class="nav nav-tabs">                                                                       '+
       '           <li class="active"><a href="#tab1" data-toggle="tab">Informaci&oacute;n</a></li>            ';
       if(cargos.length>0)
          modal += '                                                                                           '+
       '           <li><a href="#tab2" data-toggle="tab">Cargos</a></li>                                       ';
       if(misiones.length>0)
          modal += '                                                                                           '+
       '           <li><a href="#tab3" data-toggle="tab">Misiones</a></li>                                     ';
       modal += '                                                                                              '+
       '       </ul>                                                                                           '+
       '       <div class="tab-content">                                                                       '+
       '           <div class="tab-pane active" id="tab1" style="margin-left:20px;margin-bottom:20px;">        '+
                      informacion_string                                                                        +
       '           </div>                                                                                      '+
       '           <div class="tab-pane" id="tab2" style="margin-left:20px;margin-bottom:20px;">               '+
                      cargos_string                                                                             +
       '           </div>                                                                                      '+
       '           <div class="tab-pane" id="tab3" style="margin-left:20px;margin-bottom:20px;">               '+
                      misiones_string                                                                           +
       '           </div>                                                                                      '+
       '       </div>                                                                                          '+
       '   </div>                                                                                              '+
       '</div>                                                                                                 ';
       append_to.html(modal);
       $("#"+usuario.id+"_modal_usuario").modal('show');
       $()
   }, "json"); 
}                                                                                        

function printRow(label, data, classRow)
{
  if(data == null)
    data = "";
    return "<tr class='"+classRow+"'>"+
        "<th class='span3'>"+label+"</th>"+
        "<td class='span4'>"+data+"</td>"+
    "</tr>";
}