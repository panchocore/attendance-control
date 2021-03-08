<?php
	require_once("comun/compruebasesion.php");
	require ("zip.php");
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		
		<title>Reporte del Ministerio de Relaciones Laborales</title>
		<link href="estilo/estilo.css" rel="Stylesheet" type="text/css" />
        <link href="estilo/demo_table.css" rel="Stylesheet" type="text/css" />
        <link href="media/css/TableTools.css" rel="Stylesheet" type="text/css" />
	    <script src="scripts/jquery.js" type="text/javascript"></script>
		<script type="text/javascript" src="media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" src="media/js/ZeroClipboard.js"></script>
		<script type="text/javascript" src="media/js/TableTools.js"></script>
		<script src="jqueryui/js/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>
        <link type="text/css" href="estilo/validationEngine.jquery.css" rel="stylesheet"/>
	    <script type="text/javascript" src="scripts/jquery.validationEngine-es.js"></script>
		<script type="text/javascript" src="scripts/jquery.validationEngine.js"></script>
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
								"sPdfMessage": "Reporte de Atrasos."
							},
							"print"
						]
					}
				} );
			} );
		</script>
		<script>
			function descargar(url) {
				window.onfocus = finalizada;
				//document.location = url;
				location.href=url;
			}
			function finalizada() {
				window.onfocus = vacia;
				alert()
			}
			function vacia(){}
		</script>
	</head>
	
	<body id="dt_example">
    
    <br/>
		<span style="padding-left:10px" class="Titulos">Reporte del Ministerio de Relaciones Laborales</span>
		<div id="container">
			<div id="demo">
				<br/>
				<a href="reporte.zip">Descargar el Reporte</a>
				<br/>
				<br/>
			    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>
                            <th>Cedula</th>
							<th>Accion</th>
							<th>Fecha</th>
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
						
						$consulta = 'select e.CEDULA_EMPLEADO as cedula,
											case  
												when r.INOUT_REGISTRO=0 then 1
												when r.INOUT_REGISTRO=1 then 1
												when r.INOUT_REGISTRO=2 then 2
												when r.INOUT_REGISTRO=3 then 2
												when r.INOUT_REGISTRO=4 then 3
												when r.INOUT_REGISTRO=5 then 3
											 end as accion,
											 concat(r.FECHA_REGISTRO, " ", r.HORA_REGISTRO) as fecha
									from	 registros r, empleado e
									where	 r.CODIGO_EMPLEADO = e.ID_EMPLEADO
									and	 r.INOUT_REGISTRO not in (6, 7)';
					
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
						
						$consulta = $consulta." order by `FECHA_REGISTRO` asc, `HORA_REGISTRO` asc, r.`CODIGO_EMPLEADO` asc ";
					
					//echo $consulta;
						 
					    $ar=fopen("datos.txt","w") or die("Problemas en la creacion"); 
						
						if ($result = $conexion->query($consulta)) {
					    if($result->num_rows > 0)
						{
							while ($row = $result->fetch_assoc()) {
								fputs($ar,$row["cedula"]." ".$row["accion"]." ".$row["fecha"]);
								fputs($ar,"\n");
						?>
						
								<tr>
								    <td><?php echo $row["cedula"];?></td>
									<td><?php echo $row["accion"];?></td>
									<td><?php echo $row["fecha"];?></td>
		                        </tr>
								
						<?php 
						    }  
							$result->close();
					    	$conexion->close();	
															   
						  fclose($ar); 
						  //echo "Los datos se cargaron correctamente."; 
							
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
                      		<th>Cedula</th>
							<th>Accion</th>
							<th>Fecha</th>
                        </tr>
                    </tfoot>
				</table>
				<?php					
					$zip = new zip();
					$zip->add_file("datos.txt","datos.txt");
					//$fileName = date("d-m-Y")."_reporte.zip";
					$fileName = "reporte.zip";
					$fd = fopen ($fileName, "wb");
					$out = fwrite ($fd, $zip->file());
					fclose ($fd);
				?>
			</div>
		</div>
    </body>
</html>