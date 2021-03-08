<?php
	require_once("comun/compruebasesion.php");
	if($sesion->get("CambiarTexto"))
		$cambiarTexto_permisos = $sesion->get("CambiarTexto");
	else 
		$cambiarTexto_permisos = 0;
		
	if($sesion->get("LogoEmpresarial"))
		$logoEmpresarial_permisos = $sesion->get("LogoEmpresarial");
	else
	 	$logoEmpresarial_permisos = 0;

	if($sesion->get("DatosGenerales"))
		$datosGenerales_permisos = $sesion->get("DatosGenerales");
	else
		$datosGenerales_permisos = 0;
	if($sesion->get("Usuarios"))	
		$usuarios_permisos = $sesion->get("Usuarios");
	else 
		$usuarios_permisos =0 ;
		
	if($sesion->get("ReporteUsuarios"))
		$reporteUsuarios_permisos = $sesion->get("ReporteUsuarios");
	else 
		$reporteUsuarios_permisos = 0;
		
	if($sesion->get("CargaArchivo"))
		$cargaArchivos_permisos = $sesion->get("CargaArchivo");
	else 
		$cargaArchivos_permisos = 0;

	if($sesion->get("ModificarAsistencia"))
		$modificarAsistencia = $sesion->get("ModificarAsistencia");
	else 
		$modificarAsistencia = 0;
		
	if($sesion->get("Roles"))
		$roles_permisos = $sesion->get("Roles");
	else 
		$roles_permisos = 0;
		
	if($sesion->get("Auditoria"))
		$auditoria = $sesion->get("Auditoria");
	else 
		$auditoria = 0;
	
	if($sesion->get("Empleados"))
		$empleados_permisos = $sesion->get("Empleados");
	else 
		$empleados_permisos = 0;
	
	if($sesion->get("Mantenimiento"))
		$mantenimiento_permisos = $sesion->get("Mantenimiento");
	else 
		$mantenimiento_permisos = 0;
	
	if($sesion->get("ReporteEmpleados"))
		$reporteEmpleados_permisos = $sesion->get("ReporteEmpleados");
	else 
		$reporteEmpleados_permisos = 0;
		
	if($sesion->get("Permisos"))
		$modificarPermisos = $sesion->get("Permisos");
	else 
		$modificarPermisos = 0;
	
	if($sesion->get("ReportePermisos"))
		$reportePermisos = $sesion->get("ReportePermisos");
	else 
		$reportePermisos = 0;
	
	if($sesion->get("Feriados"))
		$modificarFeriados = $sesion->get("Feriados");
	else 
		$modificarFeriados = 0;
	
	if($sesion->get("ReporteFeriados"))
		$reporteFeriados = $sesion->get("ReporteFeriados");
	else 
		$reporteFeriados = 0;
		
	if($sesion->get("Horarios"))
		$modificarHorarios = $sesion->get("Horarios");
	else 
		$modificarHorarios = 0;
	
	if($sesion->get("ReporteHorarios"))
		$reporteHorarios = $sesion->get("ReporteHorarios");
	else 
		$reporteHorarios = 0;
		
	if($sesion->get("Cronogramas"))
		$modificarCronogramas = $sesion->get("Cronogramas");
	else 
		$modificarCronogramas = 0;
	
	if($sesion->get("ReporteCronogramas"))
		$reporteCronogramas = $sesion->get("ReporteCronogramas");
	else 
		$reporteCronogramas = 0;
		
	if($sesion->get("ReportesAsistencia"))
		$reportesAsistencia = $sesion->get("ReportesAsistencia");
	else 
		$reportesAsistencia = 0;
		
	if($sesion->get("ReporteAuditoria"))
		$reporteAuditoria = $sesion->get("ReporteAuditoria");
	else 
		$reporteAuditoria = 0;
		
	if($sesion->get("Areas"))
		$modificarAreas = $sesion->get("Areas");
	else 
		$modificarAreas = 0;
	
	if($sesion->get("ReporteAreas"))
		$reporteAreas = $sesion->get("ReporteAreas");
	else 
		$reporteAreas = 0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=8" />
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
    <title>jQuery ribbon</title>
    <script src="scripts/jquery.js" type="text/javascript"></script>
    <script src="scripts/jquery.ribbon.js" type="text/javascript"></script>
    <script src="scripts/page.js" type="text/javascript"></script>
    <link href="estilo/estilo.css" rel="Stylesheet" type="text/css" />
    <link type="text/css" href="estilo/jquery.toastmessage.css" rel="stylesheet"/>
    <script type="text/javascript" src="scripts/jquery.toastmessage.js"></script>
    <script type="text/javascript" src="scripts/mensajes.js"></script>
    <script type="text/javascript">
	function altoIframe(){
	 var heightViewport;
		if (typeof window.innerWidth != 'undefined')
		{
			//widthViewport= window.innerWidth;
			heightViewport= window.innerHeight;
		}
		else if(typeof document.documentElement != 'undefined' && typeof document.documentElement.clientWidth !='undefined' && document.documentElement.clientWidth != 0)
		{
			//widthViewport=document.documentElement.clientWidth;
			heightViewport=document.documentElement.clientHeight;
		}
		else{
			//widthViewport= document.getElementsByTagName('body')[0].clientWidth;
			heightViewport=document.getElementsByTagName('body')[0].clientHeight;
		}
		return heightViewport;
	}
	
	function anchoIframe(){
	var widthViewport;
		if (typeof window.innerWidth != 'undefined')
		{
			widthViewport= window.innerWidth;
			//heightViewport= window.innerHeight;
		}
		else if(typeof document.documentElement != 'undefined' && typeof document.documentElement.clientWidth !='undefined' && document.documentElement.clientWidth != 0)
		{
			widthViewport=document.documentElement.clientWidth;
			//heightViewport=document.documentElement.clientHeight;
		}
		else{
			widthViewport= document.getElementsByTagName('body')[0].clientWidth;
			//heightViewport=document.getElementsByTagName('body')[0].clientHeight;
		}
		return widthViewport;
	}

		$(function(){
			$(document).ready(function() {
				var alto = altoIframe() - 125;
				var altostring = alto + "px";
				$("#iframeMenu").attr({ 
					height: altostring
				});
			});
			$("#cambiar_texto").click(function(){
					<?php 
                		if($cambiarTexto_permisos == 0){
                	?>
                		mostrarerroregajoso('No tiene permisos para acceder a este menu');
                	<?php }else{?>
						$("#iframeMenu").attr({ 
						  src: "cambiartexto.php"
						});
					<?php }?>
			});
			$("#datos_empresa").click(function(){
					<?php 
                		if($datosGenerales_permisos == 0){
                	?>
                		mostrarerroregajoso('No tiene permisos para acceder a este menu');
                	<?php }else{?>
                		$("#iframeMenu").attr({ 
    					  src: "datosGenereralesEmpresa.php"
    					});
                    <?php }?>
					
			});
			$("#logo_empresa").click(function(){
					<?php 
                		if($logoEmpresarial_permisos == 0){
                	?>
                		mostrarerroregajoso('No tiene permisos para acceder a este menu');
                	<?php }else{?>
						$("#iframeMenu").attr({ 
						  src: "uploadfoto.php"
						});
					<?php }?>	
			});
			$("#menu_usuarios").click(function(){
					<?php 
                		if($usuarios_permisos == 0){
                	?>
                		mostrarerroregajoso('No tiene permisos para acceder a este menu');
                	<?php }else{?>
						$("#iframeMenu").attr({ 
						  src: "usuarios.php"
						});
					<?php }?>
			});
			$("#menu_roles").click(function(){
					<?php 
                		if($roles_permisos == 0){
                	?>
                		mostrarerroregajoso('No tiene permisos para acceder a este menu');
                	<?php }else{?>
						$("#iframeMenu").attr({ 
						  src: "roles.php"
						});
					<?php }?>
			});
			
			$("#menu_imprimir_usuarios").click(function(){
					<?php 
                		if($reporteUsuarios_permisos == 0){
                	?>
                		mostrarerroregajoso('No tiene permisos para acceder a este menu');
                	<?php }else{?>
						window.open('usuariosreportes.php','Reporte Usuarios','');
					<?php }?>
			});
			$("#cargarArchivo").click(function(){
					<?php 
                		if($cargaArchivos_permisos == 0){
                	?>
                		mostrarerroregajoso('No tiene permisos para acceder a este menu');
                	<?php }else{?>
						$("#iframeMenu").attr({ 
							  src: "uploadAsistencia.php"
						});
					<?php }?>
			});
			$("#empleados").click(function(){
					<?php 
                		if($empleados_permisos == 0){
                	?>
                		mostrarerroregajoso('No tiene permisos para acceder a este menu');
                	<?php }else{?>
						$("#iframeMenu").attr({ 
							  src: "empleados.php"
						});
					<?php }?>
			});
			$("#menu_empleados").click(function(){
					<?php 
                		if($mantenimiento_permisos == 0){
                	?>
                		mostrarerroregajoso('No tiene permisos para acceder a este menu');
                	<?php }else{?>
						$("#iframeMenu").attr({ 
							  src: "empleados.php"
						});
					<?php }?>
			});
			$("#menu_imprimir_empleados").click(function(){
					<?php 
                		if($reporteEmpleados_permisos == 0){
                	?>
                		mostrarerroregajoso('No tiene permisos para acceder a este menu');
                	<?php }else{?>
						window.open('empleadosreportes.php','Reporte Empleados','');
					<?php }?>
			});
			
			$("#modificarAsistencia").click(function(){
					<?php 
                		if($modificarAsistencia == 0){
                	?>
                		mostrarerroregajoso('No tiene permisos para acceder a este menu');
                	<?php }else{?>
						$("#iframeMenu").attr({ 
							  src: "asistencias.php"
							});
					<?php }?>
			});
			$("#menu_permisos").click(function(){
					<?php 
                		if($modificarPermisos == 0){
                	?>
                		mostrarerroregajoso('No tiene permisos para acceder a este menu');
                	<?php }else{?>
						$("#iframeMenu").attr({ 
							  src: "permisos.php"
							});
					<?php }?>
			});
			$("#menu_imprimir_permisos").click(function(){
					<?php 
                		if($reportePermisos == 0){
                	?>
                		mostrarerroregajoso('No tiene permisos para acceder a este menu');
                	<?php }else{?>
						window.open('permisosreportes.php','Reporte Permisos','');
					<?php }?>
			});
			
			$("#menu_feriados").click(function(){
					<?php 
                		if($modificarFeriados == 0){
                	?>
                		mostrarerroregajoso('No tiene permisos para acceder a este menu');
                	<?php }else{?>
						$("#iframeMenu").attr({ 
							  src: "feriados.php"
							});
					<?php }?>
			});
			$("#menu_imprimir_feriados").click(function(){
					<?php 
                		if($reporteFeriados == 0){
                	?>
                		mostrarerroregajoso('No tiene permisos para acceder a este menu');
                	<?php }else{?>
						window.open('feriadosreportes.php','Reporte Feriados','');
					<?php }?>
			});
			
			$("#Auditoria").click(function(){
					<?php 
                		if($modificarAuditoria == 0){
                	?>
                		mostrarerroregajoso('No tiene permisos para acceder a este menu');
                	<?php }else{?>
						$("#iframeMenu").attr({ 
							  src: "reportesAuditoria.php"
							});
					<?php }?>
			});
			
			$("#menu_horarios").click(function(){
					<?php 
                		if($modificarHorarios == 0){
                	?>
                		mostrarerroregajoso('No tiene permisos para acceder a este menu');
                	<?php }else{?>
						$("#iframeMenu").attr({ 
							  src: "horarios.php"
							});
					<?php }?>
			});
			$("#menu_imprimir_horarios").click(function(){
					<?php 
                		if($reporteHorarios == 0){
                	?>
                		mostrarerroregajoso('No tiene permisos para acceder a este menu');
                	<?php }else{?>
						window.open('horariosreportes.php','Reporte Horarios','');
					<?php }?>
			});
			
			$("#menu_cronogramas").click(function(){
					<?php 
                		if($modificarCronogramas == 0){
                	?>
                		mostrarerroregajoso('No tiene permisos para acceder a este menu');
                	<?php }else{?>
						$("#iframeMenu").attr({ 
							  src: "cronograma.php"
							});
					<?php }?>
			});
			$("#menu_imprimir_cronogramas").click(function(){
					<?php 
                		if($reporteCronogramas == 0){
                	?>
                		mostrarerroregajoso('No tiene permisos para acceder a este menu');
                	<?php }else{?>
						window.open('cronogramasreportes.php','Reporte Cronogramas','');
					<?php }?>
			});
			
			$("#reportesAsistencia").click(function(){
					<?php 
                		if($reportesAsistencia == 0){
                	?>
                		mostrarerroregajoso('No tiene permisos para acceder a este menu');
                	<?php }else{?>
						window.open('reportesAsistencias.php','Reportes Asistencia','');
					<?php }?>
			});
			
			$("#reporteAuditoria").click(function(){
					<?php 
                		if($reporteAuditoria == 0){
                	?>
                		mostrarerroregajoso('No tiene permisos para acceder a este menu');
                	<?php }else{?>
						window.open('reportesAuditoria.php','Reportes Auditoria','');
					<?php }?>
			});
			
			
			$("#menu_areas").click(function(){
					<?php 
                		if($modificarAreas == 0){
                	?>
                		mostrarerroregajoso('No tiene permisos para acceder a este menu');
                	<?php }else{?>
						$("#iframeMenu").attr({ 
							  src: "areas.php"
							});
					<?php }?>
			});
			$("#menu_imprimir_areas").click(function(){
					<?php 
                		if($reporteAreas == 0){
                	?>
                		mostrarerroregajoso('No tiene permisos para acceder a este menu');
                	<?php }else{?>
						window.open('areasreportes.php','Reporte Areas','');
					<?php }?>
			});
			
			$("#ayuda").click(function(){
				$("#iframeMenu").attr({ 
					  src: "manual.pdf"
					});
			});
			
			$("#acercaDe").click(function(){
				$("#iframeMenu").attr({ 
					  src: "acercade.php"
					});
			});
		});
	</script>
