<?php
	require_once("comun/compruebasesion.php");
	
	$usuario = $sesion->get("nombreusuario");
	if($sesion->get("Feriados"))
		$obtener_permisos = $sesion->get("Feriados");
	else 
		$obtener_permisos = 0;
	
	if($obtener_permisos == 0)
		header("Location: finsesion.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		
		<title>Feriados</title>
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
			
			$( "#selectEmpleadoNuevo" ).combobox();
			$( "#toggle" ).click(function() {
				$( "#selectEmpleadoNuevo" ).toggle();
			});
			
			$(function() {
				var dates = $( "#fechaInicio, #fechaFin" ).datepicker({
					dateFormat:'yy/mm/dd',
					defaultDate: "-1w",
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
					defaultDate: "-1w",
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
		
   			$("#eliminarFeriado").dialog({
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
			
			$( "#modificaFeriado" ).dialog({
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
			
			$( "#nuevoFeriado" ).dialog({
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
				$("#formnuevoFeriado").validationEngine('attach');
			} );
			
			function EliminarFeriadoModal(feriadoaEliminar){
					$('#eliminarFeriado').dialog('option', "buttons", [
					{
						text: "Eliminar",
						click: function() { $.post("eliminarRegistro.php",{ Id: feriadoaEliminar, Estado: 2, Tabla: 'feriado' },
											   function(data){
												 //location.reload();
												 //$('#dt_example').html(data);
												window.location.href='feriados.php?saveModified='+data;
											   }
											);
										    //$('#eliminarUsuario').dialog('close'); 
											
										  }
					},
					{
						text: "Cancelar",
						click: function() { $('#eliminarFeriado').dialog('close'); }
					}
					]);
					$('#eliminarFeriado').dialog('open');
			}
			
			function ModificarFeriadoModal(feriadoaModificar,nombre,fechaInicio,fechaFin){
					$('#modificaFeriado').dialog('option', "buttons", [
					{
						text: "Modificar",
						click: function() { 
										if(!$(".formError").length){					
												$.post("modificarFeriado.php",{ codigo: feriadoaModificar, nombre: $('#nombre').val(), fechaInicio: $('#fechaInicio').val(), fechaFin: $('#fechaFin').val()},
											   function(data){
												 	//location.reload();
													window.location.href='feriados.php?saveModified='+data;
											   	}
												);
										    	//$('#modificausuario').dialog('close'); 
												//MuestraMensajeGuardadoCorrectoPegajoso('Se han guardado los cambios correctamente!');
											}
										  }
					},
					{
						text: "Cancelar",
						click: function() { $('#modificaFeriado').dialog('close'); 
											$(".formError").remove();}
					}
					]);
					$('#modificaFeriado').dialog('open');
					
					$('#nombre').attr("value", nombre);
					
					$('#fechaInicio').attr("value", fechaInicio);
					$('#fechaFin').attr("value", fechaFin);
			}
			
			function nuevoFeriadoModal(){
				
				$('#nuevoFeriado').dialog('option', "buttons", [
				{
					text: "Crear",
					click: function() { 
									if(!$(".formError").length){					
											$.post("nuevoFeriado.php",{nombre: $('#nombreNuevo').val(), fechainicio: $('#fechaInicioNuevo').val(), fechafin: $('#fechaFinNuevo').val()},
										   function(data){
											 	//location.reload();
												window.location.href='feriados.php?saveModified='+data;
										   	}
											);
									    	//$('#modificausuario').dialog('close'); 
											//MuestraMensajeGuardadoCorrectoPegajoso('Se han guardado los cambios correctamente!');
										}
									  }
				},
				{
					text: "Cancelar",
					click: function() { $('#nuevoFeriado').dialog('close'); 
										$(".formError").remove();}
				}
				]);
				$('#nuevoFeriado').dialog('open');
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
		<span class="Titulos">Feriados</span>
		<div id="container">
			<div id="demo">
			<input name="Nuevo" type="button" onclick="javascript:nuevoFeriadoModal()" value="Nuevo Feriado">&nbsp;
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>
							<th>Codigo</th>
							<th>Nombre</th>
							<th>Fecha Inicio</th>
							<th>Fecha Fin</th>
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
					$consulta = "select f.codigo_feriado, f.nombre, f.fecha_ini, f.fecha_fin ".
								"from	feriado f";
					
					if ($result = $conexion->query($consulta)) {
					    if($result->num_rows > 0)
						{
							while ($row = $result->fetch_assoc()) {
								?>
								    <td><?php echo $row["codigo_feriado"];?></td>
		                            <td><?php echo $row["nombre"];?></td>
									<td><?php echo $row["fecha_ini"];?></td>
									<td><?php echo $row["fecha_fin"];?></td>
		                            <td class="center">
										<a href="javascript:EliminarFeriadoModal(<?php echo $row["codigo_feriado"]; ?>);">
											<img src="ribbon/images/1323286140_user_delete.png" alt="Borrar" />
										</a>&nbsp;
										<a href="javascript:ModificarFeriadoModal(<?php echo $row["codigo_feriado"].",'".$row["nombre"]."','".$row["fecha_ini"]."','".$row["fecha_fin"]."'"; ?>);">
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
                    
                    </tbody>
                    <tfoot>
                        <tr>
							<th>Codigo</th>
							<th>Nombre</th>
							<th>Fecha Inicio</th>
							<th>Fecha Fin</th>
							<th>Opciones</th>
                        </tr>
                    </tfoot>
                </table>
			</div>
		</div>
        
        
        <div id="eliminarFeriado" title="Eliminar Feriado?">
			<p><span class="ui-icon ui-icon-trash" style="float:left; margin:0 7px 20px 0;"></span>Esta seguro que desea eliminar este registro?</p>
		</div>
    <div id="modificaFeriado" title="Modificar Feriado">
		<form id="formFeriado" method="post" action="">
			<table>
				<tr height="40px">
					<td>
						Nombre:
					</td>
					<td>
						<input type="text" class="validate[required]" style="width:180px" name="nombre" id="nombre"/>
					</td>
				</tr>
				
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
				
			</table>
		</form>
	</div>
	
	<div id="nuevoFeriado" title="Nuevo Feriado">
		<form id="formnuevoFeriado" method="post" action="">
			<table>
				<tr height="40px">
					<td>
						Nombre:
					</td>
					<td>
						<input type="text" class="validate[required]" style="width:180px" name="nombreNuevo" id="nombreNuevo"/>
					</td>
				</tr>
				
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
				
			</table>
		</form>
	</div>
	</body>
</html>