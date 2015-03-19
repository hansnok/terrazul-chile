<?php

session_start();
include 'encrypter.php';
if( isset($_POST['tarea']) && isset($_SESSION['usuario']) ){
    
    $servidor="localhost";
    $usuario="terrazul_2"; // 
    $contraseña = Encrypter::decrypt("4q8xp98EE34oxahuZZ+GgWr6QwlgOW0UGJ3+69VUjW4=");

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
        echo'<META HTTP-EQUIV="Refresh" CONTENT="0; URL=actividad.php">';
    }else{
        echo'<META HTTP-EQUIV="Refresh" CONTENT="0; URL=index.php">';
    }
}


?>