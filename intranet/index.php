<!DOCTYPE html>
<html lang="es">
  <head>
<!--    <script type="text/javascript" scr="http://code.jquery.com/jquery-1.11.1.min.js"></script>-->
    <script src="js/jquery.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Terrazul</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/jquery-ui.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
   
    
    
    <script type='text/javascript'> 
        var x=$(document);
        x.ready(function() {
           // Interceptamos el evento submit
            $('#form123').submit(function() {
          // Enviamos el formulario usando AJAX
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    // Mostramos un mensaje con la respuesta de PHP
                    success: function(data) {
                        $('#result').html(data);
                    }
                })        
                return false;
            }); 
        })  
    </script>
  
  </head>
  <body style="padding-top: 125px; ">
      
      <div class="container">
       <div class="row">
           <div class="col-xs-12 col-ms-12">
                <div class="navbar navbar-default navbar-fixed-top">
                    <div class="navbar-collapse  navbar-responsive-collapse">
                        <ul class="nav navbar-nav">
                            
                            <li class="active"><h4 style="color:white; padding-left: 30px; padding-top: 10px;">Terrazul - Intranet</h4>></li>
                        </ul>
                    </div>
                </div>
          </div>
        </div>
     </div> <!--  aca termina container-->

     <div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading"> <strong class="">Ingreso</strong>

                </div>
                <div class="panel-body">
                    <form class="form-horizontal"  method='POST' id="form123" action="login.php">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Usuario</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control"  placeholder="Usuario" required="" name='email'>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">Contraseña</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control"  placeholder="Contraseña" required="" name='con'>
                            </div>
                        </div>
                        <div class="form-group">
                        </div>
                        <div class="form-group last">
                            <div class="col-sm-offset-3 col-sm-9">
                                <input type="submit" class="btn btn-success btn-sm" id="enviar" value='Entrar'>
                                <button type="reset" class="btn btn-default btn-sm">Borrar</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="panel-footer"> 
                </div>
            </div>
        </div>
    </div>
         <div class='row'>
             <div class="col-md-4 col-md-offset-4" id='result'>
                 
             </div>
         </div>
</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    
    <!-- Include all compiled plugins (below), or include individual files as needed -->
   
  </body>
</html>