<?php
session_start();
include 'encrypter.php';

if(isset($_SESSION['usuario'])){
   echo'<META HTTP-EQUIV="Refresh" CONTENT="0; URL=actividad.php">';
}else{  
    if( !preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+
                        ([a-zA-Z0-9\._-]+)+$/", $user) && isset($_POST['email']) && isset($_POST['con'])){ // comprueba que lo ingresado sea un correo electronico
        
        
        $user=$_POST['email'];
        $pass=$_POST['con'];
    
        $servidor = "localhost";
        $usuario = "terrazul_login"; // usuario que solo puede ver la tabla usuarios, no modificar nada. Permisos en phpMyAdmin
        $contraseña = Encrypter::decrypt("ZM+we6pLWlz0XAmphkeFmK98+6Sx1bkq7vsra1JMWgk=");

        $conexion=  mysql_connect($servidor,$usuario,$contraseña);
        $j=1;
        while($j>0){ // si no se conecta, siga intentandolo
            if(!($conexion= mysql_connect($servidor,$usuario,$contraseña))){
                $conexion= mysql_connect($servidor,$usuario,$contraseña);
            }else{
                $j=-1;
            }
        }
        
        $bbdd="terrazul_intranet";
        $db=mysql_select_db($bbdd,$conexion);
        
        $xEncriptado=Encrypter::encrypt($user); // encripto usuario
        $yEncriptado=Encrypter::encrypt($pass); // encripto contraseña

        $query="SELECT password 
                 FROM usuario WHERE email='$xEncriptado'";

        $consulta= mysql_query($query,$conexion); // realizo consulta, y pido usuario y contraseña encryptados.

        if(mysql_num_rows($consulta)!=0){ // si hay filas
            $dato=  mysql_result($consulta, 0);
                if($dato== $yEncriptado){
                    $_SESSION['usuario']=$xEncriptado; // asigna a variable de session el usuario
                    mysql_close();
                    echo'<META HTTP-EQUIV="Refresh" CONTENT = "0; URL=actividad.php">';
                }else {
                    echo'<META HTTP-EQUIV="Refresh" CONTENT = "0; URL=index.php">';
                    mysql_close();
                }

        }
    }else{ // reenvia al formulario de ingreso, si no se encuentra el usuario y su contraseña correctamente
        echo'<META HTTP-EQUIV="Refresh" CONTENT="0; URL = index.php">';
    }
}    
?>