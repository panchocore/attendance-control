<?php
	require_once("comun/compruebasesion.php");
	if($sesion->get("Roles"))
		$obtener_permisos = $sesion->get("Roles");
	else 
		$obtener_permisos = 0;
	
	if($obtener_permisos == 0)
		header("Location: finsesion.php");
	require_once("conexion/conexion.php");		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/>
	<link href="estilo/estilo.css" rel="stylesheet" type="text/css" />
	<script src="scripts/jquery.js" type="text/javascript"></script>
	<link rel="stylesheet" href="estilo/jquery.treeview.css" />
    <script src="scripts/jquery.cookie.js" type="text/javascript"></script>
	<script src="scripts/jquery.treeview.js" type="text/javascript"></script>
	    <link type="text/css" href="jqueryui/css/redmond/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
        <link type="text/css" href="estilo/jquery.toastmessage.css" rel="stylesheet"/>
		<script type="text/javascript" src="scripts/jquery.toastmessage.js"></script>
        <script type="text/javascript" src="scripts/mensajes.js"></script>
    	<script src="jqueryui/js/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>
    	<script type="text/javascript" src="scripts/combobox.js"></script>
		<script type="text/javascript" src="scripts/permisos.js"></script>
	
	<script type="text/javascript">
		$(function() {
			$("#browser").treeview();
			$( "input:submit, input:button" ).button();
			$( "#selectGrupo" ).combobox();
			$( "#toggle" ).click(function() {
				$( "#selectGrupo" ).toggle();
			});
		});
		function ModificarEstado(grupoMenuModificar_ , MenuModificar_,GrupoModificar_,permisos_, imagen, objhref, nombreMenu_){
			
			//$.post("modificarEstadoUsuario.php",{ usuarioModifica: usuarioaModificar,EstadoUsuario: NuevoEstado},
			if(permisos_ == 2){
				permisos_ = 0;
				$('#'+imagen).attr("src", "images/1323365084_file-broken.png");
				$('#'+objhref).attr("href", "javascript:ModificarEstado("+grupoMenuModificar_+","+MenuModificar_+","+GrupoModificar_+","+permisos_+",'"+imagen+"','"+objhref+"','"+nombreMenu_+"')");
			}
			else if (permisos_ == 1){
				permisos_ = 2;
				$('#'+imagen).attr("src", "images/1323365071_mail-new.png");
				$('#'+objhref).attr("href", "javascript:ModificarEstado("+grupoMenuModificar_+","+MenuModificar_+","+GrupoModificar_+","+permisos_+",'"+imagen+"','"+objhref+"','"+nombreMenu_+"')");
			}
			else if (permisos_ == 0){
				permisos_ = 1;
				$('#'+imagen).attr("src", "images/1323365078_document.png");
				$('#'+objhref).attr("href", "javascript:ModificarEstado("+grupoMenuModificar_+","+MenuModificar_+","+GrupoModificar_+","+permisos_+",'"+imagen+"','"+objhref+"','"+nombreMenu_+"')");
			}
			else{
				permisos_ = 1;
				$('#'+imagen).attr("src", "images/1323365078_document.png");
				$('#'+objhref).attr("href", "javascript:ModificarEstado("+grupoMenuModificar_+","+MenuModificar_+","+GrupoModificar_+","+permisos_+",'"+imagen+"','"+objhref+"','"+nombreMenu_+"')");
			}
			$.post("modificarPermisos.php",{grupoMenuModificar: grupoMenuModificar_, MenuModificar: MenuModificar_, GrupoModificar: GrupoModificar_, permisos: permisos_, nombreMenu: nombreMenu_},
					   function(data){
				   					MuestraInformacion(data);
							   	}
					);
		}
	</script>
	
	</head>
	<body onload="javascript:desabilitarMenusTabla(<?php echo $obtener_permisos;?>)">
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
	<span class="Titulos">Roles del sistema</span>
	<br/>
	<br/>
	<form  id="formGrupos" method="post" action="roles.php">
				<table>
					<tr height="40px">
			            <td>
			            	Grupo:
						</td>
						<td>
			            <select id="selectGrupo" name="selectGrupo">
			            <option id='optnuevo_default' value='-1'><span style='font-size:9pt;'>Seleccionar Grupo</span></option>
							<?php 
								
								$conexion = new mysqli($hostname,$username,$password,$database);
								$consulta = 'SELECT `CODIGO_GRUPO` , `NOMBRE_GRUPO` FROM `grupo`;';
								if ($result = $conexion->query($consulta)) {
									    if($result->num_rows > 0)
										{
											while ($row = $result->fetch_assoc()) {
												if(!$primerGrupo)
													$primerGrupo = $row["CODIGO_GRUPO"];
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
						<td>
							<input name="SeleccionaGrupo" type="submit" id="SeleccionaGrupo" value="Seleccionar Grupo">
						</td>
					</tr>
					
				</table>
			</form>
	<br/>
<?php 
	include_once("estilo/textos.php");
	$conexion = new mysqli($hostname,$username,$password,$database);
	if($_POST['selectGrupo'] and $_POST['selectGrupo'] != -1)
		$primerGrupo=$_POST['selectGrupo'];
	$conexion = new mysqli($hostname,$username,$password,$database);
	$consulta = 'SELECT `NOMBRE_GRUPO` , `DESCRIPCION_GRUPO` FROM `grupo` where CODIGO_GRUPO = '.$primerGrupo;
	if ($result = $conexion->query($consulta)) {
		    if($result->num_rows > 0)
			{
				while ($row = $result->fetch_assoc()) {
					echo "<b>".$row["NOMBRE_GRUPO"]."</b> (".$row["DESCRIPCION_GRUPO"].")";
				}
				$result->close();
		    	$conexion->close();
			}		
			else{
				$result->close();
		    	$conexion->close();
			}
	}	
	$conexion = new mysqli($hostname,$username,$password,$database);
	$consulta ='SELECT menu.NOMBRE_MENU, ifnull( menu_grupo.CODIGO_MENUGRUPO, -1 ) CODIGO_MENUGRUPO, ifnull( menu_grupo.PERMISO_MENU, -1 ) PERMISO_MENU, menu.CODIGO_MENU 
				FROM menu
				LEFT JOIN (
				SELECT PERMISO_MENU, CODIGO_MENU, CODIGO_MENUGRUPO
				FROM menugrupo
				WHERE menugrupo.CODIGO_GRUPO = '.$primerGrupo.'
				)menu_grupo ON menu_grupo.CODIGO_MENU = menu.CODIGO_MENU ';
					if ($result = $conexion->query($consulta)) {
					    if($result->num_rows > 0)
							{
								while ($row = $result->fetch_assoc()) 
								{
									IF($row["NOMBRE_MENU"] == "CambiarTexto")
										$CambiarTexto = array("nombre" => $row["NOMBRE_MENU"], "permisos" => $row["PERMISO_MENU"], "menugrupo" => $row["CODIGO_MENUGRUPO"], "menu" => $row["CODIGO_MENU"]);
										
									ELSE IF($row["NOMBRE_MENU"] == "LogoEmpresarial")
										$LogoEmpresarial = array("nombre" => $row["NOMBRE_MENU"], "permisos" => $row["PERMISO_MENU"], "menugrupo" => $row["CODIGO_MENUGRUPO"], "menu" => $row["CODIGO_MENU"]);
										
									ELSE IF($row["NOMBRE_MENU"] == "DatosGenerales")
										$DatosGenerales = array("nombre" => $row["NOMBRE_MENU"], "permisos" => $row["PERMISO_MENU"], "menugrupo" => $row["CODIGO_MENUGRUPO"], "menu" => $row["CODIGO_MENU"]);
										
									ELSE IF($row["NOMBRE_MENU"] == "Usuarios")
										$Usuarios = array("nombre" => $row["NOMBRE_MENU"], "permisos" => $row["PERMISO_MENU"], "menugrupo" => $row["CODIGO_MENUGRUPO"], "menu" => $row["CODIGO_MENU"]);
										
									ELSE IF($row["NOMBRE_MENU"] == "ReporteUsuarios")
										$ReporteUsuarios = array("nombre" => $row["NOMBRE_MENU"], "permisos" => $row["PERMISO_MENU"], "menugrupo" => $row["CODIGO_MENUGRUPO"], "menu" => $row["CODIGO_MENU"]);
										
									ELSE IF($row["NOMBRE_MENU"] == "CargaArchivo")
										$CargaArchivo = array("nombre" => $row["NOMBRE_MENU"], "permisos" => $row["PERMISO_MENU"], "menugrupo" => $row["CODIGO_MENUGRUPO"], "menu" => $row["CODIGO_MENU"]);
										
									ELSE IF($row["NOMBRE_MENU"] == "ModificarAsistencia")
										$ModificarAsistencia = array("nombre" => $row["NOMBRE_MENU"], "permisos" => $row["PERMISO_MENU"], "menugrupo" => $row["CODIGO_MENUGRUPO"], "menu" => $row["CODIGO_MENU"]);
										
									ELSE IF($row["NOMBRE_MENU"] == "Roles")
										$Roles = array("nombre" => $row["NOMBRE_MENU"], "permisos" => $row["PERMISO_MENU"], "menugrupo" => $row["CODIGO_MENUGRUPO"], "menu" => $row["CODIGO_MENU"]);
									
									ELSE IF($row["NOMBRE_MENU"] == "Empleados")
										$Empleados = array("nombre" => $row["NOMBRE_MENU"], "permisos" => $row["PERMISO_MENU"], "menugrupo" => $row["CODIGO_MENUGRUPO"], "menu" => $row["CODIGO_MENU"]);
									
									ELSE IF($row["NOMBRE_MENU"] == "Mantenimiento")
										$Mantenimiento = array("nombre" => $row["NOMBRE_MENU"], "permisos" => $row["PERMISO_MENU"], "menugrupo" => $row["CODIGO_MENUGRUPO"], "menu" => $row["CODIGO_MENU"]);

									ELSE IF($row["NOMBRE_MENU"] == "ReporteEmpleados")
										$ReporteEmpleados = array("nombre" => $row["NOMBRE_MENU"], "permisos" => $row["PERMISO_MENU"], "menugrupo" => $row["CODIGO_MENUGRUPO"], "menu" => $row["CODIGO_MENU"]);
									
									ELSE IF($row["NOMBRE_MENU"] == "Permisos")
										$Permisos = array("nombre" => $row["NOMBRE_MENU"], "permisos" => $row["PERMISO_MENU"], "menugrupo" => $row["CODIGO_MENUGRUPO"], "menu" => $row["CODIGO_MENU"]);
										
									ELSE IF($row["NOMBRE_MENU"] == "ReportePermisos")
										$ReportePermisos = array("nombre" => $row["NOMBRE_MENU"], "permisos" => $row["PERMISO_MENU"], "menugrupo" => $row["CODIGO_MENUGRUPO"], "menu" => $row["CODIGO_MENU"]);
										
									ELSE IF($row["NOMBRE_MENU"] == "Feriados")
										$Feriados = array("nombre" => $row["NOMBRE_MENU"], "permisos" => $row["PERMISO_MENU"], "menugrupo" => $row["CODIGO_MENUGRUPO"], "menu" => $row["CODIGO_MENU"]);
										
									ELSE IF($row["NOMBRE_MENU"] == "ReporteFeriados")
										$ReporteFeriados = array("nombre" => $row["NOMBRE_MENU"], "permisos" => $row["PERMISO_MENU"], "menugrupo" => $row["CODIGO_MENUGRUPO"], "menu" => $row["CODIGO_MENU"]);
										
									ELSE IF($row["NOMBRE_MENU"] == "Areas")
										$Areas = array("nombre" => $row["NOMBRE_MENU"], "permisos" => $row["PERMISO_MENU"], "menugrupo" => $row["CODIGO_MENUGRUPO"], "menu" => $row["CODIGO_MENU"]);
										
									ELSE IF($row["NOMBRE_MENU"] == "ReporteAreas")
										$ReporteAreas = array("nombre" => $row["NOMBRE_MENU"], "permisos" => $row["PERMISO_MENU"], "menugrupo" => $row["CODIGO_MENUGRUPO"], "menu" => $row["CODIGO_MENU"]);
									
									ELSE IF($row["NOMBRE_MENU"] == "Horarios")
										$Horarios = array("nombre" => $row["NOMBRE_MENU"], "permisos" => $row["PERMISO_MENU"], "menugrupo" => $row["CODIGO_MENUGRUPO"], "menu" => $row["CODIGO_MENU"]);
										
									ELSE IF($row["NOMBRE_MENU"] == "ReporteHorarios")
										$ReporteHorarios = array("nombre" => $row["NOMBRE_MENU"], "permisos" => $row["PERMISO_MENU"], "menugrupo" => $row["CODIGO_MENUGRUPO"], "menu" => $row["CODIGO_MENU"]);
										
									ELSE IF($row["NOMBRE_MENU"] == "Cronogramas")
										$Cronograma = array("nombre" => $row["NOMBRE_MENU"], "permisos" => $row["PERMISO_MENU"], "menugrupo" => $row["CODIGO_MENUGRUPO"], "menu" => $row["CODIGO_MENU"]);
										
									ELSE IF($row["NOMBRE_MENU"] == "ReporteCronogramas")
										$ReporteCronogramas = array("nombre" => $row["NOMBRE_MENU"], "permisos" => $row["PERMISO_MENU"], "menugrupo" => $row["CODIGO_MENUGRUPO"], "menu" => $row["CODIGO_MENU"]);	
									
									ELSE IF($row["NOMBRE_MENU"] == "ReportesAsistencia")
										$ReportesAsistencia = array("nombre" => $row["NOMBRE_MENU"], "permisos" => $row["PERMISO_MENU"], "menugrupo" => $row["CODIGO_MENUGRUPO"], "menu" => $row["CODIGO_MENU"]);	
										
									ELSE IF($row["NOMBRE_MENU"] == "ReporteAuditoria")
										$ReporteAuditoria = array("nombre" => $row["NOMBRE_MENU"], "permisos" => $row["PERMISO_MENU"], "menugrupo" => $row["CODIGO_MENUGRUPO"], "menu" => $row["CODIGO_MENU"]);	

										//echo $row["CODIGO_MENUGRUPO"].", ".$row["PERMISO_MENU"].", ".$row["NOMBRE_MENU"],"<br/>";
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
	<ul id="browser" class="filetree">
		<li>
			<img src="images/1323364110_Menu.png" /> 
			<span>Menu Desplegable</span>
			<ul>
				<li>
					<img src="images/1323362547_ui-menu.png" />
					<span><?php echo $Menu_Desplegable_Configurar_Sistema_Cambiar_Texto; ?></span>
					<a id="hrefcambiartexto" href="javascript:ModificarEstado(<?php echo $CambiarTexto["menugrupo"].",".$CambiarTexto["menu"].",".$primerGrupo.",".$CambiarTexto["permisos"]; ?>,'imgcambiartexto','hrefcambiartexto','<?php echo $CambiarTexto["nombre"];?>')">
						<img id="imgcambiartexto"
						<?php if ($CambiarTexto["permisos"] == 2){?>
						 src="images/1323365071_mail-new.png" />
						<?php }else if ($CambiarTexto["permisos"] == 1){ ?>
						 src="images/1323365078_document.png" />
						<?php }else{ ?>
						 src="images/1323365084_file-broken.png" />
						<?php } ?>
					</a>
				</li>
				<li>
					<img src="images/1323362547_ui-menu.png" />
					<span><?php echo $Menu_Desplegable_Configurar_Sistema_Logo_Empresarial; ?></span>
					<a id="hrefLogo" href="javascript:ModificarEstado(<?php echo $LogoEmpresarial["menugrupo"].",".$LogoEmpresarial["menu"].",".$primerGrupo.",".$LogoEmpresarial["permisos"]; ?>,'imgLogo','hrefLogo','<?php echo $LogoEmpresarial["nombre"];?>')">
						<img id="imgLogo"
						<?php if ($LogoEmpresarial["permisos"] == 2){?>
						 src="images/1323365071_mail-new.png" />
						<?php }else if ($LogoEmpresarial["permisos"] == 1){ ?>
						 src="images/1323365078_document.png" />
						<?php }else{ ?>
						 src="images/1323365084_file-broken.png" />
						<?php } ?>
					</a>
				</li>
			</ul>
		</li>
		<li>
			<img src="images/1323364110_Menu.png" /> 
			<span><?php echo $Menu_Principal_Administrar; ?></span>
			<ul>
				<li>
					<img src="images/1323362547_ui-menu.png" />
					<span><?php echo $Menu_Principal_Administrar_Datos_Generales; ?></span>
					<a id="hrefDatosGenerales" href="javascript:ModificarEstado(<?php echo $DatosGenerales["menugrupo"].",".$DatosGenerales["menu"].",".$primerGrupo.",".$DatosGenerales["permisos"]; ?>,'imgDatosGenerales','hrefDatosGenerales','<?php echo $DatosGenerales["nombre"];?>')">
						<img id="imgDatosGenerales"
						<?php if ($DatosGenerales["permisos"] == 2){?>
						 src="images/1323365071_mail-new.png" />
						<?php }else if ($DatosGenerales["permisos"] == 1){ ?>
						 src="images/1323365078_document.png" />
						<?php }else{ ?>
						 src="images/1323365084_file-broken.png" />
						<?php } ?>
					</a>
				</li>
				<li>
					<img src="images/1323362547_ui-menu.png" />
					<span><?php echo $Menu_Principal_Administrar_Roles; ?></span>
					<a id="hrefRoles" href="javascript:ModificarEstado(<?php echo $Roles["menugrupo"].",".$Roles["menu"].",".$primerGrupo.",".$Roles["permisos"]; ?>,'imgRoles','hrefRoles','<?php echo $Roles["nombre"];?>')">
						<img id="imgRoles"
						<?php if ($Roles["permisos"] == 2){?>
						 src="images/1323365071_mail-new.png" />
						<?php }else if ($Roles["permisos"] == 1){ ?>
						 src="images/1323365078_document.png" />
						<?php }else{ ?>
						 src="images/1323365084_file-broken.png" />
						<?php } ?>
					</a>
				</li>
				<li>
					<img src="images/1323362547_ui-menu.png" />
					<span><?php echo $Menu_Principal_Administrar_Usuarios; ?></span>
					<a id="hrefUsuarios" href="javascript:ModificarEstado(<?php echo $Usuarios["menugrupo"].",".$Usuarios["menu"].",".$primerGrupo.",".$Usuarios["permisos"]; ?>,'imgUsuarios','hrefUsuarios','imgRoles','hrefRoles','<?php echo $Usuarios["nombre"];?>')">
						<img id="imgUsuarios"
						<?php if ($Usuarios["permisos"] == 2){?>
						 src="images/1323365071_mail-new.png" />
						<?php }else if ($Usuarios["permisos"] == 1){ ?>
						 src="images/1323365078_document.png" />
						<?php }else{ ?>
						 src="images/1323365084_file-broken.png" />
						<?php } ?>
					</a>
				</li>
				<li>
					<img src="images/1323362547_ui-menu.png" />
					<span><?php echo $Menu_Principal_Administrar_Reporte_Usuarios; ?></span>
					<a id="hrefReporteUsuarios" href="javascript:ModificarEstado(<?php echo $ReporteUsuarios["menugrupo"].",".$ReporteUsuarios["menu"].",".$primerGrupo.",".$ReporteUsuarios["permisos"]; ?>,'imgReporteUsuarios','hrefReporteUsuarios','imgUsuarios','hrefUsuarios','imgRoles','hrefRoles','<?php echo $ReporteUsuarios["nombre"];?>')">
						<img id="imgReporteUsuarios"
						<?php if ($ReporteUsuarios["permisos"] == 2){?>
						 src="images/1323365071_mail-new.png" />
						<?php }else if ($ReporteUsuarios["permisos"] == 1){ ?>
						 src="images/1323365078_document.png" />
						<?php }else{ ?>
						 src="images/1323365084_file-broken.png" />
						<?php } ?>
					</a>
				</li>
				<li>
					<img src="images/1323362547_ui-menu.png" />
					<span><?php echo $Menu_Principal_Administrar_Areas; ?></span>
					<a id="hrefAreas" href="javascript:ModificarEstado(<?php echo $Areas["menugrupo"].",".$Areas["menu"].",".$primerGrupo.",".$Areas["permisos"]; ?>,'imgAreas','hrefAreas','imgRoles','hrefRoles','<?php echo $Areas["nombre"];?>')">
						<img id="imgAreas"
						<?php if ($Areas["permisos"] == 2){?>
						 src="images/1323365071_mail-new.png" />
						<?php }else if ($Areas["permisos"] == 1){ ?>
						 src="images/1323365078_document.png" />
						<?php }else{ ?>
						 src="images/1323365084_file-broken.png" />
						<?php } ?>
					</a>
				</li>
				<li>
					<img src="images/1323362547_ui-menu.png" />
					<span><?php echo $Menu_Principal_Administrar_Reporte_Areas; ?></span>
					<a id="hrefReporteAreas" href="javascript:ModificarEstado(<?php echo $ReporteAreas["menugrupo"].",".$ReporteAreas["menu"].",".$primerGrupo.",".$ReporteAreas["permisos"]; ?>,'imgReporteAreas','hrefReporteAreas','imgAreas','hrefAreas','imgRoles','hrefRoles','<?php echo $ReporteAreas["nombre"];?>')">
						<img id="imgReporteAreas"
						<?php if ($ReporteAreas["permisos"] == 2){?>
						 src="images/1323365071_mail-new.png" />
						<?php }else if ($ReporteAreas["permisos"] == 1){ ?>
						 src="images/1323365078_document.png" />
						<?php }else{ ?>
						 src="images/1323365084_file-broken.png" />
						<?php } ?>
					</a>
				</li>
			</ul>
		</li>
		<li>
			<img src="images/1323364110_Menu.png" /> 
			<span><?php echo $Menu_Principal_Empleados; ?></span>
			<ul>
				<li>
					<img src="images/1323362547_ui-menu.png" />
					<span><?php echo $Menu_Principal_Empleados_Mantenimiento; ?></span>
					<a id="hrefMantenimiento" href="javascript:ModificarEstado(<?php echo $Mantenimiento["menugrupo"].",".$Mantenimiento["menu"].",".$primerGrupo.",".$Mantenimiento["permisos"]; ?>,'imgMantenimiento','hrefMantenimiento','<?php echo $Mantenimiento["nombre"];?>')">
						<img id="imgMantenimiento"
						<?php if ($Mantenimiento["permisos"] == 2){?>
						 src="images/1323365071_mail-new.png" />
						<?php }else if ($Mantenimiento["permisos"] == 1){ ?>
						 src="images/1323365078_document.png" />
						<?php }else{ ?>
						 src="images/1323365084_file-broken.png" />
						<?php } ?>
					</a>
				</li>
				<li>
					<img src="images/1323362547_ui-menu.png" />
					<span><?php echo $Menu_Principal_Empleados_Reporte_Empleados; ?></span>
					<a id="hrefReporteEmpleados" href="javascript:ModificarEstado(<?php echo $ReporteEmpleados["menugrupo"].",".$ReporteEmpleados["menu"].",".$primerGrupo.",".$ReporteEmpleados["permisos"]; ?>,'imgReporteEmpleados','hrefReporteEmpleados','<?php echo $ReporteEmpleados["nombre"];?>')">
						<img id="imgReporteEmpleados"
						<?php if ($ReporteEmpleados["permisos"] == 2){?>
						 src="images/1323365071_mail-new.png" />
						<?php }else if ($ReporteEmpleados["permisos"] == 1){ ?>
						 src="images/1323365078_document.png" />
						<?php }else{ ?>
						 src="images/1323365084_file-broken.png" />
						<?php } ?>
					</a>
				</li>
				<li>
					<img src="images/1323362547_ui-menu.png" />
					<span><?php echo $Menu_Principal_Empleados_Mantenimiento_Permisos; ?></span>
					<a id="hrefPermisos" href="javascript:ModificarEstado(<?php echo $Permisos["menugrupo"].",".$Permisos["menu"].",".$primerGrupo.",".$Permisos["permisos"]; ?>,'imgPermisos','hrefPermisos','<?php echo $Permisos["nombre"];?>')">
						<img id="imgPermisos"
						<?php if ($Permisos["permisos"] == 2){?>
						 src="images/1323365071_mail-new.png" />
						<?php }else if ($Permisos["permisos"] == 1){ ?>
						 src="images/1323365078_document.png" />
						<?php }else{ ?>
						 src="images/1323365084_file-broken.png" />
						<?php } ?>
					</a>
				</li>
				<li>
					<img src="images/1323362547_ui-menu.png" />
					<span><?php echo $Menu_Principal_Empleados_Reporte_Permisos; ?></span>
					<a id="hrefReportePermisos" href="javascript:ModificarEstado(<?php echo $ReportePermisos["menugrupo"].",".$ReportePermisos["menu"].",".$primerGrupo.",".$ReportePermisos["permisos"]; ?>,'imgReportePermisos','hrefReportePermisos','<?php echo $ReportePermisos["nombre"];?>')">
						<img id="imgReportePermisos"
						<?php if ($ReportePermisos["permisos"] == 2){?>
						 src="images/1323365071_mail-new.png" />
						<?php }else if ($ReportePermisos["permisos"] == 1){ ?>
						 src="images/1323365078_document.png" />
						<?php }else{ ?>
						 src="images/1323365084_file-broken.png" />
						<?php } ?>
					</a>
				</li>
				
				<li>
					<img src="images/1323362547_ui-menu.png" />
					<span><?php echo $Menu_Principal_Empleados_Mantenimiento_Feriados; ?></span>
					<a id="hrefFeriados" href="javascript:ModificarEstado(<?php echo $Feriados["menugrupo"].",".$Feriados["menu"].",".$primerGrupo.",".$Feriados["permisos"]; ?>,'imgFeriados','hrefFeriados','<?php echo $Feriados["nombre"];?>')">
						<img id="imgFeriados"
						<?php if ($Feriados["permisos"] == 2){?>
						 src="images/1323365071_mail-new.png" />
						<?php }else if ($Feriados["permisos"] == 1){ ?>
						 src="images/1323365078_document.png" />
						<?php }else{ ?>
						 src="images/1323365084_file-broken.png" />
						<?php } ?>
					</a>
				</li>
				<li>
					<img src="images/1323362547_ui-menu.png" />
					<span><?php echo $Menu_Principal_Empleados_Reporte_Feriados; ?></span>
					<a id="hrefReporteFeriados" href="javascript:ModificarEstado(<?php echo $ReporteFeriados["menugrupo"].",".$ReporteFeriados["menu"].",".$primerGrupo.",".$ReporteFeriados["permisos"]; ?>,'imgReporteFeriados','hrefReporteFeriados','<?php echo $ReporteFeriados["nombre"];?>')">
						<img id="imgReporteFeriados"
						<?php if ($ReporteFeriados["permisos"] == 2){?>
						 src="images/1323365071_mail-new.png" />
						<?php }else if ($ReporteFeriados["permisos"] == 1){ ?>
						 src="images/1323365078_document.png" />
						<?php }else{ ?>
						 src="images/1323365084_file-broken.png" />
						<?php } ?>
					</a>
				</li>
			</ul>
		</li>
		<li>
			<img src="images/1323364110_Menu.png" /> 
			<span><?php echo $Menu_Principal_Asistencia; ?></span>
			<ul>
				<li>
					<img src="images/1323362547_ui-menu.png" />
					<span><?php echo $Menu_Principal_Asistencia_Horarios; ?></span>
					<a id="hrefHorarios" href="javascript:ModificarEstado(<?php echo $Horarios["menugrupo"].",".$Horarios["menu"].",".$primerGrupo.",".$Horarios["permisos"]; ?>,'imgHorarios','hrefHorarios','<?php echo $Horarios["nombre"];?>')">
						<img id="imgHorarios"
						<?php if ($Horarios["permisos"] == 2){?>
						 src="images/1323365071_mail-new.png" />
						<?php }else if ($Horarios["permisos"] == 1){ ?>
						 src="images/1323365078_document.png" />
						<?php }else{ ?>
						 src="images/1323365084_file-broken.png" />
						<?php } ?>
					</a>
				</li>
				<li>
					<img src="images/1323362547_ui-menu.png" />
					<span><?php echo $Menu_Principal_Asistencia_Reporte_Horarios; ?></span>
					<a id="hrefReporteHorarios" href="javascript:ModificarEstado(<?php echo $ReporteHorarios["menugrupo"].",".$ReporteHorarios["menu"].",".$primerGrupo.",".$ReporteHorarios["permisos"]; ?>,'imgReporteHorarios','hrefReporteHorarios','<?php echo $ReporteHorarios["nombre"];?>')">
						<img id="imgReporteHorarios"
						<?php if ($ReporteHorarios["permisos"] == 2){?>
						 src="images/1323365071_mail-new.png" />
						<?php }else if ($ReporteHorarios["permisos"] == 1){ ?>
						 src="images/1323365078_document.png" />
						<?php }else{ ?>
						 src="images/1323365084_file-broken.png" />
						<?php } ?>
					</a>
				</li>
				<li>
					<img src="images/1323362547_ui-menu.png" />
					<span><?php echo $Menu_Principal_Asistencia_Cronograma; ?></span>
					<a id="hrefCronograma" href="javascript:ModificarEstado(<?php echo $Cronograma["menugrupo"].",".$Cronograma["menu"].",".$primerGrupo.",".$Cronograma["permisos"]; ?>,'imgCronograma','hrefCronograma','<?php echo $Cronograma["nombre"];?>')">
						<img id="imgCronograma"
						<?php if ($Cronograma["permisos"] == 2){?>
						 src="images/1323365071_mail-new.png" />
						<?php }else if ($Cronograma["permisos"] == 1){ ?>
						 src="images/1323365078_document.png" />
						<?php }else{ ?>
						 src="images/1323365084_file-broken.png" />
						<?php } ?>
					</a>
				</li>
				<li>
					<img src="images/1323362547_ui-menu.png" />
					<span><?php echo $Menu_Principal_Asistencia_Reporte_Cronograma; ?></span>
					<a id="hrefReporteCronogramas" href="javascript:ModificarEstado(<?php echo $ReporteCronogramas["menugrupo"].",".$ReporteCronogramas["menu"].",".$primerGrupo.",".$ReporteCronogramas["permisos"]; ?>,'imgReporteCronogramas','hrefReporteCronogramas','<?php echo $ReporteCronogramas["nombre"];?>')">
						<img id="imgReporteCronogramas"
						<?php if ($ReporteCronogramas["permisos"] == 2){?>
						 src="images/1323365071_mail-new.png" />
						<?php }else if ($ReporteCronogramas["permisos"] == 1){ ?>
						 src="images/1323365078_document.png" />
						<?php }else{ ?>
						 src="images/1323365084_file-broken.png" />
						<?php } ?>
					</a>
				</li>
				<li>
					<img src="images/1323362547_ui-menu.png" />
					<span><?php echo $Menu_Principal_Administrar_Reporte_Registrar; ?></span>
					<a id="hrefModificarAsistencia" href="javascript:ModificarEstado(<?php echo $ModificarAsistencia["menugrupo"].",".$ModificarAsistencia["menu"].",".$primerGrupo.",".$ModificarAsistencia["permisos"]; ?>,'imgModificarAsistencia','hrefModificarAsistencia','<?php echo $ModificarAsistencia["nombre"];?>')">
						<img id="imgModificarAsistencia"
						<?php if ($ModificarAsistencia["permisos"] == 2){?>
						 src="images/1323365071_mail-new.png" />
						<?php }else if ($ModificarAsistencia["permisos"] == 1){ ?>
						 src="images/1323365078_document.png" />
						<?php }else{ ?>
						 src="images/1323365084_file-broken.png" />
						<?php } ?>
					</a>
				</li>
				<li>
					<img src="images/1323362547_ui-menu.png" />
					<span><?php echo $Menu_Principal_Asistencia_Subtitulo_Registrar; ?></span>
					<a id="hrefCargaAsisetencia" href="javascript:ModificarEstado(<?php echo $CargaArchivo["menugrupo"].",".$CargaArchivo["menu"].",".$primerGrupo.",".$CargaArchivo["permisos"]; ?>,'imgCargaAsisetencia','hrefCargaAsisetencia','<?php echo $CargaArchivo["nombre"];?>')">
						<img id="imgCargaAsisetencia"
						<?php if ($CargaArchivo["permisos"] == 2){?>
						 src="images/1323365071_mail-new.png" />
						<?php }else if ($CargaArchivo["permisos"] == 1){ ?>
						 src="images/1323365078_document.png" />
						<?php }else{ ?>
						 src="images/1323365084_file-broken.png" />
						<?php } ?>
					</a>
				</li>
				<li>
					<img src="images/1323362547_ui-menu.png" />
					<span><?php echo $Menu_Principal_Asistencia_Reportes; ?></span>
					<a id="hrefReportesAsistencia" href="javascript:ModificarEstado(<?php echo $ReportesAsistencia["menugrupo"].",".$ReportesAsistencia["menu"].",".$primerGrupo.",".$ReportesAsistencia["permisos"]; ?>,'imgReportesAsistencia','hrefReportesAsistencia','<?php echo $ReportesAsistencia["nombre"];?>')">
						<img id="imgReportesAsistencia"
						<?php if ($ReportesAsistencia["permisos"] == 2){?>
						 src="images/1323365071_mail-new.png" />
						<?php }else if ($ReportesAsistencia["permisos"] == 1){ ?>
						 src="images/1323365078_document.png" />
						<?php }else{ ?>
						 src="images/1323365084_file-broken.png" />
						<?php } ?>
					</a>
				</li>
			</ul>
		</li>
		<li>
			<img src="images/1323364110_Menu.png" /> 
			<span><?php echo $Menu_Principal_Auditoria; ?></span>
			<ul>
				<li>
					<img src="images/1323362547_ui-menu.png" />
					<span><?php echo $Menu_Principal_Auditoria_Reporte; ?></span>
					<a id="hrefReporteAuditoria" href="javascript:ModificarEstado(<?php echo $ReporteAuditoria["menugrupo"].",".$ReporteAuditoria["menu"].",".$primerGrupo.",".$ReporteAuditoria["permisos"]; ?>,'imgReporteAuditoria','hrefReporteAuditoria','<?php echo $ReporteAuditoria["nombre"];?>')">
						<img id="imgReporteAuditoria"
						<?php if ($ReporteAuditoria["permisos"] == 2){?>
						 src="images/1323365071_mail-new.png" />
						<?php }else if ($ReporteAuditoria["permisos"] == 1){ ?>
						 src="images/1323365078_document.png" />
						<?php }else{ ?>
						 src="images/1323365084_file-broken.png" />
						<?php } ?>
					</a>
				</li>
			</ul>
		</li>
	</ul>
		
 
</body></html>
