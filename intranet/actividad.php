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
        // javascript para los botones de tareas diarias y semanales
        var x = $(document);
        x.ready(inicio);
        
        function inicio(){
            var x = $('#botonDia');
            x.click(tareasDia);
            var y = $('#botonSemana');
            y.click(tareasSemana);
            tareasSemana();// por defecto carga tareas de al semana
            var h=$('#mas');
            h.click(function(e){
                e.preventDefault();
                var h=$('#mas');
                var y=$('#crear');
                var y2=$('#crear2');
//            alert('rescata evento');
            $.ajax({
                    type: 'POST',
                    url: h.attr('href'),
                    data: 'tarea=crear',
                    // Mostramos un mensaje con la respuesta de PHP
                    success: function(data) {
                        y.html(data),y2.html(' ');
                    }
                })
            });
            
        }
        
        function crear(){
            var y=$('#crear');
            alert('rescata evento');
            $.ajax({
                    type: 'POST',
                    url: 'nueva.php',
                    data: 'tarea=crear',
                    // Mostramos un mensaje con la respuesta de PHP
                    success: function(data) {
                        y.html(data);
                    }
                })
               
        }
        
        function tareasDia(){
            // ejecutra php que generara tabla con las tareas del dia
            var y=$('#tabla'); // div donde se cargara la tabla
            $.ajax({
                    type: 'POST',
                    url: 'tareas.php',
                    data: 'dia=dia',
                    // Mostramos un mensaje con la respuesta de PHP
                    success: function(data) {
                        y.html(data);
                    }
                })
        }
        function tareasSemana(){
            // ejecutra php que generara tabla con las tareas de la semana
            var y=$('#tabla'); // div donde se cargara la tabla
            $.ajax({
                    type: 'POST',
                    url: 'tareas.php',
                    data: 'semana=semana',
                    // Mostramos un mensaje con la respuesta de PHP
                    success: function(data) {
                        y.html(data);
                    }
                })
        }
//        function infoTarea(){
//            var z=$('#tarea');
//            var as= z.attr("value");
//            alert(as);
//        }
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
              <li class="active"><a href="Actividad.php">Inicio</a></li> <!-- Falta link a inicio.-->
<!--              <li><a href="index.php">Tareas urgentes</a></li>-->
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tareas <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="index.php">Activas</a></li>
                  <li><a href="index.php">Creadas</a></li>
                  <li><a href="index.php">Eliminadas</a></li>
                   <li class="divider"></li>
                  <li class="dropdown-header">Tareas no vistas</li>
                  <li><a href="index.php">Nuevas</a></li>
                  
                </ul>
              </li>
<!--               <li><a href="#">Activas</a></li>
               <li><a href="#">Creadas</a></li>-->
               <li><a href="#">Datos  </a></li>
               <li><a href="#">Desconexión  </a></li>
               <form class="navbar-form navbar-left">
                   <input type="search" class="form-control col-lg-8" placeholder="Buscar por nombre">
            </form>
            </ul>
<!--            <form class="navbar-form navbar-left">
              <input type="text" class="form-control col-lg-8" placeholder="Buscar por nombre">
            </form>-->
<!--            <ul class="nav navbar-nav navbar-right">
              <li><a href="#">Datos  </a></li>  Link a tabla de SII
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li class="divider"></li>
                  <li><a href="#">Separated link</a></li>
                </ul>
              </li>
            </ul>-->
          </div>
        </div>
       </div>
           </div>
     </div> <!--  aca termina container-->
