<?php
	require_once("comun/compruebasesion.php");
	
	$usuario = $sesion->get("nombreusuario");
	if($sesion->get("Areas"))
		$obtener_permisos = $sesion->get("Areas");
	else 
		$obtener_permisos = 0;
	
	if($obtener_permisos == 0)
		header("Location: finsesion.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		
		<title>Areas</title>
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
   		<script type="text/javascript" charset="utf-8">
   		$(function() {
		
			$( "#dialog:ui-dialog" ).dialog( "destroy" );
			
			$( "input:submit, input:button" ).button();
		
   			$("#eliminarArea").dialog({
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
			
			$( "#modificaArea" ).dialog({
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
			
			$( "#nuevaArea" ).dialog({
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
				$("#formNuevaArea").validationEngine('attach');
			} );
			
			function EliminarAreaModal(areaaEliminar){
					$('#eliminarArea').dialog('option', "buttons", [
					{
						text: "Eliminar",
						click: function() { $.post("eliminarRegistro.php",{ Id: areaaEliminar, Estado: 2, Tabla: 'area' },
											   function(data){
												 //location.reload();
												 //$('#dt_example').html(data);
												window.location.href='areas.php?saveModified='+data;
											   }
											);
										    //$('#eliminarUsuario').dialog('close'); 
											
										  }
					},
					{
						text: "Cancelar",
						click: function() { $('#eliminarArea').dialog('close'); }
					}
					]);
					$('#eliminarArea').dialog('open');
			}
			
			function ModificarAreaModal(areaaModificar,nombreArea,descripcionArea){
					$('#modificaArea').dialog('option', "buttons", [
					{
						text: "Modificar",
						click: function() { 
										if(!$(".formError").length){					
												$.post("modificarArea.php",{ codigo: areaaModificar, nombre: $('#nombreArea').val(), descripcion: $('#descripcionArea').val()},
											   function(data){
												 	//location.reload();
													window.location.href='areas.php?saveModified='+data;
											   	}
												);
										    	//$('#modificausuario').dialog('close'); 
												//MuestraMensajeGuardadoCorrectoPegajoso('Se han guardado los cambios correctamente!');
											}
										  }
					},
					{
						text: "Cancelar",
						click: function() { $('#modificaArea').dialog('close'); 
											$(".formError").remove();}
					}
					]);
					$('#modificaArea').dialog('open');
					$('#nombreArea').attr("value", nombreArea);
					$('#descripcionArea').attr("value", descripcionArea);
					
			}
			
			function NuevaAreaModal(){
				
				$('#nuevaArea').dialog('option', "buttons", [
				{
					text: "Crear",
					click: function() { 
									if(!$(".formError").length){					
											$.post("nuevaArea.php",{nombre: $('#nombreAreaNueva').val(), descripcion: $('#descripcionAreaNueva').val()},
										   function(data){
											 	//location.reload();
												window.location.href='areas.php?saveModified='+data;
										   	}
											);
									    	//$('#modificausuario').dialog('close'); 
											//MuestraMensajeGuardadoCorrectoPegajoso('Se han guardado los cambios correctamente!');
										}
									  }
				},
				{
					text: "Cancelar",
					click: function() { $('#nuevaArea').dialog('close'); 
										$(".formError").remove();}
				}
				]);
				$('#nuevaArea').dialog('open');
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
		<span class="Titulos">Areas</span>
		<div id="container">
			<div id="demo">
			<input name="Nuevo" type="button" onclick="javascript:NuevaAreaModal()" value="Nueva Area">&nbsp;
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Nombre</th>
							<th>Descripcion</th>
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
					$consulta = "select a.CODIGO_AREA, a.NOMBRE_AREA, a.DESCRIPCION_AREA ".
								"from	area a ";
					
					if ($result = $conexion->query($consulta)) {
					    if($result->num_rows > 0)
						{
							while ($row = $result->fetch_assoc()) {
								?>
								    <td><?php echo $row["CODIGO_AREA"];?></td>
		                            <td><?php echo $row["NOMBRE_AREA"];?></td>
									<td><?php echo $row["DESCRIPCION_AREA"];?></td>
		                            <td class="center">
										<a href="javascript:EliminarAreaModal(<?php echo $row["CODIGO_AREA"]; ?>);">
											<img src="ribbon/images/1323286140_user_delete.png" alt="Borrar" />
										</a>&nbsp;
										<a href="javascript:ModificarAreaModal(<?php echo $row["CODIGO_AREA"].",'".$row["NOMBRE_AREA"]."','".$row["DESCRIPCION_AREA"]."'"; ?>);">
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
							<th>Descripcion</th>
							<th>Opciones</th>
                        </tr>
                    </tfoot>
                </table>
			</div>
		</div>
        
        
        <div id="eliminarArea" title="Eliminar Area?">
			<p><span class="ui-icon ui-icon-trash" style="float:left; margin:0 7px 20px 0;"></span>Esta seguro que desea eliminar este registro?</p>
		</div>
    <div id="modificaArea" title="Modificar Area">
		<form id="formArea" method="post" action="">
			<table>
				<tr height="40px">
					<td>
						Nombre(*):
					</td>
					<td>
						<input type="text" class="validate[required]" style="width:180px" name="nombreArea" id="nombreArea"/>
					</td>
				</tr>
				<tr height="40px">
					<td>
						Descripcion:
					</td>
					<td>
						<input type="text" style="width:180px" name="descripcionArea" id="descripcionArea"/>
					</td>
				</tr>
			</table>
		</form>
	</div>
	
	<div id="nuevaArea" title="Nueva Area">
		<form id="formNuevaArea" method="post" action="">
			<table>
				<tr height="40px">
					<td>
						Nombre(*):
					</td>
					<td>
						<input type="text" class="validate[required]" style="width:180px" name="nombreAreaNueva" id="nombreAreaNueva"/>
					</td>
				</tr>
				<tr height="40px">
					<td>
						Descripcion:
					</td>
					<td>
						<input type="text" style="width:180px" name="descripcionAreaNueva" id="descripcionAreaNueva"/>
					</td>
				</tr>
			</table>
		</form>
	</div>
	</body>
</html>