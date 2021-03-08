<?php
	require_once("comun/compruebasesion.php");
	if($sesion->get("Usuarios"))
		$obtener_permisos = $sesion->get("Usuarios");
	else 
		$obtener_permisos = 0;
	
	if($obtener_permisos == 0)
		header("Location: finsesion.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		
		<title>Usuarios</title>
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

   			$( "input:submit, input:button" ).button();
			$( "#selectGrupo" ).combobox();
			$( "#selectGrupoNuevo" ).combobox();
			
			$( "#toggle" ).click(function() {
				$( "#selectGrupo" ).toggle();
				$( "#selectGrupoNuevo" ).toggle();
			});
			
			$( "#dialog:ui-dialog" ).dialog( "destroy" );
   		
		
   			$("#eliminarUsuario").dialog({
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
			
			$( "#modificausuario" ).dialog({
   				autoOpen: false,
					bgiframe: true,
					resizable: false,
					height:240,
					modal: true,
					overlay: {
						backgroundColor: '#000',
						opacity: 0.5
					}
   			});
			$( "#claveusuario" ).dialog({
   				autoOpen: false,
					bgiframe: true,
					resizable: false,
					height:200,
					modal: true,
					overlay: {
						backgroundColor: '#000',
						opacity: 0.5
					}
   			});
			$( "#nuevousuario" ).dialog({
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
				
				$("#formUsuario").validationEngine('attach');
				$("#formUsuarioClave").validationEngine('attach');
				$("#formNuevoUsuario").validationEngine('attach');
			} );
			
			function EliminarUsuarioModal(usuarioaEliminar){
					$('#eliminarUsuario').dialog('option', "buttons", [
					{
						text: "Eliminar",
						click: function() { $.post("eliminarRegistro.php",{ Id: usuarioaEliminar, Estado: 2, Tabla: 'usuario' },
											   function(data){
												 //location.reload();
												 //$('#dt_example').html(data);
												window.location.href='usuarios.php?saveModified='+data;
											   }
											);
										    //$('#eliminarUsuario').dialog('close'); 
											
										  }
					},
					{
						text: "Cancelar",
						click: function() { $('#eliminarUsuario').dialog('close'); }
					}
					]);
					$('#eliminarUsuario').dialog('open');
			}
			
			function ModificarUsuarioModal(usuarioaModificar,NombreUsuario,NickUsuario,IdGrupo){
					
					$('#modificausuario').dialog('option', "buttons", [
					{
						text: "Modificar",
						click: function() { 
										if(!$(".formError").length){					
												$.post("modificarUsuario.php",{ usuarioModifica: usuarioaModificar,NicksUsuario: $('#nickUsuario').val(), nombresUsuario: $('#nombreUsuario').val(),IdGrupoUsuario: $('#selectGrupo').val()},
											   function(data){
												 	//location.reload();
													window.location.href='usuarios.php?saveModified='+data;
											   	}
												);
										    	//$('#modificausuario').dialog('close'); 
												//MuestraMensajeGuardadoCorrectoPegajoso('Se han guardado los cambios correctamente!');
											}
										  }
					},
					{
						text: "Cancelar",
						click: function() { $('#modificausuario').dialog('close'); 
											$(".formError").remove();}
					}
					]);
					$('#modificausuario').dialog('open');
					$('#nombreUsuario').attr("value", NombreUsuario);
					$('#nickUsuario').attr("value", NickUsuario);
					id = '#selectGrupo';
					$(id).val(IdGrupo);
					$(id).next().val($(id + " :selected").text());
					//$('#opt_'+IdGrupo).attr("selected", "selected");
					
			}

			function NuevoUsuarioModal(){
				
				$('#nuevousuario').dialog('option', "buttons", [
				{
					text: "Crear",
					click: function() { 
									if(!$(".formError").length){					
											$.post("nuevoUsuario.php",{ NicksUsuario: $('#nickUsuarioNuevo').val(), nombresUsuario: $('#nombreUsuarioNuevo').val(),IdGrupoUsuario: $('#selectGrupoNuevo').val(),ClaveUsuarioNuevo:$('#ClaveUsuarioNuevo').val()},
										   function(data){
											 	//location.reload();
												window.location.href='usuarios.php?saveModified='+data;
										   	}
											);
									    	//$('#modificausuario').dialog('close'); 
											//MuestraMensajeGuardadoCorrectoPegajoso('Se han guardado los cambios correctamente!');
										}
									  }
				},
				{
					text: "Cancelar",
					click: function() { $('#nuevousuario').dialog('close'); 
										$(".formError").remove();}
				}
				]);
				$('#nuevousuario').dialog('open');
		}
			
			function ModificarClaveUsuarioModal(usuarioaModificar){
				
				$('#claveusuario').dialog('option', "buttons", [
				{
					text: "Modificar Clave",
					click: function() { 
									if(!$(".formError").length){					
											$.post("modificarClaveUsuario.php",{ usuarioModifica: usuarioaModificar,NuevaClaveUser: $('#nuevaClaveUsuario').val()},
										   function(data){
											 	//location.reload();
												window.location.href='usuarios.php?saveModified='+data;
										   	}
											);
									    	//$('#modificausuario').dialog('close'); 
											//MuestraMensajeGuardadoCorrectoPegajoso('Se han guardado los cambios correctamente!');
										}
									  }
				},
				{
					text: "Cancelar",
					click: function() { $('#claveusuario').dialog('close'); 
										$(".formError").remove();}
				}
				]);
				$('#claveusuario').dialog('open');
			}

			function ModificarEstadoUsuarioModal(usuarioaModificar, NuevoEstado){
				
				//$.post("modificarEstadoUsuario.php",{ usuarioModifica: usuarioaModificar,EstadoUsuario: NuevoEstado},
				$.post("modificarEstado.php",{ Id: usuarioaModificar, Estado: NuevoEstado, Tabla: 'usuario'},
						   function(data){
									window.location.href='usuarios.php?saveModified='+data;
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
		<span class="Titulos">Usuarios del sistema</span>
		<div id="container">
			<div id="demo">
			<input name="Nuevo" type="button" onclick="javascript:NuevoUsuarioModal()" value="Nuevo Usuario">
			<br/><br/>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Grupo</th>
                            <th>Usuario</th>
                            <th>Estado</th>
                            <th>Nombres</th>
                            <th>Opciones</th>
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
					$consulta = "SELECT  `CODIGO_USUARIO` ,  `NOMBRE_GRUPO`, usuario.`CODIGO_GRUPO` ,  `NOMBRE_USUARIO` ,  `CLAVE_USUARIO` ,  `ESTADO_USUARIO` ,  `NOMBRES_USUARIO` FROM usuario JOIN grupo ON usuario.CODIGO_GRUPO = grupo.CODIGO_GRUPO WHERE ESTADO_USUARIO IN (0,1)";
					if ($result = $conexion->query($consulta)) {
					    if($result->num_rows > 0)
						{
							while ($row = $result->fetch_assoc()) {
								?>
								<?php if ($row["ESTADO_USUARIO"] == 1)
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
								    <td><?php echo $row["CODIGO_USUARIO"];?></td>
		                            <td><?php echo $row["NOMBRE_GRUPO"];?></td>
		                            <td><?php echo $row["NOMBRE_USUARIO"];?></td>
		                            <td class="center">
		                            	<?php if ($row["ESTADO_USUARIO"] == 1)
		                            	{
		                            	?>
		                            	<a href="javascript:ModificarEstadoUsuarioModal(<?php echo $row["CODIGO_USUARIO"]; ?>,0)"><img src="ribbon/images/1323286599_status.png" alt="activo" /></a>
		                            	<?php 
		                            	}
		                            	else{
		                            	?>
		                            	<a href="javascript:ModificarEstadoUsuarioModal(<?php echo $row["CODIGO_USUARIO"]; ?>,1)"><img src="ribbon/images/1323286606_status-offline.png" alt="inactivo" /></a>
		                            	<?php 
		                            	}
		                            	?>
		                            </td>
		                            <td><?php echo $row["NOMBRES_USUARIO"];?></td>
		                            <td class="center"><a href="javascript:EliminarUsuarioModal(<?php echo $row["CODIGO_USUARIO"]; ?>);"><img src="ribbon/images/1323286140_user_delete.png" alt="Borrar" /></a>
		                            &nbsp;<a href="javascript:ModificarUsuarioModal(
									<?php echo $row["CODIGO_USUARIO"].",'".$row["NOMBRES_USUARIO"]."','".$row["NOMBRE_USUARIO"]."',".$row["CODIGO_GRUPO"]; ?>);"><img src="ribbon/images/1323286136_user_edit.png" alt="Editar" /></a>
									&nbsp;<a href="javascript:ModificarClaveUsuarioModal(
									<?php echo $row["CODIGO_USUARIO"]; ?>);"><img src="ribbon/images/1323444057_change_password.png" alt="Clave" /></a>
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
                            <th>Grupo</th>
                            <th>Usuario</th>
                            <th>Estado</th>
                            <th>Nombres</th>
                            <th>Opciones</th>
                        </tr>
                    </tfoot>
                </table>
			</div>
		</div>
        
        
        <div id="eliminarUsuario" title="Eliminar Usuario?">
			<p><span class="ui-icon ui-icon-trash" style="float:left; margin:0 7px 20px 0;"></span>Esta seguro que desea eliminar este usuario?</p>
		</div>
    
    <div id="modificausuario" title="Modificar Usuario">
    <form id="formUsuario" method="post" action="">
		<table>
		<tr height="40px">
	   		<td>
            	Nombres(*):
			</td>
			<td>
           		<input type="text" class="validate[required]" style="width:180px" name="nombreUsuario" id="nombreUsuario"/>
			</td>
        </tr>
        <tr height="40px">
            <td>
            	Usuario(*):
			</td>
			<td>
				<input type="text" class="validate[required]" style="width:180px" name="nickUsuario" id="nickUsuario"/>
			</td>
		</tr>
        <tr height="40px">
	   		<td>
            	Grupo(*):
			</td>
            <td>
            <select id ="selectGrupo">
            <?php 
	            //$conexion = new mysqli("localhost","usuario","password","base");
				$conexion = new mysqli($hostname,$username,$password,$database);
				$consulta = 'SELECT `CODIGO_GRUPO` , `NOMBRE_GRUPO` FROM `grupo`;';
				if ($result = $conexion->query($consulta)) {
					    if($result->num_rows > 0)
						{
							while ($row = $result->fetch_assoc()) {
								echo "<option id='opt_".$row["CODIGO_GRUPO"]."' value='".$row["CODIGO_GRUPO"]."'>".$row["NOMBRE_GRUPO"]."</option>";
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
    
    <div id="nuevousuario" title="Nuevo Usuario">
    <form id="formNuevoUsuario" method="post" action="">
		<table>
		<tr height="40px">
	   		<td>
            	Nombres(*):
			</td>
			<td>
           		<input type="text" class="validate[required]" style="width:180px" name="nombreUsuarioNuevo" id="nombreUsuarioNuevo"/>
			</td>
        </tr>
        <tr height="40px">
            <td>
            	Usuario(*):
			</td>
			<td>
				<input type="text" class="validate[required]" style="width:180px" name="nickUsuarioNuevo" id="nickUsuarioNuevo"/>
			</td>
		</tr>
        <tr height="40px">
	   		<td>
            	Grupo(*):
			</td>
            <td>
            <select id ="selectGrupoNuevo">
            <?php 
	            //$conexion = new mysqli("localhost","usuario","password","base");
				$conexion = new mysqli($hostname,$username,$password,$database);
				$consulta = 'SELECT `CODIGO_GRUPO` , `NOMBRE_GRUPO` FROM `grupo`;';
				if ($result = $conexion->query($consulta)) {
					    if($result->num_rows > 0)
						{
							while ($row = $result->fetch_assoc()) {
								echo "<option id='optnuevo_".$row["CODIGO_GRUPO"]."' value='".$row["CODIGO_GRUPO"]."'>".$row["NOMBRE_GRUPO"]."</option>";
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
            	Clave(*):
			</td>
			<td>
           		<input type="password" validate[required]" style="width:180px" name="ClaveUsuarioNuevo" id="ClaveUsuarioNuevo"/>
			</td>
        </tr>
        <tr height="40px">
            <td>
            	Confirmar clave(*):
			</td>
			<td>
				<input type="password" class="validate[required,equals[ClaveUsuarioNuevo]]" style="width:180px" name="confirmaClaveNuevo" id="confirmaClaveNuevo"/>
			</td>
		</tr>
    </table>
    </form>
	</div>
    
    <div id="claveusuario" title="Modificar clave Usuario">
    <form id="formUsuarioClave" method="post" action="">
		<table>
		<tr height="40px">
	   		<td>
            	Nueva Clave(*):
			</td>
			<td>
           		<input type="password" validate[required]" style="width:180px" name="nuevaClaveUsuario" id="nuevaClaveUsuario"/>
			</td>
        </tr>
        <tr height="40px">
            <td>
            	Confirmar nueva clave(*):
			</td>
			<td>
				<input type="password" class="validate[required,equals[nuevaClaveUsuario]]" style="width:180px" name="confirmaClave" id="confirmaClave"/>
			</td>
		</tr>
    	</table>
    </form>
	</div>
    
    
        
	</body>
</html>