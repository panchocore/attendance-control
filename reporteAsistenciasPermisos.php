<?php
	require_once("comun/compruebasesion.php");
	$sobretiempo = $sesion->get("sobre_tiempo");
	$salidaPremiso=4;
	$regresoPermiso=5;
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		
		<title>Reporte Tiempo Permisos</title>
		<link href="estilo/estilo.css" rel="Stylesheet" type="text/css" />
        <link href="estilo/demo_table.css" rel="Stylesheet" type="text/css" />
        <link href="media/css/TableTools.css" rel="Stylesheet" type="text/css" />
	    <script src="scripts/jquery.js" type="text/javascript"></script>
		<script type="text/javascript" src="media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" src="media/js/ZeroClipboard.js"></script>
		<script type="text/javascript" src="media/js/TableTools.js"></script>
   		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('#example').dataTable( {
					"sDom": 'T<"clear">lfrtip',
					"oTableTools": {
						"aButtons": [
							"copy",
							"csv",
							"xls",
							{
								"sExtends": "pdf",
								"sPdfOrientation": "portrait",//landscape
								"sPdfMessage": "Reporte Salida Lunch."
							},
							"print"
						]
					}
				} );
			} );
		</script>
	</head>
	
	<body id="dt_example">
    
    <br/>
		<span style="padding-left:10px" class="Titulos">Reporte Tiempo Permisos</span>
		<div id="container">
			<div id="demo">
				<br/>
			    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Empleado</th>
							<th>Horario Permiso</th>
                            <th>Registro Permiso</th>
							<th width="100px">Tiempo Excedido</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    <?php 
                    require_once("conexion/conexion.php");
                    
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
						
						$consulta = 'SELECT registros1.`FECHA_REGISTRO`, empleado.`NOMBRE_EMPLEADO`,
									(SELECT CONCAT(p.HORA_INICIO, " - ", p.HORA_FIN) 
									 FROM permiso p
									 WHERE p.CODIGO_EMPLEADO = empleado.CODIGO_EMPLEADO
									 AND registros1.`FECHA_REGISTRO` between p.FECHA_INICIO and p.FECHA_FIN) as HORARIO_PERMISO,
									CONCAT(registros1.HORA_REGISTRO, " - ", registros2.`HORA_REGISTRO`) AS REGISTRO_PERMISO,
									SUBTIME(SUBTIME(registros2.`HORA_REGISTRO`, registros1.`HORA_REGISTRO`),
														(SELECT SUBTIME(p.HORA_FIN,p.HORA_INICIO) 
														 FROM permiso p
														 WHERE p.CODIGO_EMPLEADO = empleado.CODIGO_EMPLEADO
														 AND registros1.`FECHA_REGISTRO` between p.FECHA_INICIO and p.FECHA_FIN)) TIEMPO_EXCEDIDO
									FROM ( 
											SELECT `HORA_REGISTRO`,`CODIGO_EMPLEADO`,`FECHA_REGISTRO`,`CODIGO_HORARIO` 
											FROM `registros` 
											WHERE `INOUT_REGISTRO` = '.$salidaPremiso. 
									'		AND `ESTADO_REGISTRO` in (0,1)) as registros1 
									join (
											SELECT `HORA_REGISTRO`,`CODIGO_EMPLEADO`,`FECHA_REGISTRO` 
											FROM `registros` 
											WHERE `INOUT_REGISTRO` = '.$regresoPermiso. 
									'		AND `ESTADO_REGISTRO` in (0,1)) as registros2 
									on registros2.`CODIGO_EMPLEADO` = registros1.`CODIGO_EMPLEADO`
									and registros2.`FECHA_REGISTRO` = registros1.`FECHA_REGISTRO` 
									join empleado 
									on registros1.`CODIGO_EMPLEADO` = empleado.`ID_EMPLEADO` 
									WHERE 1 '; 
						
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
							$consulta = $consulta." and CAST(registros1.`HORA_REGISTRO` AS time) >= CAST('".$hora."' AS time)";				
						}
						if($horafin != "")
						{
							$consulta = $consulta." and CAST(registros1.`HORA_REGISTRO` AS time) <= CAST('".$horafin."' AS time)";				
						}
						if($fecha != "")
						{
							$consulta = $consulta." and CAST(registros1.`FECHA_REGISTRO` AS date) >= CAST('".$fecha."' AS date)";						
						}
						if($fechafin != "")
						{
							$consulta = $consulta." and CAST(registros1.`FECHA_REGISTRO` AS date) <= CAST('".$fechafin."' AS date)";							
						}
						
						$consulta = $consulta." order by registros1.`FECHA_REGISTRO` asc, registros1.`HORA_REGISTRO` asc, empleado.`NOMBRE_EMPLEADO` asc ";
					//echo $consulta;
						if ($result = $conexion->query($consulta)) {
					    if($result->num_rows > 0)
						{
							while ($row = $result->fetch_assoc()) {
								?>
								   	<tr class="odd gradeA">
		                            <td><?php echo $row["FECHA_REGISTRO"];?></td>
		                            <td><?php echo $row["NOMBRE_EMPLEADO"];?></td>
		                            <td><?php echo $row["HORARIO_PERMISO"];?></td>
		                            <td><?php echo $row["REGISTRO_PERMISO"];?></td>
		                            <td><?php echo $row["TIEMPO_EXCEDIDO"];?></td>
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
                    <tfoot>
                        <tr>
                      		<th>Fecha</th>
                            <th>Empleado</th>
							<th>Horario Permiso</th>
                            <th>Registro Permiso</th>
							<th width="100px">Tiempo Excedido</th>
                        </tr>
                    </tfoot>
                </table>
			</div>
		</div>
    </body>
</html>