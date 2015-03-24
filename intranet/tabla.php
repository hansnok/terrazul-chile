<?php 
session_start();
include 'encrypter.php';
	if( isset($_SESSION['usuario']) && isset($_POST['valor'])){					

			$criterio = $_POST['valor'];
			mostrarTabla($criterio);

			
	}else{
		if(isset($_SESSION['usuario']) && isset($_POST['rut']) && isset($_POST['criterio']) && isset($_POST['color'])){
			$servidor = "localhost";
			$usuario="terrazul_2"; // 
    		$contraseña = Encrypter::decrypt("4q8xp98EE34oxahuZZ+GgWr6QwlgOW0UGJ3+69VUjW4=");
				
			$conexion=  mysql_connect($servidor,$usuario,$contraseña);
			$j=1;
			while($j>0){
				if(!($conexion= mysql_connect($servidor,$usuario,$contraseña))){
					$conexion= mysql_connect($servidor,$usuario,$contraseña);
				}else{
					$j=-1;
				}
			}
			
			$bbdd="terrazul_intranet";
			$db=mysql_select_db($bbdd,$conexion);
			
			$idCriterio = (int)$_POST['criterio'];
			$idEmpresa = (string)$_POST['rut'].'';
			$color = (string) $_POST['color'].'';
			
			//echo "criterio ".$idCriterio." empresa ".$idEmpresa." color ".$color;
			if($color == 'rojo'){
				$queryUpdate="UPDATE empresas_criterios
				SET estado = 'rojo'
				WHERE nombre_empresa = '$idEmpresa'
				and id_criterio = '$idCriterio'";
				//echo "<br>".$queryUpdate."<br>";
				$actualizacion = mysql_query($queryUpdate,$conexion);
				//echo "<br>****** Actuzaliacion  $actualizacion + afecto ".mysql_affected_rows()."*******<br>";
			
			}else{
				$queryUpdate="UPDATE empresas_criterios
				SET estado = 'verde'
				WHERE nombre_empresa = '$idEmpresa'
				and id_criterio = '$idCriterio'";
				//echo "<br>".$queryUpdate."<br>";
				$actualizacion = mysql_query($queryUpdate,$conexion);
				//echo "<br>****** Actuzaliacion  $actualizacion + afecto ".mysql_affected_rows()."*******<br>";
			}
			mostrarTabla($idCriterio);
		}else{
			echo'<META HTTP-EQUIV="Refresh" CONTENT = "0; URL=index.php">';
		}
	}
	
	function mostrarTabla($criterio){
		$servidor = "localhost";
		$usuario = "terrazul_tareas";
		$contraseña = Encrypter::decrypt("pgonJ5SQ42gtVKBpEUaw4gs/Pa7V6f4ZaU8ZjRCtKO8=");
			
		$conexion=  mysql_connect($servidor,$usuario,$contraseña);
		$j=1;
		while($j>0){
			if(!($conexion= mysql_connect($servidor,$usuario,$contraseña))){
				$conexion= mysql_connect($servidor,$usuario,$contraseña);
			}else{
				$j=-1;
			}
		}
		
		$bbdd="terrazul_intranet";
		$db=mysql_select_db($bbdd,$conexion);
			
		$queryCriterio = "SELECT nombre FROM criterio WHERE id_criterio = $criterio";
		$consultaCriterio = mysql_query($queryCriterio,$conexion);
		$nombreCriterio = mysql_result($consultaCriterio,0);
			
		$querytotalEmpresas = "SELECT *
							 FROM empresas";
		$consultaEmpresas = mysql_query($querytotalEmpresas,$conexion);
			
		if($consultaEmpresas){
			//trajo las empresas correctamente
			$empresas = array();
			$i = 0;
			while($datos= mysql_fetch_assoc($consultaEmpresas)){
				$empresas[$i] = array($datos['rut'],$datos['empresa']);
				$i++;
			}
		
			$queryCriteriosRealizados = "SELECT empresas_criterios.nombre_empresa, empresas_criterios.estado
			FROM empresas INNER JOIN empresas_criterios ON empresas.empresa = empresas_criterios.nombre_empresa
			WHERE empresas_criterios.id_criterio = '$criterio'";
			$consultaCriterios = mysql_query($queryCriteriosRealizados,$conexion);
		
		
			if($consultaCriterios){
				$empresasCriterios = array();
				$j=0;
				while($datos= mysql_fetch_assoc($consultaCriterios)){
					$empresasCriterios [$j] = array($datos['nombre_empresa'],$datos['estado']);
					$j++;
				}
					
				echo '<div class="alert alert-dismissible alert-warning">
  							<button type="button" class="close" data-dismiss="alert">×</button>
  							<h4>'.$nombreCriterio.'</h4></div>';
				echo '<table class="table table-striped table-hover ">
  							<thead>
    							<tr>
      								<th>Empresa</th>
      								<th>Estado</th>
      								<th>Comentario</th>
    								</tr>
  							</thead>
  						<tbody>';
				//var_dump($empresasCriterios);
				//var_dump($empresas);
				for($h=0 ; $h < count($empresas) ; $h++){
					echo '<tr>';
					if(isset($empresasCriterios[$h][0])){ // existe dato con color
						if($empresasCriterios[$h][1] == 'rojo'){ // celda roja
							$nombreEmpresa = $empresas[$h][1];
							echo "<td>".$empresas[$h][1]."</td>";
							echo "<td class='danger' idCriterio='$criterio' idEmpresa='$nombreEmpresa' relleno='rojo' ></td>";
							echo "<td> - </td>";
						}else{// celda verde
							$nombreEmpresa = $empresas[$h][1];
							echo "<td>".$empresas[$h][1]."</td>";
							echo "<td class='success' idCriterio='$criterio' idEmpresa='$nombreEmpresa' relleno='verde' ></td>";
							echo "<td> - </td>";
						}
						}else{
							// no existe dato con color, crear
								$nombreEmpresa = $empresas[$h][1];
								//echo $nombreEmpresa."<br>";
								$fecha = date('Y-m-d');
								$queryIngresar = "INSERT INTO empresas_criterios (nombre_empresa, id_criterio, fecha, estado)
								VALUES ('$nombreEmpresa','$criterio','$fecha' ,'rojo')";
								$ingresar = mysql_query($queryIngresar,$conexion);
								//echo $ingresar;
								//$queryUpdate="UPDATE empresas_criterios
								//SET id_empresa = '$idEmpresa'
								//WHERE id_empresa like %'$idEmpresa'%";
								
								//$actualizacion = mysql_query($queryUpdate,$conexion);
								
								echo "<td>".$empresas[$h][1]."</td>";
								echo "<td class='danger' idCriterio='$criterio' idEmpresa='$nombreEmpresa' relleno='rojo' ></td>";
								echo "<td> no existe dato</td>";
							}
							echo "</tr>";
				}
			}
		}
		mysql_close();
		//javascript para las celdas
		echo "<script type='text/javascript'>";
		echo "var actualizarColorVerde = $('.success');
            actualizarColorVerde.click(function(e){
                e.preventDefault();
                //alert('rescata evento');
				var tabla2 = $('#actividades2');
                var tabla = $('#actividades');
            	var idCriterio = $(this).attr('idCriterio');
            	var idEmpresa = $(this).attr('idEmpresa');
            	$.ajax({
                    type: 'POST',
                    url: 'tabla.php',
                    data: {rut : idEmpresa, criterio : idCriterio, color: 'rojo'},
                    success: function(data) {
                        tabla2.html(data),tabla.html(' ');
                    }
                })
            });

            var actualizarColorRojo = $('.danger'); 
            actualizarColorRojo.click(function(e){
                e.preventDefault();
                //alert('rescata evento');
				var tabla2 = $('#actividades2');
                var tabla = $('#actividades');
            	var idCriterio = $(this).attr('idCriterio');
            	var idEmpresa = $(this).attr('idEmpresa');
            	$.ajax({
                    type: 'POST',
                    url: 'tabla.php',
                    data: {rut : idEmpresa, criterio : idCriterio, color: 'verde'},
                    success: function(data) {
                        tabla2.html(data),tabla.html(' ');
                    }
                })
            });";
		echo "</script>";
	}

?>