</head>
<body>
<?php 
	include_once("estilo/textos.php");
?>
<div class="mainContainer">
        <ul class="ribbon">
            <li>
                <ul class="orb">
                    <li><a href="javascript:void(0);" accesskey="1" class="orbButton">&nbsp;</a><span>Menu</span>
                        <ul>
                        
                                    <li>
                                    	<a id="cambiar_texto" href="#">
                                        <img src="ribbon/images/1322860350_openofficeorg-draw.png" alt="Cambiar texto" /><span><?php echo $Menu_Desplegable_Configurar_Sistema_Cambiar_Texto; ?></span></a>
                                        
                                    </li>
                                    <li>
                                    	<a id="logo_empresa" href="#">
                                        <img src="ribbon/images/icon_picture.png" alt="Logo" /><span><?php echo $Menu_Desplegable_Configurar_Sistema_Logo_Empresarial; ?></span></a>                                    </li>
                                
                        </ul>
                  </li>
                </ul>
            </li>
            <li>
                <ul class="menu">
                    <li><a href="#administrar" accesskey="2"><?php echo $Menu_Principal_Administrar; ?></a>
                        <ul>
                            <li>
                                <h2>
                                    <span><?php echo $Menu_Principal_Administrar_Subtitulo_Empresa; ?></span></h2>
                                <div id="datos_empresa">
                                	<img src="ribbon/images/1322861243_redhat-home.png" alt="Paste" width="32" height="32" /><?php echo $Menu_Principal_Administrar_Datos_Generales; ?> 
                                    </div>
                                 <!-- <div>
                                    <img src="ribbon/images/1322861471_sitemap.png" alt="Paste" width="32" height="32" />Organigrama</div>-->
						  </li>
                            <li>
                                <h2>
                                    <span><?php echo $Menu_Principal_Administrar_Subtitulo_Rol; ?></span></h2>
                                <div id="menu_roles">
                                    <img src="ribbon/images/1323463666_user_group.png" alt="Date and time" width="32" height="32" /><?php echo $Menu_Principal_Administrar_Roles ?></div>
                                
                            </li>    
                            <li>
                                <h2>
                                    <span><?php echo $Menu_Principal_Administrar_Subtitulo_Usuarios; ?></span></h2>    
                                <div id="menu_usuarios">
                                    <img src="ribbon/images/1323463670_user.png" alt="Picture" width="32" height="32" />
                                    <?php echo $Menu_Principal_Administrar_Usuarios; ?></div>
                                <div id="menu_imprimir_usuarios">
                                    <img src="ribbon/images/1322860389_x-office-spreadsheet.png" alt="Picture" width="32" height="32" />
                                    <?php echo $Menu_Principal_Administrar_Reporte_Usuarios; ?></div>
                          </li>
						  <li>
								<h2>
									<span><?php echo $Menu_Principal_Administrar_Subtitulo_Areas; ?></span></h2>
								<div id="menu_areas">
									<img src="ribbon/images/1322861471_sitemap.png" alt="Picture" width="32" height="32" />
									<?php echo $Menu_Principal_Administrar_Areas; ?></div>
								<div id="menu_imprimir_areas">
									<img src="ribbon/images/1322860389_x-office-spreadsheet.png" alt="Picture" width="32" height="32" />
									<?php echo $Menu_Principal_Administrar_Reporte_Areas; ?></div>
							</li>
                        </ul>
                    </li>
					<li><a href="#empleados" accesskey="3"><?php echo $Menu_Principal_Empleados; ?></a>
                        <ul>
                            <li>
                                <h2>
                                    <span><?php echo $Menu_Principal_Empleados_Subtitulo_Empleados; ?></span></h2>
                                <div id="menu_empleados">
                                    <img src="ribbon/images/male_users.png" alt="Picture" width="32" height="32" />
                                    <?php echo $Menu_Principal_Empleados_Mantenimiento; ?></div>
                                <div id="menu_imprimir_empleados">
                                    <img src="ribbon/images/1322860389_x-office-spreadsheet.png" alt="Picture" width="32" height="32" />
                                    <?php echo $Menu_Principal_Empleados_Reporte_Empleados; ?></div>
								
								
							</li>
							
							<li>
                                <h2>
                                    <span><?php echo $Menu_Principal_Empleados_Subtitulo_Permisos; ?></span></h2>
                                <div id="menu_permisos">
                                    <img src="ribbon/images/male_users_comments.png" alt="Picture" width="32" height="32" />
                                    <?php echo $Menu_Principal_Empleados_Mantenimiento_Permisos; ?></div>
                                <div id="menu_imprimir_permisos">
                                    <img src="ribbon/images/1322860389_x-office-spreadsheet.png" alt="Picture" width="32" height="32" />
                                    <?php echo $Menu_Principal_Empleados_Reporte_Permisos; ?></div>
							</li>
							
							<li>
                                <h2>
                                    <span><?php echo $Menu_Principal_Empleados_Subtitulo_Feriados; ?></span></h2>
                                <div id="menu_feriados">
                                    <img src="ribbon/images/1322860634_config-date.png" alt="Picture" width="32" height="32" />
                                    <?php echo $Menu_Principal_Empleados_Mantenimiento_Feriados; ?></div>
                                <div id="menu_imprimir_feriados">
                                    <img src="ribbon/images/1322860389_x-office-spreadsheet.png" alt="Picture" width="32" height="32" />
                                    <?php echo $Menu_Principal_Empleados_Reporte_Feriados; ?></div>
							</li>
                        </ul>
                    </li>
					<li><a href="#asistencia" accesskey="4"><?php echo $Menu_Principal_Asistencia; ?></a>
                        <ul>
                            <li>
                                <h2>
                                    <span><?php echo $Menu_Principal_Asistencia_Subtitulo_Horarios; ?></span></h2>
                                <div id = "menu_horarios">
                                    <img src="ribbon/images/1322860380_preferences-calendar-and-tasks.png" alt="Paste" width="32" height="31" /><?php echo $Menu_Principal_Asistencia_Horarios; ?></div>
								<div id="menu_imprimir_horarios">
									<img src="ribbon/images/1322860389_x-office-spreadsheet.png" alt="Picture" width="32" height="32" />
									<?php echo $Menu_Principal_Asistencia_Reporte_Horarios; ?></div>
							</li>
							<li>
                                <h2>
                                    <span><?php echo $Menu_Principal_Asistencia_Subtitulo_Cronograma; ?></span></h2>
                                <div id = "menu_cronogramas">
                                    <img src="ribbon/images/icon_datetime.png" alt="Paste" width="32" height="31" /><?php echo $Menu_Principal_Asistencia_Cronograma; ?></div>
								<div id="menu_imprimir_cronogramas">
									<img src="ribbon/images/1322860389_x-office-spreadsheet.png" alt="Picture" width="32" height="32" />
									<?php echo $Menu_Principal_Asistencia_Reporte_Cronograma; ?></div>
							</li>
                            <li>
                                <h2><?php echo $Menu_Principal_Asistencia_Subtitulo_Registrar; ?><span></span></h2>
                                <div id="cargarArchivo">
                                    <img src="ribbon/images/1322861561_future-projects.png" alt="Paste" width="32" height="32" /><?php echo $Menu_Principal_Asistencia_General; ?></div>
								
								<div id="modificarAsistencia">
                                    <img src="ribbon/images/1322861006_notebook.png" alt="Picture" width="32" height="32" />
                                    <?php echo $Menu_Principal_Asistencia_Modificar_Registros; ?></div>
                                    <div id="reportesAsistencia">
                                    <img src="ribbon/images/1322860389_x-office-spreadsheet.png" alt="Picture" width="32" height="32" />
                                    <?php echo "Reportes" ?></div>
                            </li>
                        </ul>
                    </li>
					
					<li><a href="#auditoria" accesskey="5"><?php echo $Menu_Principal_Auditoria; ?></a>
						<ul>
							<li>
								<div id="reporteAuditoria">
                                    <img src="ribbon/images/1322860389_x-office-spreadsheet.png" alt="Picture" width="32" height="32" />
                                    <?php echo "Reportes" ?>
								</div>
							</li>
						</ul>
					</li>
					
                    <li><a href="#ayuda" accesskey="6"><?php echo $Menu_Principal_Ayuda; ?></a>
                        <ul>
					      <li>
                                <h2>
                                    <span><?php echo $Menu_Principal_Ayuda_Subtitulo_Ayuda; ?></span></h2>
                              <div id = "ayuda">
                                  <img src="ribbon/images/1322971120_help.png" alt="Paste" width="32" height="32" /><?php echo $Menu_Principal_Ayuda_Ayuda; ?></div>
							<div id = "acercaDe">
                            <img src="ribbon/images/1322974961_dialog-information.png" alt="Paste" width="32" height="32" /><?php echo $Menu_Principal_Ayuda_Acerca_de; ?></div>
						  </li>
								
                        </ul>
                    </li>
            </li>
        </ul>
</div>
<div style="padding-left:10px ;padding-right:10px">
	<iframe id="iframeMenu" src="logoempresarial.php" topmargin='0' leftmargin='0' frameborder='0' marginwidth='0' hspace='0' vspace='0' width='100%'></iframe>   
</div>
</body>
</html>