<!--      <br>
      <br>
      <br>
      <br>
      <br>-->
    
      <div class="container crear" id='crear'>
          <div class="row" id="agregar">
              
              <div class="col-xs-12 col-ms-8"  id="informacion"></div>
              
              <?php // comprobar formulario 
                if( isset($_POST['hide']) && $_POST['hide']=='enviado'){
                    if( isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['descripcion']) && isset($_POST['optionsRadios']) &&
                         isset($_POST['fecha_inicio']) && isset($_POST['hora_inicio']) && isset($_POST['fecha_termino']) && isset($_POST['hora_termino'])){
                            
                        if($_POST['id']!='no' && ( ($_POST['fecha_inicio']<$_POST['fecha_termino']) or ($_POST['fecha_inicio']==$_POST['fecha_termino'] && $_POST['hora_inicio']<=$_POST['hora_termino']) ) ){// comprueba que selecciono una persona y la fecha
                            // datos correctos
                            
                            $servidor="localhost";
                            $usuario="root"; // usuario que solo puede ver la tabla usuarios, no modificar nada. Permisos en phpMyAdmin
                            $contraseña="";

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
                            $bbdd="actvidades";
                            $db=mysql_select_db($bbdd,$conexion);
                            
                            $fecha_inicio=  explode('-', $_POST['fecha_inicio']); // arreglo con la fecha
                            $dia1=$fecha_inicio[2];
                            $mes1=$fecha_inicio[1];
                            $anio1=$fecha_inicio[0];
                            $hora_inicio= explode(':',$_POST['hora_inicio']);
                            $hora1=$hora_inicio[0];
                            $minuto1=$hora_inicio[1];
                            
                            $fecha_termino=  explode('-', $_POST['fecha_termino']); // arreglo con la fecha
                            $dia2=$fecha_termino[2];
                            $mes2=$fecha_termino[1];
                            $anio2=$fecha_termino[0];
                            $hora_termino= explode(':',$_POST['hora_termino']);
                            $hora2=$hora_termino[0];
                            $minuto2=$hora_termino[1];
                            $id_user=$_POST['id'];
                            $descripcion=$_POST['descripcion'];
                            $nombre=$_POST['nombre'];
                            $prioridad=$_POST['optionsRadios'];
                            $user=$_POST['usuario_session'];
                            
                            $query_tarea="INSERT INTO tarea (nombre,descripcion,prioridad,creacion_dia,creacion_mes,creacion_anio,termino_dia,termino_mes,termino_anio,inicio_hora,inicio_minuto,termino_hora,termino_minuto,estado,id_usuario)
                                            VALUES ('$nombre','$descripcion','$prioridad','$dia1','$mes1','$anio1','$dia2','$mes2','$anio2','$hora1','$minuto1','$hora2','$minuto2','activo','$user' )";
                            $consulta=  mysql_query($query_tarea,$conexion);
                            if($consulta){
                                
                                $query_aux="SELECT id_tarea
                                            FROM tarea
                                            WHERE nombre='$nombre' 
                                            and descripcion='$descripcion'
                                            and prioridad='$prioridad'
                                            and inicio_hora='$hora1'
                                            and inicio_minuto='$minuto1'
                                            and id_usuario='$user'";
                                $consulta_aux=  mysql_query($query_aux,$conexion);
                                $id_tarea=  mysql_result($consulta_aux, 0);
                                $date=date('Y-m-d');
                                 $query_usuario_tarea="INSERT INTO usuario_tarea
                                                        VALUES ('$id_tarea','$id_user','$date')";
                                 $consulta_ut=  mysql_query($query_usuario_tarea,$conexion);
                                 if($consulta_ut){
                                     echo '<div class="col-xs-12 col-ms-8" >
                                            <div class="alert alert-dismissable alert-success">
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>Tarea creada exitosamente</strong>
                                        </div></div>';
                                 }else{
                                     echo '<div class="col-xs-12 col-ms-8" >
                                    <div class="alert alert-dismissable alert-warning">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>Ocurrio un error al crear la tarea</strong>
                                </div></div>';
                                 }
                            }else{
                                echo '<div class="col-xs-12 col-ms-8" >
                                    <div class="alert alert-dismissable alert-warning">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>Ocurrio un error al crear la tarea</strong>
                                </div></div>';
                            }
                           
                        }else{
                           echo '<div class="col-xs-12 col-ms-8" >
                                    <div class="alert alert-dismissable alert-warning">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>No se creo la tarea</strong>, revise que los datos ingresados no son validos
                                </div></div>'; 
                        }
                    }else{
                        echo '<div class="col-xs-12 col-ms-8" >
                                <div class="alert alert-dismissable alert-warning">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>No se creo la tarea</strong>, revise que los datos ingresados no son validos
                            </div></div>';
                    }
                }else{
                    if( isset($_POST['tarea_terminada']) ){
                        echo '<div class="col-xs-12 col-ms-8" >
                                <div class="alert alert-dismissable alert-info">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>Tarea correctamente terminada</strong>
                            </div></div>';
                        
                    }
                }
              ?>
              <div class=" col-xs-10 btn-group btn-group-justified">
<!--                  <a href="#" class="btn btn-default">Tareas del día</a>-->                 
<!--                  <a href="#" class="btn btn-info">Tareas de la semana</a>-->
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-m btn-block" id="botonDia" value="dia" name="dia">Tareas del día</button>
                </div>
                <div class="btn-group">
                  <button type="button" class="btn btn-info btn-m btn-block"  id="botonSemana" value="semana" name="semana">Tareas de la semana</button>
                </div>
              </div>
          </div>
      </div>
      <br>
      <br>
      <div class="container" id='crear2'>
          <div class="row">
              <div class="col-xs-12" id="tabla">
              </div>
          </div>
      </div>

  </body>
</html>