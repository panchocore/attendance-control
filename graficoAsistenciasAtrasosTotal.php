<?php
	require_once("comun/compruebasesion.php");
	$atrasos = $sesion->get("atraso_tiempo");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		
		<title>Reporte Grafico Atrasos Totales</title>
		<script src="scripts/jquery.js" type="text/javascript"></script>
		<link type="text/css" rel="stylesheet" href="graficas/css/visualize.css"/>
		<!--[if IE]><script type="text/javascript" src="graficas/excanvas.compiled.js"></script><![endif]-->
		<script type="text/javascript" src="graficas/visualize.jQuery.js"></script>
		<link type="text/css" rel="stylesheet" href="graficas/demopage.css"/>
		
		
   		<script type="text/javascript" charset="utf-8">
			$(function(){
				//make some charts
				$('table.pie').visualize({type: 'pie', pieMargin: 10, title: 'Reporte Atrasos Totales'});
				$('table.line').visualize({type: 'line'});
				$('table.area').visualize({type: 'area'});
				$('table.bar').visualize({type: 'bar'});
			});

			
		</script>
	</head>
	
	<body id="dt_example">
    
    <br/>
		<div id="container">
			<div id="demo">
				<br/>
			    <table class="pie bar ">
				<caption>Reporte Grafico Atrasos Totales</caption>
				<thead>
					<tr>
						<td></td>
						<th>Atrasos(segundos)</th>
					</tr>
				</thead>
	
                    <tbody>
                    
                    <?php 
                    require_once("conexion/conexion.php");
                    //$conexion = new mysqli("localhost","usuario","password","base");
					$conexion = new mysqli($hostname,$username,$password,$database);
					/* check connection */
					if ($conexion->connect_errno) {
						echo "<script type='text/javascript'>";
						echo "mostrarerroregajosoderecha('"."Connect failed: %s\n".$conexion->connect_error."');";
						echo "</script>";
					    //echo "Connect failed: %s\n".$conexion->connect_error;
					    exit();
					}
					$area = $_REQUEST['area'];	
					$empleado = $_REQUEST['empleado'];
						$hora = $_REQUEST['hora'];
						$horafin = $_REQUEST['horafin'];
						$fecha = $_REQUEST['fecha'];
						$fechafin = $_REQUEST['fechafin'];
						
						$consulta = 'SELECT SUM( TIME_TO_SEC( SUBTIME(`HORA_REGISTRO`, `HORAINICIO_HORARIO`) ) ) AS total_time
									,`NOMBRE_EMPLEADO`
										FROM registros
										JOIN empleado ON empleado.`ID_EMPLEADO` = registros.`CODIGO_EMPLEADO` 
										LEFT JOIN horario ON horario.`CODIGO_HORARIO` = registros.`CODIGO_HORARIO`
										where `ESTADO_REGISTRO` in (0,1) and `INOUT_REGISTRO` = 0 
										and horario.codigo_horario != -1
										and SUBTIME(`HORA_REGISTRO`, `HORAINICIO_HORARIO`) >= CAST("'.$atrasos.'" AS time)
										group by registros.`CODIGO_EMPLEADO`';
										
					
						if($area > 0)
						{
							$consulta = $consulta." and empleado.`CODIGO_AREA` = ".$area;
						}
						if($empleado > 0)
						{
							$consulta = $consulta." and empleado.`CODIGO_EMPLEADO` = ".$empleado;
						}
						if($hora != "")
						{
							$consulta = $consulta." and CAST(`HORA_REGISTRO` AS time) >= CAST('".$hora."' AS time)";				
						}
						if($horafin != "")
						{
							$consulta = $consulta." and CAST(`HORA_REGISTRO` AS time) <= CAST('".$horafin."' AS time)";				
						}
						if($fecha != "")
						{
							$consulta = $consulta." and CAST(`FECHA_REGISTRO` AS date) >= CAST('".$fecha."' AS date)";						
						}
						if($fechafin != "")
						{
							$consulta = $consulta." and CAST(`FECHA_REGISTRO` AS date) <= CAST('".$fechafin."' AS date)";							
						}
						
						$consulta = $consulta." order by `FECHA_REGISTRO` asc, `HORA_REGISTRO` asc, registros.`CODIGO_EMPLEADO` asc ";
					
						if ($result = $conexion->query($consulta)) {
					    if($result->num_rows > 0)
						{
							while ($row = $result->fetch_assoc()) {
								?>
								   	<tr>
										<th><?php echo $row["NOMBRE_EMPLEADO"];?></th>
										<td><?php echo $row["total_time"];?></td>
									</tr>
								<?php 
						    }  
							$result->close();
					    	$conexion->close();							
						}
						else{
							$result->close();
					    	$conexion->close();
						}
					    
					}
					else 
					{
						echo "<script type='text/javascript'>";
						echo 'mostrarerroregajosoderecha("'.$conexion->error.'");';
						echo "</script>";
						exit();
						//echo($conexion->error);
					}
                    ?>
                    </tbody>
					</table>
    		</div>
		</div>
		
		
    </body>
</html>