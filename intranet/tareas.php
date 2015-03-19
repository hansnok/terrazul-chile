<?php
session_start();
include 'encrypter.php';
if($_POST['dia']=='dia' && isset($_SESSION['usuario'])){
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
    $dia_actual=date("d"); //date("d-m-Y");
    $mes_actual=date("m");;
    $anio_actual=date("Y");
    
    $_SESSION['ida_crear']=1;
    
    $query="SELECT tarea.nombre, tarea.termino_hora, tarea.termino_minuto, tarea.id_usuario, tarea.prioridad, tarea.id_tarea, usuario.nombre_usuario
            FROM (usuario  inner join tarea) inner join usuario_tarea
            WHERE usuario_tarea.id_tarea = tarea.id_tarea 
            and tarea.id_usuario=usuario.email
            and usuario_tarea.id_usuario = '$actual'
            and tarea.termino_dia='$dia_actual'
            and tarea.termino_mes='$mes_actual'
            and tarea.termino_anio='$anio_actual'
            and tarea.estado='activo' ";
    // Pido todas las tareas que terminan HOY y que estan activas
    $query2="SELECT tarea.nombre, tarea.termino_hora, tarea.termino_minuto, tarea.id_usuario, tarea.prioridad, tarea.id_tarea, tarea.termino_anio, tarea.termino_mes, tarea.termino_dia, usuario.nombre_usuario, tarea.estado
                FROM (usuario  inner join tarea) inner join usuario_tarea
                WHERE usuario_tarea.id_tarea = tarea.id_tarea
                and tarea.id_usuario=usuario.email
                and usuario_tarea.id_usuario = '$actual'
                and ( (tarea.termino_anio='$anio_actual' and tarea.termino_mes<'$mes_actual') or (tarea.termino_anio='$anio_actual' and tarea.termino_mes='$mes_actual' and tarea.termino_dia<='$dia_actual') or (tarea.termino_anio<'$anio_actual') )
                and (tarea.estado='atrasado' or tarea.estado='activo') ";
    // Pido todas las tareas que ya terminaron y que tengan el estado 'atrasada'
    $consulta =  mysql_query($query,$conexion);
    $consulta2 = mysql_query($query2,$conexion);
    $cantidad =  mysql_num_rows($consulta);
    $cantidad2 = mysql_num_rows($consulta2);

    if( (!$consulta && !$consulta2) || ($cantidad==0 && $cantidad2==0) ){
        // no hay tareas del dia
        echo '<div class="col-xs-12 col-ms-8" >
            <div class="alert alert-dismissable alert-success">
              <button type="button" class="close" data-dismiss="alert">×</button>
              <strong>Ninguna tarea vence hoy y no posees tareas atrasadas </strong> 
            </div></div>';
    }else{ // si hay tareas del dia
        echo '<table class="table table-striped table-hover "> 
                  <thead>
                    <tr>
                      <th>Nombre</th>
                      <th>Hora termino</th>
                      <th>Creador</th>
                    </tr>
                  </thead>
                  <tbody>';
        if($consulta && $cantidad!=0){ // Existen tareas que finalizan hoy y tienen estado ACTIVO
            $hora_actual=date("H")-4; // mala la hora de localhost
            $minuto_acutla=date("i");
            while($datos= mysql_fetch_assoc($consulta)) {
                $id_tarea=$datos['id_tarea'];
                if($datos['termino_hora']>$hora_actual || ($datos['termino_hora']==$hora_actual && $datos['termino_minuto']>$minuto_acutla)){// comprueba que no este atrasado
                    if($datos['prioridad']==1){
                        echo " <tr class='success click'  value='$id_tarea'>";
                        //$userDes= Encrypter::decrypt($datos['id_usuario']);
                        echo '<td>'.$datos['nombre']."</td><td>".$datos['termino_hora'].":".$datos['termino_minuto']."</td><td>".$datos['nombre_usuario']."</td></tr>";
                    }
                    if($datos['prioridad']==2){
                        echo "<tr class='warning click'  value='$id_tarea'>";
                        //$userDes= Encrypter::decrypt($datos['id_usuario']);
                        echo '<td>'.$datos['nombre']."</td><td>".$datos['termino_hora'].":".$datos['termino_minuto']."</td><td>".$datos['nombre_usuario']."</td></tr>";
                    }
                    if($datos['prioridad']==3){
                        echo "<tr class='danger click'  value='$id_tarea' >";
                        //$userDes= Encrypter::decrypt($datos['id_usuario']);
                        echo '<td>'.$datos['nombre']."</td><td>".$datos['termino_hora'].":".$datos['termino_minuto']."</td><td>".$datos['nombre_usuario']."</td></tr>";
                    }

                }else { // la tarea esta atrasada CAmbiar estado de la tarea a  ATRASADA
                    if($datos['prioridad']==1){
                        echo " <tr class='danger click'  value='$id_tarea'>";
                        //$userDes= Encrypter::decrypt($datos['id_usuario']);
                        echo '<td>'.$datos['nombre']."</td><td>"."ATRASADO - ".$datos['termino_hora'].":".$datos['termino_minuto']."</td><td>".$datos['nombre_usuario']."</td></tr>";
                    }
                    if($datos['prioridad']==2){
                        echo "<tr class='danger click' value='$id_tarea'>";
                        //$userDes= Encrypter::decrypt($datos['id_usuario']);
                        echo '<td>'.$datos['nombre']."</td><td>"."ATRASADO - ".$datos['termino_hora'].":".$datos['termino_minuto']."</td><td>".$datos['nombre_usuario']."</td></tr>";
                    }
                    if($datos['prioridad']==3){
                        echo "<tr class='danger click'  value='$id_tarea' >";
                        //$userDes= Encrypter::decrypt($datos['id_usuario']);
                        echo '<td>'.$datos['nombre']."</td><td>"."ATRASADO - ".$datos['termino_hora'].":".$datos['termino_minuto']."</td><td>".$datos['nombre_usuario']."</td></tr>";
                    }
                    // cambiar el estado de la tarea a atrasada
                    $query3="UPDATE tarea SET estado='atrasado' WHERE id_tarea='$id_tarea' ";
                    mysql_query($query3,$conexion);
                }          

            }
        }
        if($consulta2 && $cantidad2!=0){ // Existen tareas que ya finalizaron y tienen estado ATRASADO
            while($datos2= mysql_fetch_assoc($consulta2)){ // pide las tareas atrasadas
                $id_tarea=$datos2['id_tarea'];
                echo "<tr class='danger click' value='$id_tarea' >";
                //$userDes= Encrypter::decrypt($datos2['id_usuario']);
                echo '<td>'.$datos2['nombre']."</td><td>"."ATRASADO - ".$datos2['termino_hora'].":".$datos2['termino_minuto']." - ".$datos2['termino_dia']."/".$datos2['termino_mes']."/".$datos2['termino_anio']."</td><td>".$datos2['nombre_usuario']."</td></tr>";   
                if($datos2['estado']=='activo'){ // si ya vencio y tiene estado activo, cambiarlo
                   $query4="UPDATE tarea SET estado='atrasado' WHERE id_tarea='$id_tarea' ";
                    mysql_query($query4,$conexion); 
                }
            }
        }
        
        echo '</tbody>
             </table>';
        mysql_close();
    }
    // javascript para seleccionar la tabla
    echo "<script type='text/javascript'>";
            echo " 

                var z=$('tr');
                    z.click(infoTarea);
                    function infoTarea(){
//                        var z=$('tr');
//                        var as = z.attr('id');
                        var y=$('#tabla');
//                        alert(z.attr('id'));
//                        e.preventDefault();
                        var id = $(this).attr('value');
//                        alert(id);

                        $.ajax({
                        type: 'POST',
                        url: 'infoTarea.php',
                        data: {id : id},
                        // Mostramos un mensaje con la respuesta de PHP
                        success: function(data) {
                            y.html(data);
                        }
                        })
                    }";
            echo "</script>"; 
}else{
    if($_POST['semana']=='semana' && isset($_SESSION['usuario'])){
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
        $dia_actual=date("d"); //date("d-m-Y");
        $dia_actual2=$dia_actual+7;
        $mes_actual=date("m");;
        $anio_actual=date("Y");
        
        $_SESSION['ida_crear']=1;
        //pido las tareas activas que vencen hoy o en 7 dias mas, con el estado ACTIVA
        $query="SELECT tarea.nombre, tarea.termino_hora, tarea.termino_minuto, tarea.id_usuario, tarea.prioridad, tarea.id_tarea, usuario.nombre_usuario, tarea.termino_anio, tarea.termino_mes, tarea.termino_dia
                FROM (usuario  inner join tarea) inner join usuario_tarea
                WHERE usuario_tarea.id_tarea = tarea.id_tarea 
                and tarea.id_usuario=usuario.email
                and usuario_tarea.id_usuario = '$actual'
                and tarea.termino_dia>='$dia_actual'
                    and tarea.termino_dia<='$dia_actual2'
                and tarea.termino_mes='$mes_actual'
                and tarea.termino_anio='$anio_actual'
                and tarea.estado='activo' ";
        
        // pido las tareas atraasadas
        $query2="SELECT tarea.nombre, tarea.termino_hora, tarea.termino_minuto, tarea.id_usuario, tarea.prioridad, tarea.id_tarea, tarea.termino_anio, tarea.termino_mes, tarea.termino_dia, usuario.nombre_usuario, tarea.estado
                FROM (usuario  inner join tarea) inner join usuario_tarea
                WHERE usuario_tarea.id_tarea = tarea.id_tarea
                and tarea.id_usuario=usuario.email
                and usuario_tarea.id_usuario = '$actual'
                and ( (tarea.termino_anio='$anio_actual' and tarea.termino_mes<'$mes_actual') or (tarea.termino_anio='$anio_actual' and tarea.termino_mes='$mes_actual' and tarea.termino_dia<='$dia_actual') or (tarea.termino_anio<'$anio_actual') )
                and (tarea.estado='atrasado' or tarea.estado='activo') ";
        $consulta =  mysql_query($query,$conexion);
        $consulta2 = mysql_query($query2,$conexion);
        $cantidad =  mysql_num_rows($consulta);
        $cantidad2 = mysql_num_rows($consulta2);
        
        
        if( (!$consulta && !$consulta2) || ($cantidad==0 && $cantidad2==0) ){
            // no hay tareas del dia
            echo '<div class="col-xs-12 col-ms-8" >
                <div class="alert alert-dismissable alert-success">
                  <button type="button" class="close" data-dismiss="alert">×</button>
                  <strong>No posee tareas activas durante esta semana, tampoco posees tareas atrasadas </strong> 
                </div></div>';
        }else{ // si hay tareas del dia
            echo '<table class="table table-striped table-hover "> 
                      <thead>
                        <tr>
                          <th>Nombre</th>
                          <th>Hora termino</th>
                          <th>Creador</th>
                        </tr>
                      </thead>
                      <tbody>';
            if($consulta && $cantidad!=0){ // Existen tareas que finalizan hoy y tienen estado ACTIVO
                $hora_actual=date("H")-4; // mala la hora de localhost
                $minuto_acutla=date("i");
                while($datos= mysql_fetch_assoc($consulta)) {
                    $id_tarea=$datos['id_tarea'];
                    if( $datos['termino_dia']==$dia_actual && ($datos['termino_hora']<$hora_actual || ($datos['termino_hora']==$hora_actual && $datos['termino_minuto']<$minuto_acutla))){// comprueba que no esta atrasado
                        echo "<tr class='danger click'  value='$id_tarea' >";
                        echo '<td>'.$datos['nombre']."</td><td>"."ATRASADO - ".$datos['termino_hora'].":".$datos['termino_minuto']." - ".$datos['termino_dia']."/".$datos['termino_mes']."/".$datos['termino_anio']."</td><td>".$datos['nombre_usuario']."</td></tr>";  
                        // cambiar el estado de la tarea a atrasada
                        $query2="UPDATE tarea SET estado='atrasado' WHERE id_tarea='$id_tarea' ";
                        mysql_query($query2,$conexion);
                    }else { // la tarea esta atrasada CAmbiar estado de la tarea a  ATRASADA
                        if($datos['prioridad']==1){
                            echo " <tr class='success click'  value='$id_tarea'>";
                            echo '<td>'.$datos['nombre']."</td><td>".$datos['termino_hora'].":".$datos['termino_minuto']." - ".$datos['termino_dia']."/".$datos['termino_mes']."/".$datos['termino_anio']."</td><td>".$datos['nombre_usuario']."</td></tr>"; 
                        }
                        if($datos['prioridad']==2){
                            echo "<tr class='warning click' value='$id_tarea'>";
                            echo '<td>'.$datos['nombre']."</td><td>".$datos['termino_hora'].":".$datos['termino_minuto']." - ".$datos['termino_dia']."/".$datos['termino_mes']."/".$datos['termino_anio']."</td><td>".$datos['nombre_usuario']."</td></tr>"; 
                        }
                        if($datos['prioridad']==3){
                            echo "<tr class='danger click' value='$id_tarea' >";
                            echo '<td>'.$datos['nombre']."</td><td>".$datos['termino_hora'].":".$datos['termino_minuto']." - ".$datos['termino_dia']."/".$datos['termino_mes']."/".$datos['termino_anio']."</td><td>".$datos['nombre_usuario']."</td></tr>"; 
                        }
                    }          

                }
            }
            if($consulta2 && $cantidad2!=0){ // Existen tareas que ya finalizaron y tienen estado ATRASADO
                while($datos2= mysql_fetch_assoc($consulta2)){ // pide las tareas atrasadas
                    $id_tarea=$datos2['id_tarea'];
                    echo "<tr class='danger click' value='$id_tarea' >";
                    //$userDes= Encrypter::decrypt($datos2['id_usuario']);
                    echo '<td>'.$datos2['nombre']."</td><td>"."ATRASADO - ".$datos2['termino_hora'].":".$datos2['termino_minuto']." - ".$datos2['termino_dia']."/".$datos2['termino_mes']."/".$datos2['termino_anio']."</td><td>".$datos2['nombre_usuario']."</td></tr>";
                    if($datos2['estado']=='activo'){ // si ya vencio y tiene estado activo, cambiarlo
                        $query4="UPDATE tarea SET estado='atrasado' WHERE id_tarea='$id_tarea' ";
                        mysql_query($query4,$conexion); 
                    }
                }
            }

            echo '</tbody>
                 </table>';
            mysql_close();
            
            echo "<script type='text/javascript'>";
            echo " 

                var z=$('tr');
                    z.click(infoTarea);
                    function infoTarea(){
//                        var z=$('tr');
//                        var as = z.attr('id');
                        var y=$('#tabla');
//                        alert(z.attr('id'));
//                        e.preventDefault();
                        var id = $(this).attr('value');
//                        alert(id);

                        $.ajax({
                        type: 'POST',
                        url: 'infoTarea.php',
                        data: {id : id},
                        // Mostramos un mensaje con la respuesta de PHP
                        success: function(data) {
                            y.html(data);
                        }
                        })
                    }";
            echo "</script>"; 

        }
        
      
       
    }else{
        echo'<META HTTP-EQUIV="Refresh" CONTENT="0; URL=http://localhost/GestorActividades/index.php">';
    }
}
?>


