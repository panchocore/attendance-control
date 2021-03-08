<?php
	require_once("comun/compruebasesion.php");
	
	$usuario = $sesion->get("nombreusuario");
	if($sesion->get("Mantenimiento"))
		$obtener_permisos = $sesion->get("Mantenimiento");
	else 
		$obtener_permisos = 0;
	
	if($obtener_permisos == 0)
		header("Location: finsesion.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		
		<title>Empleados</title>
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
		<script type="text/javascript" src="scripts/combobox.js"></script>
		<script type="text/javascript" src="scripts/permisos.js"></script>
   		<script type="text/javascript" charset="utf-8">
   		$(function() {
		
			$( "#dialog:ui-dialog" ).dialog( "destroy" );
			
			$( "input:submit, input:button" ).button();
			$( "#selectArea" ).combobox();
			$( "#toggle" ).click(function() {
				$( "#selectArea" ).toggle();
			});
			$( "#selectAreaNuevo" ).combobox();
			$( "#toggle" ).click(function() {
				$( "#selectAreaNuevo" ).toggle();
			});
		
   			$("#eliminarEmpleado").dialog({
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
			
			$( "#modificaEmpleado" ).dialog({
   				autoOpen: false,
					bgiframe: true,
					resizable: false,
					height:330,
					weight:500,
					modal: true,
					overlay: {
						backgroundColor: '#000',
						opacity: 0.5
					}
   			});
			
			$( "#nuevoEmpleado" ).dialog({
   				autoOpen: false,
					bgiframe: true,
					resizable: false,
					height:320,
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
				
				$("#formEmpleado").validationEngine('attach');
				$("#formNuevoEmpleado").validationEngine('attach');
			} );
			
			function EliminarEmpleadoModal(empleadoaEliminar){
					$('#eliminarEmpleado').dialog('option', "buttons", [
					{
						text: "Eliminar",
						click: function() { $.post("eliminarRegistro.php",{ Id: empleadoaEliminar, Estado: 2, Tabla: 'empleado' },
											   function(data){
												 //location.reload();
												 //$('#dt_example').html(data);
												window.location.href='empleados.php?saveModified='+data;
											   }
											);
										    //$('#eliminarUsuario').dialog('close'); 
											
										  }
					},
					{
						text: "Cancelar",
						click: function() { $('#eliminarEmpleado').dialog('close'); }
					}
					]);
					$('#eliminarEmpleado').dialog('open');
			}
			
			function ModificarEmpleadoModal(empleadoaModificar,idEmpleado,cedulaEmpleado,nombreEmpleado,telefonoEmpleado,idArea, foto){
					$('#modificaEmpleado').dialog('option', "buttons", [
					{
						text: "Modificar",
						click: function() { 
										if(!$(".formError").length){					
												$.post("modificarEmpleado.php",{ codigo: empleadoaModificar, id: $('#idEmpleado').val(), cedulaEmpleado: $('#cedulaEmpleado').val(), nombreEmpleado: $('#nombreEmpleado').val(), telefonoEmpleado: $('#telefonoEmpleado').val(), idArea: $('#selectArea').val()},
											   function(data){
												 	//location.reload();
													window.location.href='empleados.php?saveModified='+data;
											   	}
												);
										    	//$('#modificausuario').dialog('close'); 
												//MuestraMensajeGuardadoCorrectoPegajoso('Se han guardado los cambios correctamente!');
											}
										  }
					},
					{
						text: "Cancelar",
						click: function() { $('#modificaEmpleado').dialog('close'); 
											$(".formError").remove();}
					}
					]);
					$('#modificaEmpleado').dialog('open');
					$('#idEmpleado').attr("value", idEmpleado);
					$('#cedulaEmpleado').attr("value", cedulaEmpleado);
					$('#nombreEmpleado').attr("value", nombreEmpleado);
					$('#telefonoEmpleado').attr("value", telefonoEmpleado);
										
					id = '#selectArea';
					$(id).val(idArea);
					$(id).next().val($(id + " :selected").text());
					
			}

			function ModificarEstadoEmpleadoModal(empleadoaModificar, NuevoEstado){
				
				$.post("modificarEstado.php",{ Id: empleadoaModificar, Estado: NuevoEstado, Tabla: 'empleado'},
						   function(data){
									window.location.href='empleados.php?saveModified='+data;
								   	}
						);
			}
			
			function NuevoEmpleadoModal(){
				
				$('#nuevoEmpleado').dialog('option', "buttons", [
				{
					text: "Crear",
					click: function() { 
									if(!$(".formError").length){					
											$.post("nuevoEmpleado.php",{id: $('#idEmpleadoNuevo').val(), cedula: $('#cedulaEmpleadoNuevo').val(), nombre: $('#nombreEmpleadoNuevo').val(),telefono:$('#telefonoEmpleadoNuevo').val(), idArea: $('#selectAreaNuevo').val()},
										   function(data){
											 	//location.reload();
												window.location.href='empleados.php?saveModified='+data;
										   	}
											);
									    	//$('#modificausuario').dialog('close'); 
											//MuestraMensajeGuardadoCorrectoPegajoso('Se han guardado los cambios correctamente!');
										}
									  }
				},
				{
					text: "Cancelar",
					click: function() { $('#nuevoEmpleado').dialog('close'); 
										$(".formError").remove();}
				}
				]);
				$('#nuevoEmpleado').dialog('open');
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
		<span class="Titulos">Empleados</span>
		<div id="container">
			<div id="demo">
			<input name="Nuevo" type="button" onclick="javascript:NuevoEmpleadoModal()" value="Nuevo Empleado">&nbsp;
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Area</th>
							<th>Id</th>
                            <th>Cedula</th>
                            <th>Nombre</th>
                            <th>Telefono</th>
                            <th>Estado</th>
							<th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    <?php 
                    require_once("conexion/conexion.php");
					//$conexion = new mysqli("localhost","usuario","password","base");
					/*$hostname="localhost";
					$username='root';
					$password="";
					$database="controlasistencia";/**/
					$conexion = new mysqli($hostname,$username,$password,$database);
					/* check connection */
					if ($conexion->connect_errno) {
						echo "<script type='text/javascript'>";
						echo "mostrarerroregajosoderecha('"."Connect failed: %s\n".$conexion->connect_error."');";
						echo "</script>";
					    //echo "Connect failed: %s\n".$conexion->connect_error;
					    exit();
					}
					$consulta = "select e.ID_EMPLEADO, e.CODIGO_EMPLEADO, a.NOMBRE_AREA, a.CODIGO_AREA, e.CEDULA_EMPLEADO, e.NOMBRE_EMPLEADO, e.TELEFONO_EMPLEADO, e.FOTO_EMPLEADO, e.ESTADO_EMPLEADO ".
								"from	empleado e, area a ".
								"where	e.CODIGO_AREA = a.CODIGO_AREA ".
								"and	e.ESTADO_EMPLEADO in (1,0)";
					
					if ($result = $conexion->query($consulta)) {
					    if($result->num_rows > 0)
						{
							while ($row = $result->fetch_assoc()) {
								?>
								<?php if ($row["ESTADO_EMPLEADO"] == 1)
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
								    <td><?php echo $row["CODIGO_EMPLEADO"];?></td>
		                            <td><?php echo $row["NOMBRE_AREA"];?></td>
									<td><?php echo $row["ID_EMPLEADO"];?></td>
		                            <td><?php echo $row["CEDULA_EMPLEADO"];?></td>
									<td><?php echo $row["NOMBRE_EMPLEADO"];?></td>
									<td><?php echo $row["TELEFONO_EMPLEADO"];?></td>
									
		                            <td class="center">
		                            	<?php if ($row["ESTADO_EMPLEADO"] == 1)
		                            	{
		                            	?>
		                            	<a href="javascript:ModificarEstadoEmpleadoModal(<?php echo $row["CODIGO_EMPLEADO"]; ?>,0)"><img src="ribbon/images/1323286599_status.png" alt="activo" /></a>
		                            	<?php 
		                            	}
		                            	else{
		                            	?>
		                            	<a href="javascript:ModificarEstadoEmpleadoModal(<?php echo $row["CODIGO_EMPLEADO"]; ?>,1)"><img src="ribbon/images/1323286606_status-offline.png" alt="inactivo" /></a>
		                            	<?php 
		                            	}
		                            	?>
		                            </td>
		                            <td class="center">
										<a href="javascript:EliminarEmpleadoModal(<?php echo $row["CODIGO_EMPLEADO"]; ?>);">
											<img src="ribbon/images/1323286140_user_delete.png" alt="Borrar" />
										</a>&nbsp;
										<a href="javascript:ModificarEmpleadoModal(<?php echo $row["CODIGO_EMPLEADO"].",".$row["ID_EMPLEADO"].",'".$row["CEDULA_EMPLEADO"]."','".$row["NOMBRE_EMPLEADO"]."','".$row["TELEFONO_EMPLEADO"]."',".$row["CODIGO_AREA"]; ?>);">
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
                            <th>Area</th>
							<th>Id</th>
							<th>Cedula</th>
                            <th>Nombre</th>
                            <th>Telefono</th>
							<th>Estado</th>
							<th>Opciones</th>
                        </tr>
                    </tfoot>
                </table>
			</div>
		</div>
        
        
        <div id="eliminarEmpleado" title="Eliminar Empleado?">
			<p><span class="ui-icon ui-icon-trash" style="float:left; margin:0 7px 20px 0;"></span>Esta seguro que desea eliminar este empleado?</p>
		</div>
    <div id="modificaEmpleado" title="Modificar Empleado">
		<form id="formEmpleado" method="post" action="">
			<table>
				<tr height="40px">
					<td>
						Id(*):
					</td>
					<td>
						<input type="text" class="validate[required]" style="width:180px" name="idEmpleado" id="idEmpleado"/>
					</td>
				</tr>
				<tr height="40px">
					<td>
						Cedula(*):
					</td>
					<td>
						<input type="text" style="width:180px" name="cedulaEmpleado" id="cedulaEmpleado"/>
					</td>
				</tr>
				<tr height="40px">
					<td>
						Nombre(*):
					</td>
					<td>
						<input type="text" class="validate[required]" style="width:180px" name="nombreEmpleado" id="nombreEmpleado"/>
					</td>
				</tr>
				<tr height="40px">
					<td>
						Telefono:
					</td>
					<td>
						<input type="text" style="width:180px" name="telefonoEmpleado" id="telefonoEmpleado"/>
					</td>
				</tr>
				<tr height="40px">
					<td>
						Area(*):
					</td>
					<td>
					<select id ="selectArea">
					<?php 
						$conexion = new mysqli($hostname,$username,$password,$database);
						$consulta = 'SELECT `CODIGO_AREA` , `NOMBRE_AREA` FROM `area`;';
						if ($result = $conexion->query($consulta)) {
								if($result->num_rows > 0)
								{
									while ($row = $result->fetch_assoc()) {
										echo "<option id='opt_".$row["CODIGO_AREA"]."' value='".$row["CODIGO_AREA"]."'>".$row["NOMBRE_AREA"]."</option>";
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
			</table>
		</form>
	</div>
	
	<div id="nuevoEmpleado" title="Nuevo Empleado">
		<form id="formNuevoEmpleado" method="post" action="">
			<table>
				<tr height="40px">
					<td>
						Id(*):
					</td>
					<td>
						<input type="text" class="validate[required]" style="width:180px" name="idEmpleadoNuevo" id="idEmpleadoNuevo"/>
					</td>
				</tr>
				<tr height="40px">
					<td>
						Cedula(*):
					</td>
					<td>
						<input type="text" style="width:180px" name="cedulaEmpleadoNuevo" id="cedulaEmpleadoNuevo"/>
					</td>
				</tr>
				<tr height="40px">
					<td>
						Nombre(*):
					</td>
					<td>
						<input type="text" class="validate[required]" style="width:180px" name="nombreEmpleadoNuevo" id="nombreEmpleadoNuevo"/>
					</td>
				</tr>
				<tr height="40px">
					<td>
						Telefono:
					</td>
					<td>
						<input type="text" style="width:180px" name="telefonoEmpleadoNuevo" id="telefonoEmpleadoNuevo"/>
					</td>
				</tr>
				<tr height="40px">
					<td>
						Area(*):
					</td>
					<td>
					<select id ="selectAreaNuevo">
					<?php 
						$conexion = new mysqli($hostname,$username,$password,$database);
						$consulta = 'SELECT `CODIGO_AREA` , `NOMBRE_AREA` FROM `area`;';
						if ($result = $conexion->query($consulta)) {
								if($result->num_rows > 0)
								{
									while ($row = $result->fetch_assoc()) {
										echo "<option id='opt_".$row["CODIGO_AREA"]."' value='".$row["CODIGO_AREA"]."'>".$row["NOMBRE_AREA"]."</option>";
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
			</table>
		</form>
	</div>
	</body>
</html>