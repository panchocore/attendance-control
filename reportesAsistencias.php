<?php
	require_once("comun/compruebasesion.php");
	
	$usuario = $sesion->get("nombreusuario");
	if($sesion->get("ReportesAsistencia"))
		$obtener_permisos = $sesion->get("ReportesAsistencia");
	else 
		$obtener_permisos = 0;
	
	if($obtener_permisos == 0)
		header("Location: finsesion.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		
		<title>Reportes</title>
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

   			$( "input:submit, input:button, a" ).button();
			$( "#comboSelecionaEmpleado" ).combobox();
			$( "#selectArea" ).combobox({
					selected: function(event, ui) {
						recargarEmpleados();
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
			$('#horaAsistenciaFin').timepicker({
				hourGrid: 4,
				minuteGrid: 10,
				timeOnlyTitle: 'Seleccione la hora',
				timeText: 'Hora/Minutos : ',
				hourText: 'Hora',
				minuteText: 'Minutos',
				secondText: 'Segundos',
				currentText: 'Hora actual',
				closeText: 'Listo'
				});
			$('#FechaAsistenciaFin').datepicker({
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
			$( "#toggle" ).click(function() {
				$( "#comboSelecionaEmpleado" ).toggle();
				$( "#selectArea" ).toggle();
			});

			$("#reporteGeneralAsistencias").click(function(){
				var area = $('#selectArea').val();
				var empleado = $('#comboSelecionaEmpleado').val();
			    var hora = $.trim($('#horaAsistencia').val());
			    var fecha = $('#FechaAsistencia').val();
			    var horafin = $.trim($('#horaAsistenciaFin').val());
			    var fechafin = $('#FechaAsistenciaFin').val();
			    
				window.open('reporteGeneralAsistencias.php?empleado='+empleado+'&hora='+hora+'&fecha='+fecha+'&horafin='+horafin+'&fechafin='+fechafin+'&area='+area ,'Reporte General Asistencias','');
			});

			$("#reporteAsistenciasEntradas").click(function(){
				var area = $('#selectArea').val();
				var empleado = $('#comboSelecionaEmpleado').val();
			    var hora = $.trim($('#horaAsistencia').val());
			    var fecha = $('#FechaAsistencia').val();
			    var horafin = $.trim($('#horaAsistenciaFin').val());
			    var fechafin = $('#FechaAsistenciaFin').val();
				window.open('reporteAsistenciasEntradas.php?empleado='+empleado+'&hora='+hora+'&fecha='+fecha+'&horafin='+horafin+'&fechafin='+fechafin+'&area='+area,'Reporte Entradas','');
			});

			$("#reporteAsistenciasSalidas").click(function(){
				var area = $('#selectArea').val();
				var empleado = $('#comboSelecionaEmpleado').val();
			    var hora = $.trim($('#horaAsistencia').val());
			    var fecha = $('#FechaAsistencia').val();
			    var horafin = $.trim($('#horaAsistenciaFin').val());
			    var fechafin = $('#FechaAsistenciaFin').val();
				window.open('reporteAsistenciasSalidas.php?empleado='+empleado+'&hora='+hora+'&fecha='+fecha+'&horafin='+horafin+'&fechafin='+fechafin+'&area='+area,'Reporte Salidas','');
			});

			$("#reporteAsistenciasAtrasos").click(function(){
				var area = $('#selectArea').val();
				var empleado = $('#comboSelecionaEmpleado').val();
			    var hora = $.trim($('#horaAsistencia').val());
			    var fecha = $('#FechaAsistencia').val();
			    var horafin = $.trim($('#horaAsistenciaFin').val());
			    var fechafin = $('#FechaAsistenciaFin').val();
				window.open('reporteAsistenciasAtrasos.php?empleado='+empleado+'&hora='+hora+'&fecha='+fecha+'&horafin='+horafin+'&fechafin='+fechafin+'&area='+area,'Atrasos','');
			});

			$("#reporteAsistenciasSobretiempo").click(function(){
				var area = $('#selectArea').val();
				var empleado = $('#comboSelecionaEmpleado').val();
			    var hora = $.trim($('#horaAsistencia').val());
			    var fecha = $('#FechaAsistencia').val();
			    var horafin = $.trim($('#horaAsistenciaFin').val());
			    var fechafin = $('#FechaAsistenciaFin').val();
				window.open('reporteAsistenciasSobretiempo.php?empleado='+empleado+'&hora='+hora+'&fecha='+fecha+'&horafin='+horafin+'&fechafin='+fechafin+'&area='+area,'Reporte Sobretiempos','');
			});
			
			$("#reporteAsistenciasAtrasosTotales").click(function(){
				var area = $('#selectArea').val();
				var empleado = $('#comboSelecionaEmpleado').val();
			    var hora = $.trim($('#horaAsistencia').val());
			    var fecha = $('#FechaAsistencia').val();
			    var horafin = $.trim($('#horaAsistenciaFin').val());
			    var fechafin = $('#FechaAsistenciaFin').val();
				window.open('reporteAsistenciasAtrasosTotal.php?empleado='+empleado+'&hora='+hora+'&fecha='+fecha+'&horafin='+horafin+'&fechafin='+fechafin+'&area='+area,'Reporte Sobretiempos','');
			});
			
			$("#graficaAsistenciasAtrasosTotales").click(function(){
				var area = $('#selectArea').val();
				var empleado = $('#comboSelecionaEmpleado').val();
			    var hora = $.trim($('#horaAsistencia').val());
			    var fecha = $('#FechaAsistencia').val();
			    var horafin = $.trim($('#horaAsistenciaFin').val());
			    var fechafin = $('#FechaAsistenciaFin').val();
				window.open('graficoAsistenciasAtrasosTotal.php?empleado='+empleado+'&hora='+hora+'&fecha='+fecha+'&horafin='+horafin+'&fechafin='+fechafin+'&area='+area,'Reporte Sobretiempos','');
			});
			$("#reporteAsistenciasLunch").click(function(){
				var area = $('#selectArea').val();
				var empleado = $('#comboSelecionaEmpleado').val();
			    var hora = $.trim($('#horaAsistencia').val());
			    var fecha = $('#FechaAsistencia').val();
			    var horafin = $.trim($('#horaAsistenciaFin').val());
			    var fechafin = $('#FechaAsistenciaFin').val();
				window.open('reporteAsistenciasLunch.php?empleado='+empleado+'&hora='+hora+'&fecha='+fecha+'&horafin='+horafin+'&fechafin='+fechafin+'&area='+area,'Reporte de Lunch','');
			});
			
			$("#reporteAsistenciasPermisos").click(function(){
				var area = $('#selectArea').val();
				var empleado = $('#comboSelecionaEmpleado').val();
			    var hora = $.trim($('#horaAsistencia').val());
			    var fecha = $('#FechaAsistencia').val();
			    var horafin = $.trim($('#horaAsistenciaFin').val());
			    var fechafin = $('#FechaAsistenciaFin').val();
				window.open('reporteAsistenciasPermisos.php?empleado='+empleado+'&hora='+hora+'&fecha='+fecha+'&horafin='+horafin+'&fechafin='+fechafin+'&area='+area,'Reporte de Permisos','');
			});
			
			$("#reporteAsistenciasFeriados").click(function(){
				var area = $('#selectArea').val();
				var empleado = $('#comboSelecionaEmpleado').val();
			    var hora = $.trim($('#horaAsistencia').val());
			    var fecha = $('#FechaAsistencia').val();
			    var horafin = $.trim($('#horaAsistenciaFin').val());
			    var fechafin = $('#FechaAsistenciaFin').val();
				window.open('reporteAsistenciasFeriados.php?empleado='+empleado+'&hora='+hora+'&fecha='+fecha+'&horafin='+horafin+'&fechafin='+fechafin+'&area='+area,'Reporte de Permisos','');
			});
			
			$("#reporteMRL").click(function(){
				var area = $('#selectArea').val();
				var empleado = $('#comboSelecionaEmpleado').val();
			    var hora = $.trim($('#horaAsistencia').val());
			    var fecha = $('#FechaAsistencia').val();
			    var horafin = $.trim($('#horaAsistenciaFin').val());
			    var fechafin = $('#FechaAsistenciaFin').val();
				window.open('reporteMRL.php?empleado='+empleado+'&hora='+hora+'&fecha='+fecha+'&horafin='+horafin+'&fechafin='+fechafin+'&area='+area,'Reporte de Permisos','');
			});
			
		});

   		$(document).ready(function() {
   			var area = $('#selectArea').val();
   			$.post("selectempleados.php",{area:area}, function(data){
				$("#divSelectEmpleados").html(data);
				$( "#comboSelecionaEmpleado" ).combobox();
			}); 
		});

		function recargarEmpleados(area)
		{
			var area = $('#selectArea').val();
			$.post("selectempleados.php",{area:area}, function(data){
				$("#divSelectEmpleados").html(data);
				$( "#comboSelecionaEmpleado" ).combobox();
			});
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
		<span class="Titulos">Reportes</span>
		<div id="container">
			<table>
				<tr height="40px">
					<td>
						Area:
					</td>
					<td>
					<select id ="selectArea" >
						<option id='opt_sel_area_default' value='-1'><span style='font-size:9pt;'>Todas</span></option>
					<?php 
						require_once("conexion/conexion.php");
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
					<tr height="40px">
			            <td>
			            	Empleado:
						</td>
						<td>
			            
				            <div id="divSelectEmpleados">
				            
				            </div>
			            </td>
						
					</tr>
					<tr height="40px">
				   		<td>
			            	Fecha Inicio:
						</td>
						<td>
			           		<input type="text" style="width:180px" name="FechaAsistencia" id="FechaAsistencia"/>
						</td>
			        </tr>
			        <tr height="40px">
				   		<td>
			            	Hora Inicio:
						</td>
						<td>
			           		<input type="text" style="width:180px" name="horaAsistencia" id="horaAsistencia"/>
						</td>
			        </tr>
			        <tr height="40px">
				   		<td>
			            	Fecha Fin:
						</td>
						<td>
			           		<input type="text" style="width:180px" name="FechaAsistenciaFin" id="FechaAsistenciaFin"/>
						</td>
			        </tr>
			        <tr height="40px">
				   		<td>
			            	Hora Fin:
						</td>
						<td>
			           		<input type="text" style="width:180px" name="horaAsistenciaFin" id="horaAsistenciaFin"/>
						</td>
			        </tr>
				</table>
			<div id="demo">
			<a id="reporteGeneralAsistencias" href="#" style="width:340px">Reporte General de Registros de Asistencias</a>
			<br/><br/>
			<a id="reporteAsistenciasEntradas" href="#" style="width:340px">Reporte de Registros de Entradas</a>
			<br/><br/>
			<a id="reporteAsistenciasSalidas" href="#" style="width:340px">Reporte de Registros de Salidas</a>
			<br/><br/>
			<a id="reporteAsistenciasAtrasos" href="#" style="width:340px">Reporte de Atrasos</a>
			<br/><br/>
			<a id="reporteAsistenciasAtrasosTotales" href="#" style="width:340px">Reporte de Atrasos Totales</a>
			<br/><br/>
			<a id="graficaAsistenciasAtrasosTotales" href="#" style="width:340px">Reporte Grafico de Atrasos Totales</a>
			<br/><br/>
			<a id="reporteAsistenciasSobretiempo" href="#" style="width:340px">Reporte de Sobretiempos</a>
			<br/><br/>
			<a style="width:340px" id="reporteAsistenciasLunch" href="#">Reporte de Tiempo de Lunch</a>
			<br/><br/>
			<a style="width:340px" id="reporteAsistenciasPermisos" href="#">Reporte de Permisos</a>
			<br/><br/>
			<a style="width:340px" id="reporteAsistenciasFeriados" href="#">Reporte de Feriados y Eventuales</a>
			<br/><br/>
			<a style="width:340px" id="reporteMRL" href="#">Reporte del MRL</a>
			<br/><br/>
            </div>
		</div>
   </body>
</html>