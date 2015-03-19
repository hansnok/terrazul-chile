<?php
session_start();
include 'encrypter.php';
if( isset($_POST['id']) && isset($_SESSION['usuario'])){
    $servidor="localhost";
    $usuario="root"; // 
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
    $actual=$_SESSION['usuario'];
    
    $id_tarea=$_POST['id']; // recupero información de la tarea
    
    $query="SELECT tarea.nombre,tarea.descripcion,tarea.prioridad,tarea.creacion_dia,tarea.creacion_mes,tarea.creacion_anio,tarea.inicio_hora,tarea.inicio_minuto, tarea.termino_dia, tarea.termino_mes,tarea.termino_anio,tarea.termino_hora,tarea.termino_minuto,tarea.estado,usuario.nombre_usuario,tarea.id_usuario
            FROM (usuario  inner join tarea) inner join usuario_tarea
            WHERE tarea.id_tarea=usuario_tarea.id_tarea
                and usuario.email=tarea.id_usuario
                and tarea.id_tarea='$id_tarea'";
    $consulta=mysql_query($query,$conexion);
    $datos=mysql_fetch_assoc($consulta);
    echo '<table class="table table-striped table-hover "> <tbody>';
        echo "<tr> <td><u><b>Nombre de la tarea</b></u></td> <td>".$datos['nombre']."</td> <tr>";
        echo "<tr> <td><u><b>Descripción</b></u></td> <td>".$datos['descripcion']."</td> <tr>";
        echo "<tr> <td><u><b>Creador/Asignador</b></u></td> <td>".$datos['nombre_usuario']."</td> <tr>";
       
        if($datos['estado']=='activo'){
             if($datos['prioridad']==1){
                echo "<tr class='success'> <td><u><b>Prioridad</b></u></td> <td>Baja</td> <tr>";
            }
            if($datos['prioridad']==2){
                echo "<tr class='warning'> <td><u><b>Prioridad</b></u></td> <td>Media</td> <tr>";
            }
            if($datos['prioridad']==3){
                echo "<tr class='danger'> <td><u><b>Prioridad</b></u></td> <td>Alta</td> <tr>";
            }
            if($datos['inicio_minuto']<10){
                echo "<tr> <td><u><b>Fecha inicio</b></u></td> <td>".$datos['inicio_hora'].":0".$datos['inicio_minuto']." - ".$datos['creacion_dia']."/".$datos['creacion_mes']."/".$datos['creacion_anio']."</td> <tr>";
            }else{
                echo "<tr> <td><u><b>Fecha inicio</b></u></td> <td>".$datos['inicio_hora'].":".$datos['inicio_minuto']." - ".$datos['creacion_dia']."/".$datos['creacion_mes']."/".$datos['creacion_anio']."</td> <tr>";
            }
        }else{
            echo "<tr class='danger'> <td><u><b>Prioridad</b></u></td> <td> ATRASADA - Baja</td> <tr>";
            if($datos['inicio_minuto']<10){
                echo "<tr> <td><u><b>Fecha inicio</b></u></td> <td>".$datos['inicio_hora'].":0".$datos['inicio_minuto']." - ".$datos['creacion_dia']."/".$datos['creacion_mes']."/".$datos['creacion_anio']."</td> <tr>";
            }else{
                echo "<tr> <td><u><b>Fecha inicio</b></u></td> <td>".$datos['inicio_hora'].":".$datos['inicio_minuto']." - ".$datos['creacion_dia']."/".$datos['creacion_mes']."/".$datos['creacion_anio']."</td> <tr>";
            }
            
        }
        if($datos['termino_minuto']<10){
            echo "<tr> <td><u><b>Fecha termino</b></u></td> <td>".$datos['termino_hora'].":0".$datos['termino_minuto']." - ".$datos['termino_dia']."/".$datos['termino_mes']."/".$datos['termino_anio']."</td> <tr>";
        }else{
            echo "<tr> <td><u><b>Fecha termino</b></u></td> <td>".$datos['termino_hora'].":".$datos['termino_minuto']." - ".$datos['termino_dia']."/".$datos['termino_mes']."/".$datos['termino_anio']."</td> <tr>";
        }
        
    echo '</tbody>
           </table>';
    
    // crear botones de Eliminar, cambiar realizador y termina
    // en variable de session el email esta encriptado
    if($datos['id_usuario']==$_SESSION['usuario']){
        echo '<div class=" col-xs-6 btn-group btn-group-justified">
                <div class="btn-group">
                    
                    <button type="button" class="btn btn-primary btn-m btn-block" id="botonTermino" value="'.$id_tarea.'" name="dia">Tarea Finalizada</button>
                   
                </div>
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-m btn-block"  id="botonCambio" value="cambio" name="semana">Cambiar realizador</button>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-m btn-block" id="botonEliminar" value="eliminar" name="dia">Eliminar tarea</button>
                </div>
              </div>';
    }else{
        //boton solo para confirmar el termino de tarea
        echo '<div class=" col-xs-6 btn-group btn-group-justified">
                <div class="btn-group">
                
                    <button type="button" class="btn btn-primary btn-m btn-block" id="botonTermino" value="'.$id_tarea.'" name="dia">Tarea Finalizada</button>
                </div>
              </div>';
    }
    mysql_close();
    
    echo "<script type='text/javascript'>
        var botonTermino=$('#botonTermino');
        botonTermino.click(terminar2);
        function terminar2(){
            var superultraboton=$('#botonTermino').attr('value');
            var supertabla=$('#tabla');
            $.ajax({
                    type: 'POST',
                    url: 'del.php',
                    data: {tarea : superultraboton},
                    // Mostramos un mensaje con la respuesta de PHP
                    success: function(data) {
                        supertabla.html(data);
                    }
                })
        }

          </script>";
    
}else {
     echo'<META HTTP-EQUIV="Refresh" CONTENT="0; URL=http://localhost/GestorActividades/index.php">';
}


?>