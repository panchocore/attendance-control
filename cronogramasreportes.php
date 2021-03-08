<?php
	require_once("comun/compruebasesion.php");
	
	$usuario = $sesion->get("nombreusuario");
	if($sesion->get("ReporteCronogramas"))
		$obtener_permisos = $sesion->get("ReporteCronogramas");
	else 
		$obtener_permisos = 0;
	
	if($obtener_permisos == 0)
		header("Location: finsesion.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		
		<title>Cronogramas</title>
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
								"sPdfMessage": "Reporte de usuarios."
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
		<span style="padding-left:10px" class="Titulos">Cronogramas</span>
		<div id="container">
			<div id="demo">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Horario</th>
							<th>Empleado</th>
							<th>Desde</th>
							<th>Hasta</th>
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
					$consulta = "select eh.CODIGO_EMPLEADOHORARIO, eh.CODIGO_HORARIO, h.NOMBRE_HORARIO, eh.CODIGO_EMPLEADO, e.NOMBRE_EMPLEADO, eh.DESDE_EMPLEADOHORARIO, eh.HASTA_EMPLEADOHORARIO ".
								"from	empleadohorario eh, horario h, empleado e ".
								"where	eh.CODIGO_HORARIO = h.CODIGO_HORARIO ".
								"and	eh.CODIGO_EMPLEADO = e.CODIGO_EMPLEADO ";
					if ($result = $conexion->query($consulta)) {
					    if($result->num_rows > 0)
						{
							while ($row = $result->fetch_assoc()) {
								?>
		                            <td><?php echo $row["CODIGO_EMPLEADOHORARIO"];?></td>
		                            <td><?php echo $row["NOMBRE_HORARIO"];?></td>
									<td><?php echo $row["NOMBRE_EMPLEADO"];?></td>
									<td><?php echo $row["DESDE_EMPLEADOHORARIO"];?></td>
									<td><?php echo $row["HASTA_EMPLEADOHORARIO"];?></td>
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
						echo "mostrarerroregajosoderecha('".($conexion->error)."');";
						echo "</script>";
						exit();
						//echo($conexion->error);
					}
                    ?>
                    
                    <!--     <tr class="odd gradeC">
                            <td>Trident</td>
                            <td>Internet
                                 Explorer 4.0</td>
                            <td>Win 95+</td>
                            <td class="center"> 4</td>
                            <td class="center">X</td>
                        </tr>
                        <tr class="gradeA">
                        <tr class="gradeX">
                        <tr class="gradeU">
                    -->
                    </tbody>
                    <tfoot>
                        <tr>
                      		<th>Codigo</th>
                            <th>Horario</th>
							<th>Empleado</th>
							<th>Desde</th>
							<th>Hasta</th>
                        </tr>
                    </tfoot>
                </table>
			</div>
			
			</div>
		</div>
	</body>
</html>