<?php
	require_once("comun/compruebasesion.php");
	$usuario = $sesion->get("nombreusuario");
	if($sesion->get("DatosGenerales"))
		$obtener_permisos = $sesion->get("DatosGenerales");
	else 
		$obtener_permisos = 0;
	
	if($obtener_permisos == 0)
		header("Location: finsesion.php");
	require_once("conexion/conexion.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="estilo/estilo.css" rel="stylesheet" type="text/css" />
	<link type="text/css" href="jqueryui/css/redmond/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
    <link type="text/css" href="estilo/jquery.toastmessage.css" rel="stylesheet"/>
    <script src="scripts/jquery.js" type="text/javascript"></script>
 	<script type="text/javascript" src="scripts/jquery.toastmessage.js"></script>
    <script type="text/javascript" src="scripts/mensajes.js"></script>
    <link type="text/css" href="estilo/validationEngine.jquery.css" rel="stylesheet"/>
    <script type="text/javascript" src="scripts/jquery.validationEngine-es.js"></script>
	<script type="text/javascript" src="scripts/jquery.validationEngine.js"></script>
	<script src="jqueryui/js/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="scripts/permisos.js"></script>
	<script type="text/javascript" src="scripts/jquery-ui-timepicker-addon.js"></script>
    <script type="text/javascript">
            jQuery(document).ready(function(){
                // binds form submission and fields to the validation engine
                $("#formEmpresa").validationEngine('attach');
            });
            $(function() {
    			
            	$( "input:submit, input:button" ).button();
				
				$('#tiempoAtraso').timepicker({
					hourGrid: 4,
					minuteGrid: 10,
					secondGrid: 10,
					timeOnlyTitle: 'Seleccione el tiempo',
					timeText: 'hh/mm: ',
					hourText: 'Hora',
					minuteText: 'Minutos',
					secondText: 'Segundos',
					//currentText: 'Hora actual',
					closeText: 'Listo'
				});
				
				$('#sobreTiempo').timepicker({
					hourGrid: 4,
					minuteGrid: 10,
					secondGrid: 10,
					timeOnlyTitle: 'Seleccione el tiempo',
					timeText: 'hh/mm: ',
					hourText: 'Hora',
					minuteText: 'Minutos',
					secondText: 'Segundos',
					//currentText: 'Hora actual',
					closeText: 'Listo'
				});
            });
            
    </script>
</head>
<body onload="javascript:desabilitarMenusForm(<?php echo $obtener_permisos;?>)">
<?php 	
	
	if(isset($_POST["Guardar"]))
		{
			
			$conexion = new mysqli($hostname,$username,$password,$database);
			/* check connection */
			if ($conexion->connect_errno) {
			    echo "<script type='text/javascript'>";
				echo 'mostrarerroregajosoderecha("'.$conexion->connect_error.'");';
				echo "</script>";
			    exit();
			}
			$consulta = 'SELECT `CODIGO_EMPRESA` FROM `empresa` LIMIT 0, 1 ';
			if ($result = $conexion->query($consulta)) {
			    if($result->num_rows > 0)
				{
					$fila = $result->fetch_assoc();
					$CodigoEmpresa=  $fila["CODIGO_EMPRESA"] ;
					$result->close();
					
					$consulta = 'UPDATE empresa SET `NOMBRE_EMPRESA` = \''. $_POST["nombreEmpresa"] .'\',
`TELEFONO_EMPRESA` =\''. $_POST["TelefonoEmpresa"] .'\',
`RUC_EMPRESA` =\''. $_POST["rucEmpresa"] .'\',
`DIRECCION_EMPRESA` =\''. $_POST["DireccionEmpresa"] .'\', 
`atraso_tiempo` =\''. $_POST["tiempoAtraso"] .'\',
`sobre_tiempo` =\''. $_POST["sobreTiempo"] .'\',
usumod = \''. $usuario .'\',
fecmod = CURRENT_TIMESTAMP 
WHERE `empresa`.`CODIGO_EMPRESA` = '.$CodigoEmpresa.' LIMIT 1;';

					if ($conexion->query($consulta)) {
					    echo "<script type='text/javascript'>";
						echo "MuestraMensajeGuardadoCorrectoPegajoso('Se han guardado los cambios correctamente!');";
						echo "</script>";
					}
					else 
					{
						echo "<script type='text/javascript'>";
						echo 'mostrarerroregajosoderecha("'.($conexion->error).'");';
						echo "</script>";
						//exit();
					} 
	
				}
				else{
					$consulta = 'INSERT INTO empresa (`CODIGO_EMPRESA` ,
								`RUC_EMPRESA` ,
								`NOMBRE_EMPRESA` ,
								`DIRECCION_EMPRESA` ,
								`TELEFONO_EMPRESA`,
								atraso_tiempo,
								sobre_tiempo,
								usumod,
								fecmod
								)
								VALUES (NULL,
								\''. $_POST["rucEmpresa"] .'\',
								\''. $_POST["nombreEmpresa"] .'\',
								\''. $_POST["DireccionEmpresa"] .'\',
								\''. $_POST["TelefonoEmpresa"] .'\',
								\''. $_POST["tiempoAtraso"] .'\',
								\''. $_POST["sobreTiempo"] .'\',
								\''. $usuario .'\',
								CURRENT_TIMESTAMP);';
					if ($conexion->query($consulta)) {
					    echo "<script type='text/javascript'>";
						echo "MuestraMensajeGuardadoCorrectoPegajoso('Se ha insertado la informacion correctamente!');";
						echo "</script>";
					}
					else 
					{
						echo "<script type='text/javascript'>";
						echo 'mostrarerroregajosoderecha("'.($conexion->error).'");';
						echo "</script>";
						//exit();
					} 
				}
			}
			else 
			{
				echo "<script type='text/javascript'>";
				echo 'mostrarerroregajosoderecha("'.($conexion->error).'");';
				echo "</script>";
				//exit();
			} 
			
		}
				
		/*$hostname="localhost";
		$username='root';
		$password="";
		$database="controlasistencia";/**/
		$conexion = new mysqli($hostname,$username,$password,$database);
		/* check connection */
		if ($conexion->connect_errno) {
		    echo "<script type='text/javascript'>";
			echo 'mostrarerroregajosoderecha("'.$conexion->connect_error.'");';
			echo "</script>";
		    exit();
		}
		$consulta = 'SELECT `CODIGO_EMPRESA` , `RUC_EMPRESA` , `NOMBRE_EMPRESA` , `DIRECCION_EMPRESA` , `TELEFONO_EMPRESA` , `LOGO_EMPRESA`, atraso_tiempo, sobre_tiempo FROM `empresa` LIMIT 0, 1 ';
		if ($result = $conexion->query($consulta)) {
		    if($result->num_rows > 0)
			{
				//echo $result->num_rows;
				$fila = $result->fetch_assoc();
				//echo "<br/>";
				//echo $fila["CLAVE_USUARIO"];
				//echo $clave;
				$CodigoEmpresa=  $fila["CODIGO_EMPRESA"] ;
				$RucEmpresa=  $fila["RUC_EMPRESA"] ;
				$NombreEmpresa= $fila["NOMBRE_EMPRESA"] ;
				$DireccionEmpresa= $fila["DIRECCION_EMPRESA"] ; 
				$TelefonoEmpresa= $fila["TELEFONO_EMPRESA"] ;
				$tiempoAtraso= $fila["atraso_tiempo"] ;
				$sobreTiempo= $fila["sobre_tiempo"] ;
				$result->close();
				$conexion->close();
				
			}
			else{
				$CodigoEmpresa = 0;
		    	$RucEmpresa=  "";
				$NombreEmpresa= "";
				$DireccionEmpresa= ""; 
				$TelefonoEmpresa= "";
				$tiempoAtraso= "";
				$sobreTiempo= "";
				$result->close();
				$conexion->close();
			}
		    
		}
		else 
		{
			echo "<script type='text/javascript'>";
			echo 'mostrarerroregajosoderecha("'.($conexion->error).'");';
			echo "</script>";
			//exit();
			$conexion->close();
		} 
		
		
		
		
