<?php

session_start();
include 'encrypter.php';
if($_POST['tarea']=='crear' && isset($_SESSION['usuario']) && $_SESSION['ida_crear']==1){
    $_SESSION['ida_crear']=0;    
    
    echo ' <div class="col-xs-12 col-ms-10">
                 <form class="form-horizontal" action="" method="POST" id="formulario">
                      <fieldset>
                          <div class="col-sx-12 col-ms-10"><center><legend>Nueva Tarea</legend></center></div>
                        <div class="form-group">
                          <label for="select" class="col-lg-2 control-label">¿Para quién?</label>
                          <div class="col-lg-10">
                            <select class="form-control" id="select" name="id" required="required">';
    
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

    $query=" SELECT nombre_usuario, email
            FROM usuario";
    $consulta=  mysql_query($query,$conexion);
    
    $superusuario=$_SESSION['usuario'];
    $fecha=date('Y-m-d');
    $hora=date('H:i');
    echo "<option valur='no'>Seleccione una persona</option>";
    while($nombres=  mysql_fetch_assoc($consulta)){
        echo "<option value='".$nombres['email']."' >".$nombres['nombre_usuario']."</option>";
    }
    
    echo '</select>                            
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="textArea" class="col-lg-2 control-label">Nombre</label>
                          <div class="col-lg-10">
                          <input type="hidden" value="enviado" name="hide">
                          <input type="hidden" name="usuario_session" value="'.$superusuario.'">
                              <input type="text" class="form-control" name="nombre" id="textArea" required="required" placeholder="Ingresa un nombre de tarea" >

                          </div>
                        </div>
                        <div class="form-group">
                          <label for="textArea" class="col-lg-2 control-label">Descripción</label>
                          <div class="col-lg-10">
                              <textarea class="form-control" rows="3" id="textArea" name="descripcion" placeholder="Ingresa una descripción de la tarea"></textarea>

                          </div>
                        </div>


                        <div class="form-group">
                          <label class="col-lg-2 control-label">Prioridad</label>
                          <div class="col-lg-10">
                            <div class="radio col-lg-1">
                              <label>
                                <input type="radio" name="optionsRadios" id="optionsRadios1" value="1" checked="">
                                <p  style="color: #18BC9C;">Baja</p>
                              </label>
                            </div>
                            <div class="radio col-lg-1">
                              <label>
                                <input type="radio" name="optionsRadios" id="optionsRadios2" value="2">
                                <p  style=" color: #F39C12;">Media</p>
                              </label>
                            </div>
                              <div class="radio col-lg-1">
                              <label>
                                <input type="radio" name="optionsRadios" id="optionsRadios2" value="3">
                                <p style="color: #E74C3C;">Alta</p>
                              </label>
                            </div>
                          </div>
                        </div>


                        <div class="form-group">
                            <label for="textArea" class="col-lg-2 control-label">Inicio</label>
                          <div class="col-lg-3 col-ms-3">                              
                              <input type="date" class="form-control" value="'.$fecha.'" required="required" name="fecha_inicio"> 
                              <input type="time" class="form-control" value="'.$hora.'" required="required" name="hora_inicio">
                          </div>
                            <label for="textArea" class="col-lg-2 control-label">Fin</label>
                          <div class="col-lg-3 col-ms-3 ">                              
                              <input type="date" class="form-control" required="required" name="fecha_termino">
                              <input type="time" class="form-control" required="required" name="hora_termino">
                          </div>
                        </div>
                         

                        
                        
                        <div class="form-group">
                          <div class="col-lg-10 col-lg-offset-2">
                          
                            <button type="reset" class="btn btn-default">Borrar</button>
                            <button type="submit" class="btn btn-primary">Crear</button>
                          </div>
                        </div>
                      </fieldset>
                    </form>
                 
             </div>
         </div>
     ';
    
//    echo "<script type=''>
//        $('#formulario').submit(function() {
//               
//          // Enviamos el formulario usando AJAX
//                $.ajax({
//                    type: 'POST',
//                    url: $(this).attr('action'),
//                    data: $(this).serialize(),
//                    // Mostramos un mensaje con la respuesta de PHP
//                    success: function(data) {
//                        $('#crear').html(data);
//                    }
//                })        
//                return false;
//            });
//
//
//
//           </script>";
    
}else{
    if($_SESSION['ida_crear']==0){
        echo'<META HTTP-EQUIV="Refresh" CONTENT="0; URL=http://localhost/GestorActividades/Actividad.php">';
    }else{
        echo'<META HTTP-EQUIV="Refresh" CONTENT="0; URL=http://localhost/GestorActividades/index.php">';
    }
}





?>