<?php
	require_once("comun/compruebasesion.php");
	
	$usuario = $sesion->get("nombreusuario");
	if($sesion->get("Cronogramas"))
		$obtener_permisos = $sesion->get("Cronogramas");
	else 
		$obtener_permisos = 0;
	
	if($obtener_permisos == 0)
		header("Location: finsesion.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		
		<title>Horarios</title>
		
   		<link href="estilo/estilo.css" rel="Stylesheet" type="text/css" />
        <link href="estilo/demo_table.css" rel="Stylesheet" type="text/css" />
	    <link type="text/css" href="jqueryui/css/redmond/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
        <link type="text/css" href="estilo/jquery.toastmessage.css" rel="stylesheet"/>
	    <script src="scripts/jquery.js" type="text/javascript"></script>
		<script type="text/javascript" src="media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" src="scripts/jquery.toastmessage.js"></script>
        <script type="text/javascript" src="scripts/mensajes.js"></script>
    	<script src="jqueryui/js/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>
        <link type="text/css" href="estilo/validationEngine.jquery.css" rel="stylesheet"/>
	    <script type="text/javascript" src="scripts/jquery.validationEngine-es.js"></script>
		<script type="text/javascript" src="scripts/jquery.validationEngine.js"></script>
		<script type="text/javascript" src="scripts/jquery.ui.datepicker.js"></script>
		<script type="text/javascript" src="scripts/combobox.js"></script>	
		<script type="text/javascript" src="scripts/permisos.js"></script>
		
		<script type="text/javascript" charset="utf-8">

   		$(function() {

			$( "#dialog:ui-dialog" ).dialog( "destroy" );
			
			$( "input:submit, input:button" ).button();
			
			$( "#selectEmpleado" ).combobox();
			$( "#toggle" ).click(function() {
				$( "#selectEmpleado" ).toggle();
			});
			$( "#selectHorario" ).combobox();
			$( "#toggle" ).click(function() {
				$( "#selectHorario" ).toggle();
			});
			$( "#selectEmpleadoNuevo" ).combobox();
			$( "#toggle" ).click(function() {
				$( "#selectEmpleadoNuevo" ).toggle();
			});
			$( "#selectHorarioNuevo" ).combobox();
			$( "#toggle" ).click(function() {
				$( "#selectHorarioNuevo" ).toggle();
			});			
		
   			$("#eliminarCronograma").dialog({
					autoOpen: false,
					bgiframe: true,
					resizable: false,
					height:150,
					modal: true,
					overlay: {
						backgroundColor: '#000',
						opacity: 0.5
					}
				});
			
			$( "#modificaCronograma" ).dialog({
   				autoOpen: false,
					bgiframe: true,
					resizable: false,
					height:350,
					width:300,
					modal: true,
					overlay: {
						backgroundColor: '#000',
						opacity: 0.5
					}
   			});
			
			$( "#nuevoCronograma" ).dialog({
   				autoOpen: false,
					bgiframe: true,
					resizable: false,
					height:350,
					width:300,
					modal: true,
					overlay: {
						backgroundColor: '#000',
						opacity: 0.5
					}
   			});
   		});

		$(document).ready(function() {
				$('#example').dataTable( {
				"oLanguage": {
					"sLengthMenu": "Mostrar _MENU_ registros por pagina",
					"sZeroRecords": "No se encontro registros",
					"sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
					"sInfoEmpty": "Mostrando 0 a 0 de 0 registros",
					"sInfoFiltered": "(filtrados de un total de _MAX_ registros)",
					"sSearch": "Buscar:"
				}
//				"sPaginationType": "full_numbers"
				} );
				
				$("#formCronograma").validationEngine('attach');
				$("#formNuevoCronograma").validationEngine('attach');
			} );
			
			function EliminarCronogramaModal(registroaEliminar){
					$('#eliminarCronograma').dialog('option', "buttons", [
					{
						text: "Eliminar",
						click: function() { $.post("eliminarRegistro.php",{ Id: registroaEliminar, Estado: 2, Tabla: 'cronograma' },
											   function(data){
												 //location.reload();
												 //$('#dt_example').html(data);
												window.location.href='cronograma.php?saveModified='+data;
											   }
											);
										    //$('#eliminarUsuario').dialog('close'); 
											
										  }
					},
					{
						text: "Cancelar",
						click: function() { $('#eliminarCronograma').dialog('close'); }
					}
					]);
					$('#eliminarCronograma').dialog('open');
			}
			
			//SimpleDateFormat formato = new SimpleDateFormat("MM/dd/yyyy");
			
			function ModificarCronogramaModal(registroaModificar, horario, empleado, desde, hasta){
					$('#modificaCronograma').dialog('option', "buttons", [
					{
						text: "Modificar",
						click: function() { 
										if(!$(".formError").length){					
												$.post("modificarCronograma.php",{ codigo: registroaModificar, horario: $('#selectHorario').val(), empleado: $('#selectEmpleado').val(), desde: $('#desde').val(), hasta: $('#hasta').val()},
											   function(data){
													window.location.href='cronograma.php?saveModified='+data;
													//alert (data);
											   	}
												);
											}
										  }
					},
					{
						text: "Cancelar",
						click: function() { $('#modificaCronograma').dialog('close'); 
											$(".formError").remove();}
					}
					]);

					$('#modificaCronograma').dialog('open');
					
					id = '#selectEmpleado';
					$(id).val(empleado);
					$(id).next().val($(id + " :selected").text());
					
					id = '#selectHorario';
					$(id).val(horario);
					$(id).next().val($(id + " :selected").text());
					
					$('#desde').attr("value", desde);
					$('#hasta').attr("value", hasta);
					
			}
			
			function NuevoCronogramaModal(){
				
				$('#nuevoCronograma').dialog('option', "buttons", [
				{
					text: "Crear",
					click: function() { 
									if(!$(".formError").length){					
											$.post("nuevoCronograma.php",{horario: $('#selectHorarioNuevo').val(), empleado: $('#selectEmpleadoNuevo').val(), desde: $('#desdeNuevo').val(), hasta: $('#hastaNuevo').val()},
										   
										   function(data){
												window.location.href='cronograma.php?saveModified='+data;
												//alert (data);
										   	}
											);
										}
									  }
				},
				{
					text: "Cancelar",
					click: function() { $('#nuevoCronograma').dialog('close'); 
										$(".formError").remove();}
				}
				]);
				$('#nuevoCronograma').dialog('open');
			}
			
			$(function() {
				var dates = $( "#desde, #hasta" ).datepicker({
					dateFormat:'yy/mm/dd',
					defaultDate: "+1w",
					changeMonth: true,
					dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
					monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo',
                    'Junio', 'Julio', 'Agosto', 'Septiembre',
                    'Octubre', 'Noviembre', 'Diciembre'],
					monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr',
                    'May', 'Jun', 'Jul', 'Ago',
                    'Sep', 'Oct', 'Nov', 'Dic'],
					currentText: 'Fecha actual',
					closeText: 'Listo',
					numberOfMonths: 3,
					onSelect: function( selectedDate ) {
						var option = this.id == "desde" ? "minDate" : "maxDate",
							instance = $( this ).data( "datepicker" ),
							date = $.datepicker.parseDate(
								instance.settings.dateFormat ||
								$.datepicker._defaults.dateFormat,
								selectedDate, instance.settings );
						dates.not( this ).datepicker( "option", option, date );
					}
				});
			});
			
			$(function() {
				var dates = $( "#desdeNuevo, #hastaNuevo" ).datepicker({
					dateFormat:'yy/mm/dd',
					defaultDate: "+1w",
					changeMonth: true,
					dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
					monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo',
                    'Junio', 'Julio', 'Agosto', 'Septiembre',
                    'Octubre', 'Noviembre', 'Diciembre'],
					monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr',
                    'May', 'Jun', 'Jul', 'Ago',
                    'Sep', 'Oct', 'Nov', 'Dic'],
					currentText: 'Fecha actual',
					closeText: 'Listo',
					numberOfMonths: 3,
					onSelect: function( selectedDate ) {
						var option = this.id == "desdeNuevo" ? "minDate" : "maxDate",
							instance = $( this ).data( "datepicker" ),
							date = $.datepicker.parseDate(
								instance.settings.dateFormat ||
								$.datepicker._defaults.dateFormat,
								selectedDate, instance.settings );
						dates.not( this ).datepicker( "option", option, date );
					}
				});
			});
			
		</script>
	</head>
	<body id="dt_example" onload="javascript:desabilitarMenusTabla(<?php echo $obtener_permisos;?>)">
    
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
		<span class="Titulos">Cronogramas</span>
		<div id="container">
			<div id="demo">
			<input name="Nuevo" type="button" onclick="javascript:NuevoCronogramaModal()" value="Nuevo Cronograma">&nbsp;
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Horario</th>
							<th>Empleado</th>
							<th>Desde</th>
							<th>Hasta</th>
							<th>Opciones</th>
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
					$consulta = "select eh.CODIGO_EMPLEADOHORARIO, eh.CODIGO_HORARIO, h.NOMBRE_HORARIO, e.CODIGO_EMPLEADO, e.NOMBRE_EMPLEADO, eh.DESDE_EMPLEADOHORARIO, eh.HASTA_EMPLEADOHORARIO ".
								"from	empleadohorario eh, horario h, empleado e ".
								"where	eh.CODIGO_HORARIO = h.CODIGO_HORARIO ".
								"and	eh.CODIGO_EMPLEADO = e.CODIGO_EMPLEADO ".
								"and	e.ESTADO_EMPLEADO in (1,0) ";
					
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
		                            <td class="center">
										<a href="javascript:EliminarCronogramaModal(<?php echo $row["CODIGO_EMPLEADOHORARIO"]; ?>);">
											<img src="ribbon/images/1323286140_user_delete.png" alt="Borrar" />
										</a>&nbsp;
										<a href="javascript:ModificarCronogramaModal(<?php echo $row["CODIGO_EMPLEADOHORARIO"].",'".$row["CODIGO_HORARIO"]."','".$row["CODIGO_EMPLEADO"]."','".$row["DESDE_EMPLEADOHORARIO"]."','".$row["HASTA_EMPLEADOHORARIO"]."'"; ?>);">
											<img src="ribbon/images/1323286136_user_edit.png" alt="Editar" />
										</a>
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
						echo "mostrarerroregajosoderecha('".($conexion->error)."');";
						echo "</script>";
						exit();
					}
                    ?>
                    </tbody>
                    <tfoot>
                        <tr>
                      		<th>Codigo</th>
                            <th>Horario</th>
							<th>Empleado</th>
							<th>Desde</th>
							<th>Hasta</th>
							<th>Opciones</th>
                        </tr>
                    </tfoot>
                </table>
			</div>
		</div>
        
        
        <div id="eliminarCronograma" title="Eliminar Cronograma?">
			<p><span class="ui-icon ui-icon-trash" style="float:left; margin:0 7px 20px 0;"></span>Esta seguro que desea eliminar este registro?</p>
		</div>
    <div id="modificaCronograma" title="Modificar Cronograma">
		<form id="formCronograma" method="post" action="">
			<table>
				<tr height="40px">
					<td>
						Horario(*):
					</td>
					<td>
					<select id ="selectHorario">
					<?php 
						$conexion = new mysqli($hostname,$username,$password,$database);
						$consulta = 'SELECT `CODIGO_HORARIO` , `NOMBRE_HORARIO` FROM `horario`;';
						if ($result = $conexion->query($consulta)) {
								if($result->num_rows > 0)
								{
									while ($row = $result->fetch_assoc()) {
										echo "<option id='opt_".$row["CODIGO_HORARIO"]."' value='".$row["CODIGO_HORARIO"]."'>".$row["NOMBRE_HORARIO"]."</option>";
									}
									$result->close();
									$conexion->close();
								}		
								else{
									$result->close();
									$conexion->close();
								}
						}
					?>
					  </select> 
					</td>
				</tr>
				<tr height="40px">
					<td>
						Empleado(*):
					</td>
					<td>
					<select id ="selectEmpleado">
					<?php 
						$conexion = new mysqli($hostname,$username,$password,$database);
						$consulta = 'SELECT `CODIGO_EMPLEADO` , `NOMBRE_EMPLEADO` FROM `empleado`;';
						if ($result = $conexion->query($consulta)) {
								if($result->num_rows > 0)
								{
									while ($row = $result->fetch_assoc()) {
										echo "<option id='opt_".$row["CODIGO_EMPLEADO"]."' value='".$row["CODIGO_EMPLEADO"]."'>".$row["NOMBRE_EMPLEADO"]."</option>";
									}
									$result->close();
									$conexion->close();
								}		
								else{
									$result->close();
									$conexion->close();
								}
						}
					?>
					  </select> 
					</td>
				</tr>
				<tr height="40px">
					<td>
						Desde(*):
					</td>
					<td>
						<input type="text" id="desde" name="desde"/>
					</td>
				</tr>
				<tr height="40px">
					<td>
						Hasta(*):
					</td>
					<td>
						<input type="text" id="hasta" name="hasta"/>
					</td>
				</tr>
			</table>
		</form>
	</div>
	
	<div id="nuevoCronograma" title="Nuevo Cronograma">
		<form id="formNuevoCronograma" method="post" action="">
			<table>
				<tr height="40px">
					<td>
						Horario(*):
					</td>
					<td>
					<select id ="selectHorarioNuevo">
					<?php 
						$conexion = new mysqli($hostname,$username,$password,$database);
						$consulta = 'SELECT `CODIGO_HORARIO` , `NOMBRE_HORARIO` FROM `horario`;';
						if ($result = $conexion->query($consulta)) {
								if($result->num_rows > 0)
								{
									while ($row = $result->fetch_assoc()) {
										echo "<option id='opt_".$row["CODIGO_HORARIO"]."' value='".$row["CODIGO_HORARIO"]."'>".$row["NOMBRE_HORARIO"]."</option>";
									}
									$result->close();
									$conexion->close();
								}		
								else{
									$result->close();
									$conexion->close();
								}
						}
					?>
					  </select> 
					</td>
				</tr>
				<tr height="40px">
					<td>
						Empleado(*):
					</td>
					<td>
					<select id ="selectEmpleadoNuevo">
					<?php 
						$conexion = new mysqli($hostname,$username,$password,$database);
						$consulta = 'SELECT `CODIGO_EMPLEADO` , `NOMBRE_EMPLEADO` FROM `empleado`;';
						if ($result = $conexion->query($consulta)) {
								if($result->num_rows > 0)
								{
									while ($row = $result->fetch_assoc()) {
										echo "<option id='opt_".$row["CODIGO_EMPLEADO"]."' value='".$row["CODIGO_EMPLEADO"]."'>".$row["NOMBRE_EMPLEADO"]."</option>";
									}
									$result->close();
									$conexion->close();
								}		
								else{
									$result->close();
									$conexion->close();
								}
						}
					?>
					  </select> 
					</td>
				</tr>
				<tr height="40px">
					<td>
						Desde(*):
					</td>
					<td>
						<input type="text" id="desdeNuevo" name="desdeNuevo"/>
					</td>
				</tr>
				<tr height="40px">
					<td>
						Hasta(*):
					</td>
					<td>
						<input type="text" id="hastaNuevo" name="hastaNuevo"/>
					</td>
				</tr>
			</table>
		</form>
	</div>
	
	</body>
</html>