?>


<br/>
<span class="Titulos">Datos Generales de la Empresa</span>
<br/>
<br/>
<form id="formEmpresa" method="post" action="">
	<table>
		<tr height="40px">
	   		<td>
            	Nombre(*):
			</td>
			<td>
           		<input type="text" class="validate[required]" style="width:300px" name="nombreEmpresa" id="nombreEmpresa" value="<?php echo $NombreEmpresa;?>"/>
			</td>
        </tr>
        <tr height="40px">
            <td>
            	RUC:
			</td>
			<td>
				<input type="text" class="validate[optional,custom[integer],minSize[10],maxSize[13]]" style="width:300px" name="rucEmpresa" id="rucEmpresa" value="<?php echo $RucEmpresa;?>"/>
			</td>
		</tr>
        <tr height="40px">
	   		<td>
            	Direccion(*):
			</td>
            <td>
				<input type="text" class="validate[required]" style="width:300px" name="DireccionEmpresa" id="DireccionEmpresa" value="<?php echo $DireccionEmpresa;?>"/>
			</td>
        </tr>
        <tr height="40px">
            <td>
            	Telefono(*):
			</td>
			<td>
				<input type="text" class="validate[required,custom[phone]]" style="width:300px" name="TelefonoEmpresa" id="TelefonoEmpresa" value="<?php echo $TelefonoEmpresa;?>"/>
			</td>
		</tr>
        <tr height="40px">
			<td>
				Tiempo Atraso:
			</td>
			<td>
				<input type="text" class="validate[required]" style="width:180px" name="tiempoAtraso" id="tiempoAtraso" value="<?php echo $tiempoAtraso;?>"/>
			</td>
		</tr>
		<tr height="40px">
			<td>
				Sobre Tiempo:
			</td>
			<td>
				<input type="text" class="validate[required]" style="width:180px" name="sobreTiempo" id="sobreTiempo" value="<?php echo $sobreTiempo;?>"/>
			</td>
		</tr>
	</table>
	<br/>
	&nbsp;<input name="Guardar" type="Submit" value="Guardar">
</form>
<br/>
</body>
</html>
