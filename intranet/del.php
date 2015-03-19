<?php

session_start();

if( isset($_POST['tarea']) && isset($_SESSION['usuario']) ){
    
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
    $id_tarea=$_POST['tarea'];
    $query="UPDATE tarea SET estado='finalizado' WHERE id_tarea='$id_tarea' ";
    $prueba=mysql_query($query,$conexion);
    if($prueba){
        echo '<div class="col-xs-12 col-ms-8" >
            <div class="alert alert-dismissable alert-success">
                <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>Tarea finalizada exitosamente</strong>
        </div></div>';
    }else{
        echo '<div class="col-xs-12 col-ms-8" >
            <div class="alert alert-dismissable alert-danger">
                <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>Ocurrio un error imprevisto</strong>
        </div></div>';
    }
    
}else{
    if( isset($_SESSION['usuario']) ){
        echo'<META HTTP-EQUIV="Refresh" CONTENT="0; URL=http://localhost/GestorActividades/Actividad.php">';
    }else{
        echo'<META HTTP-EQUIV="Refresh" CONTENT="0; URL=http://localhost/GestorActividades/index.php">';
    }
}


?>