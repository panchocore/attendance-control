<?php
	require_once("comun/compruebasesion.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		
		<title>Reporte Asistencia General</title>
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
								"sPdfMessage": "Reporte General Asistencias."
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
		<span style="padding-left:10px" class="Titulos">Reporte General de asistencia</span>
		<div id="container">
			<div id="demo">
				<br/>
			    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Empleado</th>
                            <th>Horario</th>
                            <th width="80px">Estado</th>
                            <th width="100px">Entrada/Salida</th>
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
					//empleado=3&hora=10:22 &fecha=2012-06-21&horafin=01:02 &fechafin=2012-06-21
						$area = $_REQUEST['area'];	
						$empleado = $_REQUEST['empleado'];
						$hora = $_REQUEST['hora'];
						$horafin = $_REQUEST['horafin'];
						$fecha = $_REQUEST['fecha'];
						$fechafin = $_REQUEST['fechafin'];
						
						$consulta = "SELECT `HORA_REGISTRO` , `FECHA_REGISTRO` , registros.`CODIGO_EMPLEADO` , 
						registros.`CODIGO_HORARIO` , `ESTADO_REGISTRO` , `INOUT_REGISTRO` , `NOMBRE_EMPLEADO`,
						`NOMBRE_HORARIO` 
										FROM registros
										JOIN empleado ON empleado.`ID_EMPLEADO` = registros.`CODIGO_EMPLEADO` 
										LEFT JOIN horario ON horario.`CODIGO_HORARIO` = registros.`CODIGO_HORARIO`
										where `ESTADO_REGISTRO` in (0,1)";
					
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
								<?php if ($row["ESTADO_REGISTRO"] == 1)
		                          	{
		                        ?>
		                           	<tr class="odd gradeA">
		                        <?php 
		                           	}
		                        	else{
		                        ?>
		                           	<tr class="odd gradeX">
		                        <?php 
		                           	}
		                        ?>
								    <td><?php echo $row["FECHA_REGISTRO"];?></td>
		                            <td><?php echo $row["HORA_REGISTRO"];?></td>
		                            <td><?php echo $row["NOMBRE_EMPLEADO"];?></td>
		                            <td><?php echo $row["NOMBRE_HORARIO"];?></td>
		                            <td class="center">
		                            	<?php if ($row["ESTADO_REGISTRO"] == 1)
		                            	{
		                            	?>
		                            	Activo
		                            	<?php 
		                            	}
		                            	else{
		                            	?>
		                            	Inactivo
		                            	<?php 
		                            	}
		                            	?>
		                            </td>
		                            <td class="center">
		                            	<?php if ($row["INOUT_REGISTRO"] == 1)
		                            	{
		                            	?>
		                            	Entrada
		                            	<?php 
		                            	}
		                            	else{
		                            	?>
		                            	Salida
		                            	<?php 
		                            	}
		                            	?>
		                            </td>
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
                            <th>Hora</th>
                            <th>Empleado</th>
                            <th>Horario</th>
                            <th>Estado</th>
                            <th>Entrada/Salida</th>
                           
                        </tr>
                    </tfoot>
                </table>
			</div>
		</div>
    </body>
</html>