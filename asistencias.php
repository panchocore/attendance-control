<?php
	require_once("comun/compruebasesion.php");
	if($sesion->get("ModificarAsistencia"))
		$obtener_permisos = $sesion->get("ModificarAsistencia");
	else 
		$obtener_permisos = 0;
	
	if($obtener_permisos == 0)
		header("Location: finsesion.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		
		<title>Modificar Asistencia</title>
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
		<script type="text/javascript" src="scripts/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" src="scripts/combobox.js"></script>
		<script type="text/javascript" src="scripts/permisos.js"></script>
		<script type="text/javascript" charset="utf-8">
		
		
		$(function() {
			
			$( "input:submit, input:button" ).button();
			
			$( "#radioIngresoSalida" ).buttonset();
				
			$( "#selectEmpleado" ).combobox();
			$( "#selectHorario" ).combobox();
			$( "#comboSelecionaEmpleado" ).combobox();
			
			
			$( "#toggle" ).click(function() {
				$( "#selectEmpleado" ).toggle();
				$( "#selectHorario" ).toggle();
				$( "#comboSelecionaEmpleado" ).toggle();
			});
		
			$( "#dialog:ui-dialog" ).dialog( "destroy" );
   		
		
   			$("#eliminarAsistencia").dialog({
					autoOpen: false,
					bgiframe: true,
					resizable: false,
					height:160,
					modal: true,
					overlay: {
						backgroundColor: '#000',
						opacity: 0.5
					}
				});
			
			$( "#modificaasistencia" ).dialog({
   				autoOpen: false,
					bgiframe: true,
					resizable: false,
					height:340,
					width:320,
					modal: true,
					overlay: {
						backgroundColor: '#000',
						opacity: 0.5
					}
   			});
			
			$('#horaAsistencia').timepicker({
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
			$('#FechaAsistencia').datepicker({
				dateFormat:'yy-mm-dd',
				changeMonth: true,
				changeYear: true,
				dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo',
                    'Junio', 'Julio', 'Agosto', 'Septiembre',
                    'Octubre', 'Noviembre', 'Diciembre'],
                monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr',
                    'May', 'Jun', 'Jul', 'Ago',
                    'Sep', 'Oct', 'Nov', 'Dic'],
                showButtonPanel: true,
                currentText: 'Fecha actual',
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
				
				$("#formAsistencia").validationEngine('attach');
				
			} );
			
			function EliminarAsistenciaModal(asistenciaEliminar,filtrarRegistros){
					$('#eliminarAsistencia').dialog('option', "buttons", [
					{
						text: "Eliminar",
						click: function() { $.post("eliminarRegistro.php",{ Id: asistenciaEliminar, Estado: 2, Tabla: 'registros' },
											   function(data){
												 //location.reload();
												 //$('#dt_example').html(data);
												window.location.href='asistencias.php?saveModified='+data+'&filtrarRegistros='+filtrarRegistros;
											   }
											);
										    //$('#eliminarUsuario').dialog('close'); 
											
										  }
					},
					{
						text: "Cancelar",
						click: function() { $('#eliminarAsistencia').dialog('close'); }
					}
					]);
					$('#eliminarAsistencia').dialog('open');
			}
			
			function ModificarAsistenciaModal(hora,fecha,codigoEmpleado,empleadoAsistencia,CodigoHorario,entradaSalida,filtrarRegistros){
					
					$('#modificaasistencia').dialog('option', "buttons", [
					{
						text: "Modificar",
						click: function() { 
										if(!$(".formError").length){					
											$.post("modificarAsistencia.php",{ codigoEmpleado: codigoEmpleado,hora: hora, fecha: fecha,codigoEmpleadonuevo: $('#selectEmpleado').val(),horanueva: $('#horaAsistencia').val(), fechanueva: $('#FechaAsistencia').val(),codHorario: $('#selectHorario').val(),EntradaSalida: $("input:radio:checked[name=|'radio']").val()},
											   function(data){
												 	window.location.href='asistencias.php?saveModified='+data+'&filtrarRegistros='+filtrarRegistros;
											   	}
												);
										  }
										 }
							
					},
					{
						text: "Cancelar",
						click: function() { $('#modificaasistencia').dialog('close'); 
											$(".formError").remove();}
					}
					]);
					$('#modificaasistencia').dialog('open');
					//$('.ui-datepicker').dialog('close');
					//$(".ui-datepicker").css("display", "none"); 
					$('#horaAsistencia').attr("value", hora);
					$('#FechaAsistencia').attr("value", fecha);
					$('#empleadoAsistencia').attr("value", empleadoAsistencia);
					//alert($('#opt_emp_'+codigoEmpleado).val());
					//$('#opt_emp_'+codigoEmpleado).attr("selected", "selected");
					id = '#selectEmpleado';
					$(id).val(codigoEmpleado);
					$(id).next().val($(id + " :selected").text());

					idHorario = '#selectHorario';
					$(idHorario).val(CodigoHorario);
					$(idHorario).next().val($(idHorario + " :selected").text());
					if(entradaSalida == 1)
					{	
						$('#radio1').click();
					}
					else
					{
						$('#radio2').click();
					}
					
			}

				
			
			function ModificarEstadoAsistenciaModal(asistenciaModificar, NuevoEstado,filtrarRegistros){
				
				//$.post("modificarEstadoUsuario.php",{ usuarioModifica: usuarioaModificar,EstadoUsuario: NuevoEstado},
				$.post("modificarEstado.php",{ Id: asistenciaModificar, Estado: NuevoEstado, Tabla: 'registros'},
						   function(data){
									window.location.href='asistencias.php?saveModified='+data+'&filtrarRegistros='+filtrarRegistros;
								   	}
						);
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
		<span class="Titulos">Modificar asistencia</span>
		<div id="container">
			<div id="demo">
			<form  id="formEmpleados" method="post" action="asistencias.php">
				<table>
					<tr height="40px">
			            <td>
			            	Empleado:
						</td>
						<td>
			            <select id ="comboSelecionaEmpleado" name="comboSelecionaEmpleado">
			            	<option id='opt_sel_default' value='-1'><span style='font-size:9pt;'>Mostrar todos</span></option>
			            <?php 
			            require_once("conexion/conexion.php");
							$conexion = new mysqli($hostname,$username,$password,$database);
							$consulta = 'SELECT `NOMBRE_EMPLEADO` , `CODIGO_EMPLEADO`
										FROM empleado
										WHERE `ESTADO_EMPLEADO` = 1;';
							if ($result = $conexion->query($consulta)) {
								    if($result->num_rows > 0)
									{
										while ($row = $result->fetch_assoc()) {
											echo "<option id='opt_sel_".$row["CODIGO_EMPLEADO"]."' value='".$row["CODIGO_EMPLEADO"]."'><span style='font-size:9pt;'>".$row["NOMBRE_EMPLEADO"]."</span></option>";
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
						<td>
							<input name="SeleccionaEmpleado" type="submit" id="SeleccionaEmpleado" value="Filtrar tabla">
						</td>
					</tr>
					
				</table>
			</form>
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
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    <?php 
					$conexion = new mysqli($hostname,$username,$password,$database);
					/* check connection */
					if ($conexion->connect_errno) {
						echo "<script type='text/javascript'>";
						echo "mostrarerroregajosoderecha('"."Connect failed: %s\n".$conexion->connect_error."');";
						echo "</script>";
					    //echo "Connect failed: %s\n".$conexion->connect_error;
					    exit();
					}
					
					if($_POST['comboSelecionaEmpleado'])
						$empleadoFiltrar=$_POST['comboSelecionaEmpleado'];
					else if  ($_GET["filtrarRegistros"])
						$empleadoFiltrar=$_GET["filtrarRegistros"];
					else 
						$empleadoFiltrar = -1;
					if($empleadoFiltrar == -1)
					{
						$consulta = "SELECT `HORA_REGISTRO` , `FECHA_REGISTRO` , registros.`CODIGO_EMPLEADO` , 
						registros.`CODIGO_HORARIO` , `ESTADO_REGISTRO` , `INOUT_REGISTRO` , `NOMBRE_EMPLEADO`,
						`NOMBRE_HORARIO` 
										FROM registros
										JOIN empleado ON empleado.`ID_EMPLEADO` = registros.`CODIGO_EMPLEADO` 
										LEFT JOIN horario ON horario.`CODIGO_HORARIO` = registros.`CODIGO_HORARIO`
										where `ESTADO_REGISTRO` in (0,1)
										order by `FECHA_REGISTRO` asc ";
					}						
					else
					{		
							$consulta = "SELECT `HORA_REGISTRO` , `FECHA_REGISTRO` , registros.`CODIGO_EMPLEADO` , 
						registros.`CODIGO_HORARIO` , `ESTADO_REGISTRO` , `INOUT_REGISTRO` , `NOMBRE_EMPLEADO`,
						`NOMBRE_HORARIO` 
										FROM registros
										JOIN empleado ON Empleado.`ID_EMPLEADO` = registros.`CODIGO_EMPLEADO` 
										LEFT JOIN Horario ON Horario.`CODIGO_HORARIO` = registros.`CODIGO_HORARIO`
										where `ESTADO_REGISTRO` in (0,1) and Empleado.`CODIGO_EMPLEADO` = ".$empleadoFiltrar."
										 order by `FECHA_REGISTRO` asc ";
					}
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
		                            	<a href="javascript:ModificarEstadoAsistenciaModal('<?php echo $row["HORA_REGISTRO"].
															'|'.$row["FECHA_REGISTRO"] .'|' . $row["CODIGO_EMPLEADO"]; ?>',0,'<?php if($empleadoFiltrar) {echo $empleadoFiltrar;} else{ echo "-1";}?>')">
											<img src="ribbon/images/1323286599_status.png" alt="activo" /></a>
		                            	<?php 
		                            	}
		                            	else{
		                            	?>
		                            	<a href="javascript:ModificarEstadoAsistenciaModal('<?php echo $row["HORA_REGISTRO"].
															'|'.$row["FECHA_REGISTRO"] .'|' . $row["CODIGO_EMPLEADO"]; ?>',1,'<?php if($empleadoFiltrar) {echo $empleadoFiltrar;} else{ echo "-1";}?>')"><img src="ribbon/images/1323286606_status-offline.png" alt="inactivo" /></a>
		                            	<?php 
		                            	}
		                            	?>
		                            </td>
		                            <td class="center">
		                            	<?php if ($row["INOUT_REGISTRO"] == 1)
		                            	{
		                            	?>
		                            	<img src="ribbon/images/1325007896_sign-in.png" alt="IN" />
		                            	<?php 
		                            	}
		                            	else{
		                            	?>
		                            	<img src="ribbon/images/1325007903_sign-out.png" alt="OUT" />
		                            	<?php 
		                            	}
		                            	?>
		                            </td>
		                            <td class="center"><a href="javascript:EliminarAsistenciaModal('<?php echo $row["HORA_REGISTRO"].
															'|'.$row["FECHA_REGISTRO"] .'|' . $row["CODIGO_EMPLEADO"]; ?>','<?php if($empleadoFiltrar) {echo $empleadoFiltrar;} else{ echo "-1";}?>');"><img src="ribbon/images/1323286140_user_delete.png" alt="Borrar" /></a>
		                            &nbsp;<a href="javascript:ModificarAsistenciaModal(
									<?php echo "'".$row["HORA_REGISTRO"]."','".$row["FECHA_REGISTRO"]."',".$row["CODIGO_EMPLEADO"].",'".$row["NOMBRE_EMPLEADO"]."',".
									$row["CODIGO_HORARIO"].",".$row["INOUT_REGISTRO"]; ?>,'<?php if($empleadoFiltrar) {echo $empleadoFiltrar;} else{ echo "-1";}?>');"><img src="ribbon/images/1323286136_user_edit.png" alt="Editar" /></a>
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
                      		<th>Fecha</th>
                            <th>Hora</th>
                            <th>Empleado</th>
                            <th>Horario</th>
                            <th>Estado</th>
                            <th>Entrada/Salida</th>
                            <th>Opciones</th>
                        </tr>
                    </tfoot>
                </table>
			</div>
		</div>
        
        
        <div id="eliminarAsistencia" title="Eliminar Asistencia?">
			<p><span class="ui-icon ui-icon-trash" style="float:left; margin:0 7px 20px 0;"></span>Esta seguro que desea eliminar este registro de asistencia?</p>
		</div>
    
    <div id="modificaasistencia" title="Modificar Asistencia">
    <form id="formAsistencia" method="post" action="">
		<table>
		
		
		<tr height="40px">
	   		<td>
            	Empleado(*):
			</td>
			<td>
           		<input type="text" class="validate[required]" disabled value= "false" style="width:180px" name="empleadoAsistencia" id="empleadoAsistencia"/>
			</td>
        </tr>
		<tr height="40px">
	   		<td>
            	Hora(*):
			</td>
			<td>
           		<input type="text" class="validate[required]" disabled value= "false" style="width:180px" name="horaAsistencia" id="horaAsistencia"/>
			</td>
        </tr>
        <tr height="40px">
	   		<td>
            	Fecha(*):
			</td>
			<td>
           		<input type="text" class="validate[required]" disabled value= "false" style="width:180px" name="FechaAsistencia" id="FechaAsistencia"/>
			</td>
        </tr>
        <tr height="40px">
            <td>
            	Horario(*):
			</td>
			<td>
            <select id ="selectHorario" >
            <?php 
				$conexion = new mysqli($hostname,$username,$password,$database);
				$consulta = 'SELECT `NOMBRE_HORARIO` , `CODIGO_HORARIO`
							FROM Horario';
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
        <tr height="50px">
	   		<td>
            	Entrada/Salida(*):
			</td>
            <td>
            <div id="radioIngresoSalida">
				<input type="radio" id="radio1" name="radio" value="1" /><label for="radio1" >Entrada&nbsp;&nbsp;&nbsp;<img src="ribbon/images/1325007896_sign-in.png" alt="IN" /></label>
				<input type="radio" id="radio2" name="radio" value="0" /><label for="radio2" >Salida&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="ribbon/images/1325007903_sign-out.png" alt="OUT" /></label>
			</div>
			</td>
        </tr>
    </table>
    </form>
	</div>
       
    </body>
</html>