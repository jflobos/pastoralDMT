<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
    <style>
    	select{
    		width: 160px;
    	}
    </style>
    <script type="text/javascript">
        //Libreria para el manejo de routing        
        var routing = (function(){
            var getPath = function(){
                return '<?php echo public_path(); ?>';
            }
            return {
                public_path:  function public_path(path){
                        if(path)
                            retorno = getPath()+path;
                        else
                            retorno = getPath();
                        return retorno; 
                },
                url_for: function url_for(module, action){
                    return getPath()+'frontend.php'+'/'+module+'/'+action;
                }
            }
        })();
    </script>
  </head>
<header> 
</header>
  <body>
    <div id="content" class="embedido" style="width: 800px; margin-left: auto; margin-right: auto;">
    <?php echo $sf_content ?>
    </div>
  </body>   
</html>