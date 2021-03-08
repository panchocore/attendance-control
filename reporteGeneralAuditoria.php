<?php
	require_once("comun/compruebasesion.php");
	
	$usuario = $sesion->get("nombreusuario");
	if($sesion->get("ReporteAuditoria"))
		$obtener_permisos = $sesion->get("ReporteAuditoria");
	else 
		$obtener_permisos = 0;
	
	if($obtener_permisos == 0)
		header("Location: finsesion.php");
		
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		
		<title>Reporte Auditoria General</title>
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
								"sPdfMessage": "Reporte General Auditoria."
							},
							"print"
						]
					}
				} );
			} );
		</script>
	</head>
	
	<body id="dt_example">
    
	<?php 
		if(isset($_GET["saveModified"]))
		{
			//echo $_GET["saveModified"];
			echo "<script type='text/javascript'>";
			echo "MuestraInformacion('".substr($_GET["saveModified"],0,130)."');";
			echo "</script> ";
			
		}
		
	?>
	
    <br/>
		<span style="padding-left:10px" class="Titulos">Reporte General de Auditoria</span>
		<div id="container">
			<div id="demo">
				<br/>
			    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Tabla</th>
                            <th>Usuario</th>
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
						
						$fechaini = $_REQUEST['fechaini'];
						$fechafin = $_REQUEST['fechafin'];
						
						$consulta = "select * from (
									select 'area' as tabla, usumod as usuario, fecmod as fecha
									from	 area 
									union
									select 'empleado' as tabla, usumod as usuario, fecmod as fecha
									from	 empleado 
									union
									select 'cronograma' as tabla, usumod as usuario, fecmod as fecha
									from	 empleadohorario 
									union
									select 'empresa' as tabla, usumod as usuario, fecmod as fecha
									from	 empresa 
									union
									select 'horario' as tabla, usumod as usuario, fecmod as fecha
									from	 horario 
									union
									select 'usuario' as tabla, usumod as usuario, fecmod as fecha
									from	 usuario 
									) t ";
					
						if($fechaini != "" and $fechafin != "")
						{
							$consulta = $consulta." where fecha between '".$fechaini."' and '".$fechafin."'";						
						}
						
						$consulta = $consulta." order by fecha desc ";
						
						if ($result = $conexion->query($consulta)) {
					    if($result->num_rows > 0)
						{
							while ($row = $result->fetch_assoc()) {
		                        ?>
								<tr>
								    <td><?php echo $row["fecha"];?></td> 
									<td><?php echo $row["tabla"];?></td>
		                            <td><?php echo $row["usuario"];?></td>
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
                            <th>Tabla</th>
                            <th>Usuario</th>
                        </tr>
                    </tfoot>
                </table>
			</div>
		</div>
    </body>
</html>