<form id ="f1" action = "http://localhost:8080/frontend_dev.php/usuario/AjaxLogin">
  <input type="text" name="user" id="user"/>
  <input type="text" name="pass" id="pass"/>
  <input type = "button" id = "b1" value = "aprietame"/>
</form>
<script>
  $("#b1").click(function(){
  
    alert($("#f1").serialize());
    
    $.post("http://localhost:8080/frontend_dev.php/usuario/AjaxLogin",
      $("#f1").serialize()
    //{user:$("#user").val(), pass:$("#pass").val() }
    , function(data){alert(data)});
  
  });
</script>


 <script>
        function onSuccess(data)
        {
        	//$.mobile.changePage("#page2");
            alert(data);
            data = $.trim(data);
            $("#notification").text(data);
        }
 
        function onError(data, status)
        {
            //$.mobile.changePage("#page4");
            data = $.trim(data);
            $("#notification").text(data);
        }        
 
        $(document).ready(function() {
            $("#b3").click(function(){
                var formData = $("#AJAXLoginForm").serialize();
                alert(formData);
                $.ajax({
                    type: "POST",
                    url: "http://localhost:8080/frontend_dev.php/usuario/AjaxLogin",
                    cache: false,
                    data: formData,
                    success: onSuccess,
                    error: onError
                });
 
                return false;
            });
        });
    	</script>
       
       
    <form id = "AJAXLoginForm" action="">
 
                <input id="textinput1" name="user" placeholder="e-mail" value="" type="email" />


                <input id="textinput2" name="pass" placeholder="" value="" type="password" />
            
                <input type = "button" id = "b3" value = "aprietame"/>
        

    </form>