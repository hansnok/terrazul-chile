<!DOCTYPE html>

<html lang="es">
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
        // javascript para los botones de tareas diarias y semanales
        var x = $(document);
        x.ready(inicio);
        
        function inicio(){
            var criterios = $('.filtros');
            criterios.click(function(e){
                e.preventDefault();
                var tabla = $('#actividades');
                var tabla2 = $('#actividades2');
            	var dato = $(this).attr('value');
            	$.ajax({
                    type: 'POST',
                    url: 'tabla.php',
                    data: {valor : dato},
                    success: function(data) {
                        tabla.html(data),tabla2.html(' ');
                    }
                })
            });

            
                    
        }
        
    </script>

  </head>

  <body style="padding-top: 100px; padding-bottom: 15px; " >
      <div class="container">
       <div class="row">
           <div class="col-xs-12 col-ms-12">
        <div class="navbar navbar-default navbar-fixed-top">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
              <a class="navbar-brand" href="nueva.php" id='mas' ><span class="glyphicon glyphicon-plus" ></span></a>
          </div>
          <div class="navbar-collapse collapse navbar-responsive-collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="actividad.php">Inicio</a></li> 
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tareas <b class="caret"></b></a>
               <ul class="dropdown-menu">
 <!--                  <li><a href="#">Activas</a></li>
                  <li><a href="#">Creadas</a></li>
                  <li><a href="#">Eliminadas</a></li>
                   <li class="divider"></li>
                  <li class="dropdown-header">Tareas no vistas</li>
                  <li><a href="#">Nuevas</a></li>
 -->                     
            </ul>
              </li>
               <li><a href="datos.php?token=RdDrSLVm1fODZfLjilJj0brrqdB7NKEPmIr/tUeJHO8=">Datos  </a></li>
               <li><a href="cerrar.php">Desconexión  </a></li>
               <form class="navbar-form navbar-left">
                   <input type="search" class="form-control col-lg-8" placeholder="Buscar por nombre">
            </form>
            </ul>

          </div>
        </div>
       </div>
           </div>
     </div> 
    
      <div class="container crear" id='crear'>
          <div class="row" id="agregar">
              
              <div class="col-xs-12 col-ms-12"  id="datos">
              
              <div class="col-xs-4 col-ms-4"  id="empresas">
              	<div class="list-group">
              <?php // comprobar formulario
				include 'encrypter.php';
				if( isset($_GET['token']) ){
					
					$servidor = "localhost";
					$usuario = "terrazul_tareas"; // usuario que solo puede ver la tabla usuarios, no modificar nada. Permisos en phpMyAdmin
					$contraseña = Encrypter::decrypt("pgonJ5SQ42gtVKBpEUaw4gs/Pa7V6f4ZaU8ZjRCtKO8=");
					
					$conexion=  mysql_connect($servidor,$usuario,$contraseña);
					$j=1;
					while($j>0){ // si no se conecta, siga intentandolo
						if(!($conexion= mysql_connect($servidor,$usuario,$contraseña))){
							$conexion= mysql_connect($servidor,$usuario,$contraseña);
						}else{
							$j=-1;
						}
					}
					// la conexión es exitosa
					$bbdd="terrazul_intranet";
					$db=mysql_select_db($bbdd,$conexion);
					
					$query= "SELECT id_criterio, nombre, codigo
      						FROM criterio";
					$consulta=  mysql_query($query,$conexion);
					if($consulta){
						while ( $datos= mysql_fetch_assoc($consulta) ){
							echo '<a href="" class="list-group-item filtros" value='.$datos['id_criterio'].'>';
							echo $datos['codigo'].' - '.$datos['nombre'].'</a>';
						}					
					}
	
				}else{
					echo'<META HTTP-EQUIV="Refresh" CONTENT = "0; URL=index.php">';
				}
			  ?>
			  </div>
			  </div>
			  <div class="col-xs-8 col-ms-8"  id="actividades">
			  
			  </div>
			  <div class="col-xs-8 col-ms-8"  id="actividades2">
			  
			  </div>
			  
              </div>
          </div>
      </div>

  </body>
</html>