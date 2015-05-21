<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <![endif]-->
    <title>Contacto - Terrazul</title>
    <meta name="description" content="Empresa de asesorias tributarias y contables, amplio conocimiento del rubro nacional e internacional"  lang="ES"/>
    <meta name="keywords" content="asesoria,impuestos,tributaria,contabilidad,reforma tributaria,beneficios tributarios,Payroll,ayuda pyme,pyme,emprendimiento" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="images/icono.ico" >
    <link rel="stylesheet" href="css2/filoxenia.css">
    <link rel="stylesheet" href="css2/magnific-popup.css">

    <link rel="stylesheet" href="css2/custom.css">

    <script src="js/vendor/custom.modernizr.js"></script>
    
    <style type="text/css">
        .imagen{
            width: 75px;
            height: 75px; 
            font-size: x-large; 
            font: bold;
        }
        .texto{
            text:black;
        }
        
    </style>

</head>

<body>
    <header class="contain-to-grid fixed">
        <div class="row">
            <div class="large-12 column">
                <nav id="menu" class="top-bar ">

                    <ul class="title-area">
                        <li class="name">
                            <p style="color:white">                               
                                    <a href="bienvenido.php" >
                                        <img src="images/logo.png" alt="logo" class="imagen" align="center">
                                    </a>
                            Terrazul </p>
                        </li>
                        <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a>
                        </li>
                    </ul>

                    <section class="top-bar-section">
                        <ul class="right">
                            <li><a href="bienvenido.php">Bienvenido</a>
                            </li>
                            <li><a href="servicios.php">Servicios</a>
                            </li>
                            <li><a href="tarifas.php">Tarifas</a>
                            </li>
                            <li><a href="intranet/index.php">Intranet</a>
                            </li>   
<!--                            <li id="signup"><a href="signup.html" class="button no-margin">SIGN UP</a>
                            </li>-->
                        </ul>
                    </section>
                </nav>
            </div>
        </div>
    </header>

    <section id="main" role="main">

        <div class="breadcrumb-container">
            <div class="row">
                <div class="large-12 column">
                    <nav class="breadcrumbs animated bounceInDown">
                        <a href="index.html">Home</a>
                        <a class="current" href="#">Contact Us</a>
                    </nav>
                </div>
            </div>
        </div>

        <section class="part">
            <div class="row title">
                <div class="large-12 column">
                    <h6>UBICANOS</h6>
                </div>
            </div>

            <div class="row">
                <div class="large-7 column">
                    <p>
                        Para contactarnos, por favor llena el siguiente formulario
                        
    <?php
    
    include 'PHPMailerAutoload.php';
    include 'class.phpmailer.php';
    include 'class.smtp.php';
    include 'intranet/encrypter.php';
    
    
    if(isset($_POST['nombre']) && isset($_POST['email']) &&isset($_POST['tema']) && isset($_POST['texto']) && isset($_POST['fono'])){      
        $correo=$_POST['email'];
        if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+
                        ([a-zA-Z0-9\._-]+)+$/", $correo)){
            $mail = new PHPmailer;
            
            $servidor="localhost";
            $usuario="terrazul_login"; // usuario que solo puede ver la tabla usuarios, no modificar nada. Permisos en phpMyAdmin
            $contraseña=  Encrypter::decrypt("ZM+we6pLWlz0XAmphkeFmK98+6Sx1bkq7vsra1JMWgk=");

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
            $id=Encrypter::encrypt('cjeria@terrazul-chile.cl');
            $query="SELECT webmail FROM administrador WHERE id_usuario='$id'";
            $consulta=  mysql_query($query,$conexion);
            $datos=mysql_fetch_assoc($consulta);
            mysql_close();          
            $pass=$datos['webmail'];
            $pass2=Encrypter::decrypt($pass);

            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'mail.terrazul-chile.cl';  // Specify main and backup SMTP servers
            $mail->Port = '25';
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'terrazul';                 // SMTP username
            $mail->Password = $pass2;                           // SMTP password
//            $mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
            
            $nombre=$_POST['nombre'];
            $telefono=$_POST['fono'];
            
            $mail->From = $correo;
            $mail->FromName = "Formulario desde pagina web";//$nombre;
            $mail->addAddress('info@terrazul-chile.cl');               // Name is optional
            $mail->WordWrap = 1000; 
            $mail->isHTML(true); 
            
            $mail->Subject = "### ".$_POST['tema'];
            $mail->Body    = "Correo enviado por: ".$nombre." <br> Telefono de contacto: ".$telefono."<br> Email de contacto: ".$correo."<br>El mensaje enviado es: ".$_POST['texto'];

            if(!$mail->send()) {
                echo '<br><h4 style="color: #5882FA;"> Mensaje no enviado, por favor revise si lleno correctamente todos los campos.</h4>';
//                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                echo "<br><h4 style='color: #5882FA;'>Mensaje enviado exitosamente, nos contactaremos con usted a la brevedad</h4>";
            }

            
        }else{
            echo "<br><h4 style='color:red;'> Mensaje no enviado, por favor revise si lleno correctamente todos los campos.</h4>";
        }
    }   
    ?>
                    </p>
                    <form action="" method="post">
                        <div class="row">
                            <div class="large-8 column">
                                <label>Nombre:</label>
                                <input type="text" name="nombre" placeholder="Escriba su nombre completo">
                            </div>
                        </div>

                        <div class="row">
                            <div class="large-8 column">
                                <label>Email:</label>
                                <input type="email" name="email" placeholder="Escriba su email">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="large-8 column">
                                <label>Tel&#233;fono:</label>
                                <input type="text" name="fono" placeholder="Escriba su tel&#233;fono de contacto">
                            </div>
                        </div>

                        <div class="row">
                            <div class="large-12 column">
                                <label>Tema:</label>
                                <input type="text" name="tema" placeholder="">
                            </div>
                        </div>

                        <div class="row">
                            <div class="large-12 column">
                                <label>Mensaje:</label>
