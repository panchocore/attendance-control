<?php
	require_once("comun/compruebasesion.php");
	
	$usuario = $sesion->get("nombreusuario");
	if($sesion->get("Permisos"))
		$obtener_permisos = $sesion->get("Permisos");
	else 
		$obtener_permisos = 0;
	
	if($obtener_permisos == 0)
		header("Location: finsesion.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		
		<title>Permisos</title>
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
		<script type="text/javascript" src="scripts/jquery-ui-timepicker-addon.js"></script>
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
			
			$( "#selectEmpleadoNuevo" ).combobox();
			$( "#toggle" ).click(function() {
				$( "#selectEmpleadoNuevo" ).toggle();
			});
		
   			$("#eliminarPermiso").dialog({
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
			
			$( "#modificaPermiso" ).dialog({
   				autoOpen: false,
					bgiframe: true,
					resizable: false,
					height:360,
					modal: true,
					overlay: {
						backgroundColor: '#000',
						opacity: 0.5
					}
   			});
			
			$( "#nuevoPermiso" ).dialog({
   				autoOpen: false,
					bgiframe: true,
					resizable: false,
					height:360,
					modal: true,
					overlay: {
						backgroundColor: '#000',
						opacity: 0.5
					}
   			});
			
			$(function() {
				var dates = $( "#fechaInicio, #fechaFin" ).datepicker({
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
				var dates = $( "#fechaInicioNuevo, #fechaFinNuevo" ).datepicker({
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
			
			$('#horaInicio').timepicker({
				hourGrid: 4,
				minuteGrid: 10,
				timeOnlyTitle: 'Seleccione la hora',
				timeText: 'Hora/Minutos : ',
				hourText: 'Hora',
				minuteText: 'Minutos',
				secondText: 'Segundos',
				showSecond: true,
				timeFormat: 'hh:mm:ss',
				currentText: 'Hora actual',
				closeText: 'Listo'
				});
			$('#horaFin').timepicker({
				hourGrid: 4,
				minuteGrid: 10,
				timeOnlyTitle: 'Seleccione la hora',
				timeText: 'Hora/Minutos : ',
				hourText: 'Hora',
				minuteText: 'Minutos',
				secondText: 'Segundos',
				showSecond: true,
				timeFormat: 'hh:mm:ss',
				currentText: 'Hora actual',
				closeText: 'Listo'
				});
			$('#horaInicioNuevo').timepicker({
				hourGrid: 4,
				minuteGrid: 10,
				timeOnlyTitle: 'Seleccione la hora',
				timeText: 'Hora/Minutos : ',
				hourText: 'Hora',
				minuteText: 'Minutos',
				secondText: 'Segundos',
				showSecond: true,
				timeFormat: 'hh:mm:ss',
				currentText: 'Hora actual',
				closeText: 'Listo'
				});
			$('#horaFinNuevo').timepicker({
				hourGrid: 4,
				minuteGrid: 10,
				timeOnlyTitle: 'Seleccione la hora',
				timeText: 'Hora/Minutos : ',
				hourText: 'Hora',
				minuteText: 'Minutos',
				secondText: 'Segundos',
				showSecond: true,
				timeFormat: 'hh:mm:ss',
				currentText: 'Hora actual',
				closeText: 'Listo'
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
				
				$("#formArea").validationEngine('attach');
				$("#formnuevoPermiso").validationEngine('attach');
			} );
			
			function EliminarPermisoModal(permisoaEliminar){
					$('#eliminarPermiso').dialog('option', "buttons", [
					{
						text: "Eliminar",
						click: function() { $.post("eliminarRegistro.php",{ Id: permisoaEliminar, Estado: 2, Tabla: 'permiso' },
											   function(data){
												 //location.reload();
												 //$('#dt_example').html(data);
												window.location.href='permisos.php?saveModified='+data;
											   }
											);
										    //$('#eliminarUsuario').dialog('close'); 
											
										  }
					},
					{
						text: "Cancelar",
						click: function() { $('#eliminarPermiso').dialog('close'); }
					}
					]);
					$('#eliminarPermiso').dialog('open');
			}
			
			function ModificarPermisoModal(permisoaModificar,descripcion,empleado,fechaInicio,fechaFin, horaInicio,horaFin){
					$('#modificaPermiso').dialog('option', "buttons", [
					{
						text: "Modificar",
						click: function() { 
										if(!$(".formError").length){					
												$.post("modificarPermiso.php",{ codigo: permisoaModificar, descripcion: $('#descripcion').val(), empleado: $('#selectEmpleado').val(), fechaInicio: $('#fechaInicio').val(), fechaFin: $('#fechaFin').val(), horaInicio: $('#horaInicio').val(), horaFin: $('#horaFin').val()},
											   function(data){
												 	//location.reload();
													window.location.href='permisos.php?saveModified='+data;
											   	}
												);
										    	//$('#modificausuario').dialog('close'); 
												//MuestraMensajeGuardadoCorrectoPegajoso('Se han guardado los cambios correctamente!');
											}
										  }
					},
					{
						text: "Cancelar",
						click: function() { $('#modificaPermiso').dialog('close'); 
											$(".formError").remove();}
					}
					]);
					$('#modificaPermiso').dialog('open');
					
					$('#descripcion').attr("value", descripcion);
					
					id = '#selectEmpleado';
					$(id).val(empleado);
					$(id).next().val($(id + " :selected").text());
					
					$('#fechaInicio').attr("value", fechaInicio);
					$('#fechaFin').attr("value", fechaFin);
					$('#horaInicio').attr("value", horaInicio);
					$('#horaFin').attr("value", horaFin);
					
			}
			
			function nuevoPermisoModal(){
				
				$('#nuevoPermiso').dialog('option', "buttons", [
				{
					text: "Crear",
					click: function() { 
									if(!$(".formError").length){					
											$.post("nuevoPermiso.php",{empleado: $('#selectEmpleadoNuevo').val(), descripcion: $('#descripcionNuevo').val(), fechainicio: $('#fechaInicioNuevo').val(), fechafin: $('#fechaFinNuevo').val(), horainicio: $('#horaInicioNuevo').val(), horafin: $('#horaFinNuevo').val()},
										   function(data){
											 	//location.reload();
												window.location.href='Permisos.php?saveModified='+data;
										   	}
											);
									    	//$('#modificausuario').dialog('close'); 
											//MuestraMensajeGuardadoCorrectoPegajoso('Se han guardado los cambios correctamente!');
										}
									  }
				},
				{
					text: "Cancelar",
					click: function() { $('#nuevoPermiso').dialog('close'); 
										$(".formError").remove();}
				}
				]);
				$('#nuevoPermiso').dialog('open');
			}
			
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
		<span class="Titulos">Permisos</span>
		<div id="container">
			<div id="demo">
			<input name="Nuevo" type="button" onclick="javascript:nuevoPermisoModal()" value="Nuevo Permiso">&nbsp;
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>
							<th>Codigo</th>
							<th>Descripcion</th>
							<th>Empleado</th>
							<th>Fecha Inicio</th>
							<th>Fecha Fin</th>
							<th>Hora Inicio</th>
							<th>Hora Fin</th>
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
					$consulta = "select p.CODIGO_PERMISO, e.CODIGO_EMPLEADO, e.NOMBRE_EMPLEADO, p.DESCRIPCION, p.FECHA_INICIO, p.FECHA_FIN, p.HORA_INICIO, p.HORA_FIN ".
								"from	permiso p , empleado e ".
								"where	p.CODIGO_EMPLEADO = e.CODIGO_EMPLEADO ";
					
					if ($result = $conexion->query($consulta)) {
					    if($result->num_rows > 0)
						{
							while ($row = $result->fetch_assoc()) {
								?>
								    <td><?php echo $row["CODIGO_PERMISO"];?></td>
		                            <td><?php echo $row["DESCRIPCION"];?></td>
									<td><?php echo $row["NOMBRE_EMPLEADO"];?></td>
									<td><?php echo $row["FECHA_INICIO"];?></td>
									<td><?php echo $row["FECHA_FIN"];?></td>
									<td><?php echo $row["HORA_INICIO"];?></td>
									<td><?php echo $row["HORA_FIN"];?></td>
		                            <td class="center">
										<a href="javascript:EliminarPermisoModal(<?php echo $row["CODIGO_PERMISO"]; ?>);">
											<img src="ribbon/images/1323286140_user_delete.png" alt="Borrar" />
										</a>&nbsp;
										<a href="javascript:ModificarPermisoModal(<?php echo $row["CODIGO_PERMISO"].",'".$row["DESCRIPCION"]."','".$row["CODIGO_EMPLEADO"]."','".$row["FECHA_INICIO"]."','".$row["FECHA_FIN"]."','".$row["HORA_INICIO"]."','".$row["HORA_FIN"]."'"; ?>);">
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
							<th>Descripcion</th>
							<th>Empleado</th>
							<th>Fecha Inicio</th>
							<th>Fecha Fin</th>
							<th>Hora Inicio</th>
							<th>Hora Fin</th>
							<th>Opciones</th>
                        </tr>
                    </tfoot>
                </table>
			</div>
		</div>
        
        
        <div id="eliminarPermiso" title="Eliminar Permiso?">
			<p><span class="ui-icon ui-icon-trash" style="float:left; margin:0 7px 20px 0;"></span>Esta seguro que desea eliminar este registro?</p>
		</div>
    <div id="modificaPermiso" title="Modificar Permiso">
		<form id="formPermiso" method="post" action="">
			<table>
				<tr height="40px">
					<td>
						Descripcion:
					</td>
					<td>
						<input type="text" class="validate[required]" style="width:180px" name="descripcion" id="descripcion"/>
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
						Fecha Inicio:
					</td>
					<td>
						<input type="text" class="validate[required]" style="width:180px" name="fechaInicio" id="fechaInicio"/>
					</td>
				</tr>
				<tr height="40px">
					<td>
						Fecha Fin:
					</td>
					<td>
						<input type="text" class="validate[required]" style="width:180px" name="fechaFin" id="fechaFin"/>
					</td>
				</tr>
				<tr height="40px">
					<td>
						Hora Inicio:
					</td>
					<td>
						<input type="text" class="validate[required]" style="width:180px" name="horaInicio" id="horaInicio"/>
					</td>
				</tr>
				<tr height="40px">
					<td>
						Hora Fin:
					</td>
					<td>
						<input type="text" class="validate[required]" style="width:180px" name="horaFin" id="horaFin"/>
					</td>
				</tr>
				
			</table>
		</form>
	</div>
	
	<div id="nuevoPermiso" title="Nuevo Permiso">
		<form id="formnuevoPermiso" method="post" action="">
			<table>
				<tr height="40px">
					<td>
						Descripcion:
					</td>
					<td>
						<input type="text" class="validate[required]" style="width:180px" name="descripcionNuevo" id="descripcionNuevo"/>
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
						Fecha Inicio:
					</td>
					<td>
						<input type="text" class="validate[required]" style="width:180px" name="fechaInicioNuevo" id="fechaInicioNuevo"/>
					</td>
				</tr>
				<tr height="40px">
					<td>
						Fecha Fin:
					</td>
					<td>
						<input type="text" class="validate[required]" style="width:180px" name="fechaFinNuevo" id="fechaFinNuevo"/>
					</td>
				</tr>
				<tr height="40px">
					<td>
						Hora Inicio:
					</td>
					<td>
						<input type="text" class="validate[required]" style="width:180px" name="horaInicioNuevo" id="horaInicioNuevo"/>
					</td>
				</tr>
				<tr height="40px">
					<td>
						Hora Fin:
					</td>
					<td>
						<input type="text" class="validate[required]" style="width:180px" name="horaFinNuevo" id="horaFinNuevo"/>
					</td>
				</tr>
			</table>
		</form>
	</div>
	</body>
</html>