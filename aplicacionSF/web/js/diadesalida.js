$(document).ready(function($){
	$(function()
	{ 
	    
	    $('#buscarRutInput').Rut();
	    
	    $('#buscarPorRut').click(Busqueda);    
	    
	    $('#BotonEstadoDePago').click(function(){
	         
	         var rut = $("#buscarRutInput").val();
	         var cuota_solidaria = $("#cuotaSolidaria").val();       
	
	         var esNumero = isNumber(cuota_solidaria);
	         var esPositivo = false;
	         
	         if(esNumero){
	            if(cuota_solidaria>=0){
	                esPositivo = true;
	            }
	         }
	         
	         
	         if($("#pagoCuota").is(':checked'))
	              var checkBox = 1;
	         else var checkBox = 0;
	         
	         if(checkBox==1){
	              if(esNumero){
	                  if(esPositivo){
	                      $.get('diadesalida/AjaxCambiarEstadoCuota', { rut_misionero: rut, cuotaSolidaria: cuota_solidaria }, function(data){ 
	                          if(data==1){                   
	                             document.getElementById('cambios').style.display = 'none';
	                             document.getElementById('resultado').style.display = 'none';
	                             Busqueda();
	           
	                          }
	                          else{
	                              alert('Error! No se ha podido realizar el cambio. Intentelo de nuevo mas tarde.');
	                              document.getElementById('cambios').style.display = 'none';
	                              document.getElementById('resultado').style.display = 'none';
	
	                          }
	                        
	                     });
	                 } // fin del if es Positivo
	                 else{
	                    alert('Debe ingresasr un valor POSITIVO para la CUOTA SOLIDARIA.');
	                 }
	            } // fin del if es Numero
	            else{
	                alert('El valor de CUOTA SOLIDARIA debe ser NUMERICO. Ingrese el monto sin puntos ni comas.');
	            }
	         }
	         else{
	            alert('Marque el checkbox si desea guardar la CUOTA GENERAL como PAGADA para este usuario. No puede agregar una Cuota Solidaria sin el pago de la Cuota General.');
	         
	         }
	
	    });  
	    
	});
	
	
	function Busqueda(){
	      
	     var rut = $("#buscarRutInput").val();
	     var id_proyecto_version = $("#p_version_id").val();
	       
	       
	     if(rut){
	               
	         $.get('diadesalida/AjaxDiaDeSalida', { rut_misionero: rut, version_id: id_proyecto_version},
	            function(data){ 
	                data = jQuery.parseJSON(data);
	                
	                if(data[0]!=null){ 
	                     document.getElementById('resultado').style.display = 'block';
	                     $("#nombreMisionero").val(data[0]);
	                     $("#celularMisionero").val(data[1]);    
	                     $("#cuotaMisionero").val(data[2]);
	                     $("#proyectoMisionero").val(data[3]);
	                     $("#grupoMisionero").val(data[5]);
	                     $("#zonaMisionero").val(data[6]);
	                     $("#cuotaSolidariaReadOnly").val(data[7]);
	                     
	                     if(data[4]){
	                        $("#estadoCuota").val('CUOTA GENERAL PAGADA');
	                        document.getElementById('div_infoCuotaSolidaria').style.display = 'block';
	                     }
	                     else{
	                        $("#estadoCuota").val('Cuota general NO pagada');
	                        document.getElementById('cambios').style.display = 'block';
	                     } 
	                     
	                }
	                
	                else{
	                    document.getElementById('resultado').style.display = 'none';
	                    alert(data[1]);
	                }         
	          });     
	     }
	     else{
	        document.getElementById('resultado').style.display = 'none';
	        alert('Ingrese un Rut para buscar.');
	     }
	         
	 }
	 
	function isNumber(n) {
	  if(n==''){
	    return true;
	  }
	  
	  return !isNaN(parseFloat(n)) && isFinite(n);
	}
});