<!--                                <input type="textarea" name="texto" placeholder="Escriba el mensaje que desea enviar.">-->
                                <textarea name="texto" placeholder="Escriba el mensaje que desea enviar."></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="large-12 column">
                                <button>Enviar Mensaje</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="large-12 column">
                                <small><em>Todos los campos son requeridos.</em></small>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="large-4 column ">
                    <div id="map-canvas">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3330.5989580526425!2d-70.56971589999999!3d-33.407625599999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9662cedee6357ec7%3A0x5f5b7a4b7ec392d5!2sAlonso+de+C%C3%B3rdova+5870%2C+Las+Condes%2C+Regi%C3%B3n+Metropolitana+de+Santiago!5e0!3m2!1ses-419!2scl!4v1432235668983" width="300" height="250" frameborder="0" style="border:0"></iframe>
                    
                </div>
                    

                    <div class="row">
                        <div class="small-3 column">
                            <h6>Direcci&#243n:</h6>
                        </div>
                        <div class="small-9 column">
                            <p>Casa matriz: Alonso de Cordova Nº 5870, oficina 724, Las condes</p>
                        	<p>Sucursal: Lord Cochrane Nº 30, oficina 901, Santiago Centro </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-3 column text">
                            <h6>Telef&#243no:</h6>
                        </div>
                        <div class="small-9 column text">
                            <p>+56 2 2725 8472</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="small-3 column text">
                            <h6>Email:</h6>
                        </div>
                        <div class="small-9 column text">
                            <p>
                                <a href="mailto:contacto@terrazul-chile.cl"><img src="correo3.jpg"></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </section>

    <a id="back-top" href="#"><i class="icon-caret-up"></i></a>

    <footer>
        <div class="row spacy">
            <div class="large-6 column">
                <h4>Sobre Nosotros</h4>
                <br>
                <div id="map-casa">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3330.5989580526425!2d-70.56971589999999!3d-33.407625599999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9662cedee6357ec7%3A0x5f5b7a4b7ec392d5!2sAlonso+de+C%C3%B3rdova+5870%2C+Las+Condes%2C+Regi%C3%B3n+Metropolitana+de+Santiago!5e0!3m2!1ses-419!2scl!4v1432235668983" width="450" height="225" frameborder="0" style="border:0"></iframe>
                
                </div>
            </div>


            <div class="large-6 column">
                <h4>Contacto</h4>

                <div class="row">
                    <div class="small-3 column">
                        <h6>Direcci&#243n:</h6>
                    </div>
                    <div class="small-9 column">
                        <p>Casa matriz: Alonso de Cordova Nº 5870, oficina 724, Las condes</p>
                        <p>Sucursal: Lord Cochrane Nº 30, oficina 901, Santiago Centro </p>
                    </div>
                </div>

                <div class="row">
                    <div class="small-3 column text">
                        <h6>Telef&#243no:</h6>
                    </div>
                    <div class="small-9 column text">
                        <p>+56 2 2725 8472</p>
                    </div>
                </div>

                <div class="row">
                    <div class="small-3 column text">
                        <h6>Email:</h6>
                    </div>
                    <div class="small-9 column text">
                        <p>
                            <a href="mailto:contacto@terrazul-chile.cl"><img src="correo2.jpg"></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="large-12 column">
                <hr>
            </div>
        </div>

        <div class="row">
            <p class="small-12 large-4 large-uncentered column copyright">
                Copyright &copy; 2014 Terrazul-Chile
            </p>

<!--            <p class="small-12 large-8 column social">
                <a href="mailto:info@filoxenia.com"><i class="icon-envelope"></i></a>
                <a href="#"><i class="icon-rss"></i></a>
                <a href="//www.facebook.com" target="_blank"><i class="icon-facebook"></i></a>
                <a href="//www.twitter.com" target="_blank"><i class="icon-twitter"></i></a>
                <a href="//www.google.com/plus" target="_blank"><i class="icon-google-plus"></i></a>
                <a href="//www.linkedin.com" target="_blank"><i class="icon-linkedin"></i></a>
                <a href="skype:echo123?call" target="_blank"><i class="icon-skype"></i></a>
            </p>-->
        </div>

    </footer>

    <!-- Javascript -->
    <script src="js/vendor/jquery.js"></script>
    <script src="js/vendor/jquery.magnific-popup.js"></script>
    <script src="js/foundation/foundation.js"></script>
    <script src="js/foundation/foundation.topbar.js"></script>
    <script src="js/foundation/foundation.section.js"></script>
    <script src="js/filoxenia.js"></script>
    <script src="js/custom.js"></script>
    
    
</body>

</html>