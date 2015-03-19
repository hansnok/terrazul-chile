<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <form action="" method="post">
            Ingrese texto a encriptar
            <input type="text" name="text">
            <input  type="time" name="t" value="<?php echo date('H:i'); ?>">
            <input type="date"  value="<?php echo date('Y-m-d'); ?>" name='f' > 
            <input type="submit" value="mostrar">
           
        </form>
        
        <?php
        include 'encrypter.php';
        if(isset($_POST['text'])){
            $x=$_POST['text'];
            $xEncriptado=Encrypter::encrypt($x); // encripta
            echo "la Fecha es".$_POST['t'];
            echo "<br><br> Este es el texto encriptado ".$xEncriptado;
            
            $xDesencriptado=Encrypter::decrypt($xEncriptado); // desencripta
            
            echo "<br><br> Este es el texto desencriptado ".$xDesencriptado;
            
            $dia_actual=date("d"); //date("d-m-Y");
            $mes_actual=date("m");;
            $anio_actual=date("Y");
            
            $fecha=explode('-',$_POST['f']);
            print_r($fecha);
            echo "<br>";
            $hora=  explode(':', $_POST['t']);
            print_r($hora);
            echo "<br>la fecha es".$dia_actual."-".$mes_actual."-".$anio_actual;
            
            $fecha1="23-05-2014";
            $fecha2="01-06-2014";
            if($fecha1<$fecha2){
                echo "<br>la fecha ".$fecha1." es menor que la fecha ".$fecha2;
            }else { echo "<br>comparo mal";}
        }
        ?>
    </body>
</html>
