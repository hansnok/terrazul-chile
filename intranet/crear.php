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
<!--      
    <style type='text/css'>
/*        .baja{
            color: #18BC9C;
        }*/
        .media2{
            color: #F39C12;
        }
        .alta{
            color: #E74C3C;
        }
    </style>-->
    
  </head>
  <body style="padding-top: 100px; padding-bottom: 15px; ">
      
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
              <a class="navbar-brand" href="crear.php"><span class="glyphicon glyphicon-plus" ></span></a>
          </div>
          <div class="navbar-collapse collapse navbar-responsive-collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="Actividad.php">Inicio</a></li> <!-- Falta link a inicio.-->
<!--              <li><a href="index.php">Tareas urgentes</a></li>-->
              <li class="dropdown">
                <a href="" class="dropdown-toggle" data-toggle="dropdown">Tareas <b class="caret"></b></a>
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
     
     
     
     <div class="container">
         <div class="row">
             <div class="col-xs-12 col-ms-10">
                 <form class="form-horizontal">
                      <fieldset>
                          <div class="col-sx-12 col-ms-10"><center><legend>Nueva Tarea</legend></center></div>
                        <div class="form-group">
                          <label for="select" class="col-lg-2 control-label">¿Para quién?</label>
                          <div class="col-lg-10">
                            <select class="form-control" id="select" required="required">
 
                              <option value="">Hans</option>
                              <option value="">Pedro</option>
                              <option value="">Paulina</option>
                              <option value="">Mauricio</option>
                              <option value="">Fernanda</option>
                            </select>                            
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="textArea" class="col-lg-2 control-label">Nombre</label>
                          <div class="col-lg-10">
                              <input type="text" class="form-control" id="textArea"required="required"placeholder="Ingresa un nombre de tarea" >
<!--                            <div class="checkbox">
                              <label>
                                <input type="checkbox"> Checkbox
                              </label>
                            </div>-->
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="textArea" class="col-lg-2 control-label">Descripción</label>
                          <div class="col-lg-10">
                              <textarea class="form-control" rows="3" id="textArea" placeholder="Ingresa una descripción de la tarea"></textarea>
<!--                            <span class="help-block">A longer block of help text that breaks onto a new line and may extend beyond one line.</span>-->
                          </div>
                        </div>
<!--                        <div class="form-group">
                          <label class="col-lg-2 control-label">Radios</label>
                          <div class="col-lg-10">
                            <div class="radio">
                              <label>
                                <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
                                Option one is this
                              </label>
                            </div>
                            <div class="radio">
                              <label>
                                <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                                Option two can be something else
                              </label>
                            </div>
                          </div>
                        </div>-->

                        <div class="form-group">
                          <label class="col-lg-2 control-label">Prioridad</label>
                          <div class="col-lg-10">
                            <div class="radio col-lg-1">
                              <label>
                                <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
                                <p  style="color: #18BC9C;">Baja</p>
                              </label>
                            </div>
                            <div class="radio col-lg-1">
                              <label>
                                <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                                <p  style=" color: #F39C12;">Media</p>
                              </label>
                            </div>
                              <div class="radio col-lg-1">
                              <label>
                                <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                                <p style="color: #E74C3C;">Alta</p>
                              </label>
                            </div>
                          </div>
                        </div>


                        <div class="form-group">
                            <label for="textArea" class="col-lg-2 control-label">Inicio</label>
                          <div class="col-lg-3 col-ms-3">                              
                              <input type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required="required"> 
                              <input type="time" class="form-control" value="<?php echo date('H:i'); ?>" required="required">
                          </div>
                            <label for="textArea" class="col-lg-2 control-label">Fin</label>
                          <div class="col-lg-3 col-ms-3 ">                              
                              <input type="date" class="form-control" required="required">
                              <input type="time" class="form-control" required="required">
                          </div>
                        </div>
                         

                        
                        
                        <div class="form-group">
                          <div class="col-lg-10 col-lg-offset-2">
                            <button class="btn btn-default">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Crear</button>
                          </div>
                        </div>
                      </fieldset>
                    </form>
                 
             </div>
         </div>
     </div>

     
     

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>