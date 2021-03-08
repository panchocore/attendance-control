<?php
	require_once("comun/compruebasesion.php");
	
	$usuario = $sesion->get("nombreusuario");
	if($sesion->get("Horarios"))
		$obtener_permisos = $sesion->get("Horarios");
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
		<script type="text/javascript" src="scripts/permisos.js"></script>
		
		<!--link rel="Stylesheet" media="screen" href="scripts/reset.css" />
        <link rel="Stylesheet" media="screen" href="scripts/ui.timepickr.css" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.js"></script>
		<script type="text/javascript" src="scripts/jquery.ui.all.js"></script>
        <script type="text/javascript" src="scripts/jquery.utils.js"></script>
        <script type="text/javascript" src="scripts/jquery.strings.js"></script>
        <script type="text/javascript" src="scripts/ui.timepickr.js"></script-->
		
		<script type="text/javascript" charset="utf-8">

   		$(function() {

			//$('#horaInicioNueva').timepickr().focus();
			//$('#horaFinNueva').timepickr().focus();

			$( "#dialog:ui-dialog" ).dialog( "destroy" );
			
			$( "input:submit, input:button" ).button();
		
   			$("#eliminarHorario").dialog({
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
			
			$( "#modificaHorario" ).dialog({
   				autoOpen: false,
					bgiframe: true,
					resizable: false,
					height:320,
					width:350,
					modal: true,
					overlay: {
						backgroundColor: '#000',
						opacity: 0.5
					}
   			});
			
			$( "#nuevoHorario" ).dialog({
   				autoOpen: false,
					bgiframe: true,
					resizable: false,
					height:320,
					width:350,
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
				
				$("#formHorario").validationEngine('attach');
				$("#formNuevoHorario").validationEngine('attach');
			} );
			
			function EliminarHorarioModal(registroaEliminar){
					$('#eliminarHorario').dialog('option', "buttons", [
					{
						text: "Eliminar",
						click: function() { $.post("eliminarRegistro.php",{ Id: registroaEliminar, Estado: 2, Tabla: 'horario' },
											   function(data){
												 //location.reload();
												 //$('#dt_example').html(data);
												window.location.href='horarios.php?saveModified='+data;
											   }
											);
										    //$('#eliminarUsuario').dialog('close'); 
											
										  }
					},
					{
						text: "Cancelar",
						click: function() { $('#eliminarHorario').dialog('close'); }
					}
					]);
					$('#eliminarHorario').dialog('open');
			}
			
			function ModificarHorarioModal(registroaModificar,nombre,horaInicio, horaFin, dias){
					$('#modificaHorario').dialog('option', "buttons", [
						{
							text: "Modificar",
							click: function() { 
											if(!$(".formError").length){					
													var diasMod = "";
													if ($('#domingo').attr("checked"))
														diasMod = "1";
													if ($('#lunes').attr("checked"))
														diasMod = diasMod + ",2";
													if ($('#martes').attr("checked"))
														diasMod = diasMod + ",3";
													if ($('#miercoles').attr("checked"))
														diasMod = diasMod + ",4";
													if ($('#jueves').attr("checked"))
														diasMod = diasMod + ",5";
													if ($('#viernes').attr("checked"))
														diasMod = diasMod + ",6";
													if ($('#sabado').attr("checked"))
														diasMod = diasMod + ",7";
													$('#hdnDias').attr("value", diasMod);
													
													$.post("modificarHorario.php",{ codigo: registroaModificar, nombre: $('#nombreHorario').val(), horaInicio: $('#horaInicioH').val()+':'+$('#horaInicioM').val(), horaFin: $('#horaFinH').val()+':'+$('#horaFinM').val(), dias: $('#hdnDias').val()},
												   function(data){
														//location.reload();
														window.location.href='horarios.php?saveModified='+data;
													}
													);
													//$('#modificausuario').dialog('close'); 
													//MuestraMensajeGuardadoCorrectoPegajoso('Se han guardado los cambios correctamente!');
												}
											  }
						},
						{
							text: "Cancelar",
							click: function() { $('#modificaHorario').dialog('close'); 
												$(".formError").remove();}
						}
					]);
					$('#modificaHorario').dialog('open');
					$('#nombreHorario').attr("value", nombre);
					$('#horaInicioH').attr("value", horaInicio.substring(0,2));
					$('#horaInicioM').attr("value", horaInicio.substring(3,5));
					$('#horaFinH').attr("value", horaFin.substring(0,2));
					$('#horaFinM').attr("value", horaFin.substring(3,5));
					$('#hdnDias').attr("value", dias);
					
					$('#domingo').attr("checked",false);
  				    $('#lunes').attr("checked",false);
				    $('#martes').attr("checked",false);
				    $('#miercoles').attr("checked",false);
				    $('#jueves').attr("checked",false);
					$('#viernes').attr("checked",false);
					$('#sabado').attr("checked",false);
							   
					var elem = dias.split(',');
					
					for (i=0; i <= elem.length ; i++ ){
						
						switch (elem[i]) {
							case '1':
							   $('#domingo').attr("checked",true);
							   break;
							case '2':
							   $('#lunes').attr("checked",true);
							   break;
							case '3':
							   $('#martes').attr("checked",true);
							   break;
							case '4':
							   $('#miercoles').attr("checked",true);
							   break;
							case '5':
							   $('#jueves').attr("checked",true);
							   break;
							case '6':
							   $('#viernes').attr("checked",true);
							   break;
							case '7':
							   $('#sabado').attr("checked",true);
							   break;						
						} 
					}
			}
			
			function NuevoHorarioModal(){
				
				$('#nuevoHorario').dialog('option', "buttons", [
				{
					text: "Crear",
					click: function() { 
									if(!$(".formError").length){					
											var diasNew = "";
											if ($('#domingoN').attr("checked"))
												diasNew = "1";
											if ($('#lunesN').attr("checked"))
												diasNew = diasNew + ",2";
											if ($('#martesN').attr("checked"))
												diasNew = diasNew + ",3";
											if ($('#miercolesN').attr("checked"))
												diasNew = diasNew + ",4";
											if ($('#juevesN').attr("checked"))
												diasNew = diasNew + ",5";
											if ($('#viernesN').attr("checked"))
												diasNew = diasNew + ",6";
											if ($('#sabadoN').attr("checked"))
												diasNew = diasNew + ",7";
											$('#hdnDiasN').attr("value", diasNew);
											
											$.post("nuevoHorario.php",{nombre: $('#nombreHorarioNuevo').val(), horaInicio: $('#horaInicioHNueva').val()+':'+$('#horaInicioMNueva').val(), horaFin: $('#horaFinHNueva').val()+':'+$('#horaFinMNueva').val(), dias: $('#hdnDiasN').val()},
										   function(data){
											 	//location.reload();
												window.location.href='horarios.php?saveModified='+data;
										   	}
											);
									    	//$('#modificausuario').dialog('close'); 
											//MuestraMensajeGuardadoCorrectoPegajoso('Se han guardado los cambios correctamente!');
										}
									  }
				},
				{
					text: "Cancelar",
					click: function() { $('#nuevoHorario').dialog('close'); 
										$(".formError").remove();}
				}
				]);
				$('#nuevoHorario').dialog('open');
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
		<span class="Titulos">Horarios</span>
		<div id="container">
			<div id="demo">
			<input name="Nuevo" type="button" onclick="javascript:NuevoHorarioModal()" value="Nuevo Horario">&nbsp;
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Nombre</th>
							<th>Hora Inicio</th>
							<th>Hora Fin</th>
							<th>Dias Laborables</th>
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
					$consulta = "select h.CODIGO_HORARIO, h.NOMBRE_HORARIO, h.HORAINICIO_HORARIO, h.HORAFIN_HORARIO, h.DIAS ".
								"from	horario h ".
								"where  h.codigo_horario != -1";
					
					if ($result = $conexion->query($consulta)) {
					    if($result->num_rows > 0)
						{
							while ($row = $result->fetch_assoc()) {
								?>
								    <td><?php echo $row["CODIGO_HORARIO"];?></td>
		                            <td><?php echo $row["NOMBRE_HORARIO"];?></td>
									<td><?php echo $row["HORAINICIO_HORARIO"];?></td>
									<td><?php echo $row["HORAFIN_HORARIO"];?></td>
									<td>
									<?php
										$dias = array();
										$dia = "";
										$dias = explode(",",$row["DIAS"]);
										
										if (count($dias) != 0){
											for ( $i = 0 ; $i <= count($dias) ; $i ++) {
												switch ($dias[$i]) {
													case 1:
														if ($dia != "")
															$dia = $dia.","."Domingo";
														else
															$dia = "Domingo";
														break;
													case 2:
														if ($dia != "")
															$dia = $dia.","."Lunes";
														else
															$dia = "Lunes";
														break;
													case 3:
														if ($dia != "")
															$dia = $dia.","."Martes";
														else
															$dia = "Martes";
														break;
													case 4:
														if ($dia != "")
															$dia = $dia.","."Miercoles";
														else
															$dia = "Miercoles";
														break;
													case 5:
														if ($dia != "")
															$dia = $dia.","."Jueves";
														else
															$dia = "Jueves";
														break;
													case 6:
														if ($dia != "")
															$dia = $dia.","."Viernes";
														else
															$dia = "Viernes";
														break;
													case 7:
														if ($dia != "")
															$dia = $dia.","."Sabado";
														else
															$dia = "Sabado";
														break;
												}
											}
										}
										echo $dia;
									?>
									</td>
		                            <td class="center">
										<a href="javascript:EliminarHorarioModal(<?php echo $row["CODIGO_HORARIO"]; ?>);">
											<img src="ribbon/images/1323286140_user_delete.png" alt="Borrar" />
										</a>&nbsp;
										<a href="javascript:ModificarHorarioModal(<?php echo $row["CODIGO_HORARIO"].",'".$row["NOMBRE_HORARIO"]."','".$row["HORAINICIO_HORARIO"]."','".$row["HORAFIN_HORARIO"]."','".$row["DIAS"]."'"; ?>);">
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
                            <th>Nombre</th>
							<th>Hora Inicio</th>
							<th>Hora Fin</th>
							<th>Dias Laborables</th>
							<th>Opciones</th>
                        </tr>
                    </tfoot>
                </table>
			</div>
		</div>
        
        
        <div id="eliminarHorario" title="Eliminar Horario?">
			<p><span class="ui-icon ui-icon-trash" style="float:left; margin:0 7px 20px 0;"></span>Esta seguro que desea eliminar este registro?</p>
		</div>
    <div id="modificaHorario" title="Modificar Horario">
		<form id="formHorario" method="post" action="">
			<table>
				<tr height="40px">
					<td>
						Nombre(*):
					</td>
					<td>
						<input type="text" class="validate[required]" style="width:180px" name="nombreHorario" id="nombreHorario"/>
					</td>
				</tr>
				<tr height="40px">
					<td>
						Hora Inicio(*):
					</td>
					<td>
						<select name="horaInicioH" id="horaInicioH">
						<?php
							for($i=0;$i<=23;$i++)
							{
								$h = (strlen($i) < 2) ? "0".$i : $i;
								echo "<option value='$h'>$h</option>";
							}
						?>
						</select>
						<select name="horaInicioM" id="horaInicioM">
						<?php
							for($i=0;$i<=59;$i++)
							{
								$h = (strlen($i) < 2) ? "0".$i : $i;
								echo "<option value='$h'>$h</option>";
							}
						?>
						</select>
					</td>
				</tr>
				<tr height="40px">
					<td>
						Hora Fin(*):
					</td>
					<td>
						<select name="horaFinH" id="horaFinH">
						<?php
							for($i=0;$i<=23;$i++)
							{
								$h = (strlen($i) < 2) ? "0".$i : $i;
								echo "<option value='$h'>$h</option>";
							}
						?>
						</select>
						<select name="horaFinM" id="horaFinM">
						<?php
							for($i=0;$i<=59;$i++)
							{
								$h = (strlen($i) < 2) ? "0".$i : $i;
								echo "<option value='$h'>$h</option>";
							}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						<input type="checkbox" name="lunes" id="lunes"/> Lunes
						<input type="checkbox" name="martes" id="martes"/> Martes
						<input type="checkbox" name="miercoles" id="miercoles"/> Miercoles
				</tr>
				<tr>
					<td>
					</td>
					<td>
						<input type="checkbox" name="jueves" id="jueves"/> Jueves
						<input type="checkbox" name="viernes" id="viernes"/> Viernes
						<input type="checkbox" name="sabado" id="sabado"/> Sabado
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						<input type="checkbox" name="domingo" id="domingo"/> Domingo
					</td>
				</tr>
				<tr>
					<td>
						<input type="hidden" name="hdnDias" id="hdnDias"/>
					</td>
				</tr>
			</table>
		</form>
	</div>
	
	<div id="nuevoHorario" title="Nuevo Horario">
		<form id="formNuevoHorario" method="post" action="">
			<table>
				<tr height="40px">
					<td>
						Nombre(*):
					</td>
					<td>
						<input type="text" class="validate[required]" style="width:180px" name="nombreHorarioNuevo" id="nombreHorarioNuevo"/>
					</td>
				</tr>
				<tr height="40px">
					<td>
						Hora Inicio(*):
					</td>
					<td>
						<select name="horaInicioHNueva" id="horaInicioHNueva">
						<?php
							for($i=0;$i<=23;$i++)
							{
								//$longitud = strlen($cadena);
								$h = (strlen($i) < 2) ? "0".$i : $i;
								echo "<option value='$h'>$h</option>";
							}
						?>
						<!--div id="splash">
							<div id="demo">
								<div id="d-demo-wrapper-4" class="demo-wrapper">
									<input id="horaInicioNueva" type="text" class="demo" name="horaInicioNueva" >
								</div>
							</div>
						</div-->
						</select>
						<select name="horaInicioMNueva" id="horaInicioMNueva">
						<?php
							for($i=0;$i<=59;$i++)
							{
								//$longitud = strlen($cadena);
								$h = (strlen($i) < 2) ? "0".$i : $i;
								echo "<option value='$h'>$h</option>";
							}
						?>
						</select>
					</td>
				</tr>
				<tr height="40px">
					<td>
						Hora Fin(*):
					</td>
					<td>
						<select name="horaFinHNueva" id="horaFinHNueva">
						<?php
							for($i=0;$i<=23;$i++)
							{
								//$longitud = strlen($cadena);
								$h = (strlen($i) < 2) ? "0".$i : $i;
								echo "<option value='$h'>$h</option>";
							}
						?>
						</select>
						<select name="horaFinMNueva" id="horaFinMNueva">
						<?php
							for($i=0;$i<=59;$i++)
							{
								//$longitud = strlen($cadena);
								$h = (strlen($i) < 2) ? "0".$i : $i;
								echo "<option value='$h'>$h</option>";
							}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						<input type="checkbox" name="lunesN" id="lunesN"/> Lunes
						<input type="checkbox" name="martesN" id="martesN"/> Martes
						<input type="checkbox" name="miercolesN" id="miercolesN"/> Miercoles
				</tr>
				<tr>
					<td>
					</td>
					<td>
						<input type="checkbox" name="juevesN" id="juevesN"/> Jueves
						<input type="checkbox" name="viernesN" id="viernesN"/> Viernes
						<input type="checkbox" name="sabadoN" id="sabadoN"/> Sabado
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						<input type="checkbox" name="domingoN" id="domingoN"/> Domingo
					</td>
				</tr>
				<tr>
					<td>
						<input type="hidden" name="hdnDiasN" id="hdnDiasN"/>
					</td>
				</tr>
			</table>
		</form>
	</div>
	
	</body>
</html>