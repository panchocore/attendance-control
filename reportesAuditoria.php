<?php
	require_once("comun/compruebasesion.php");
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
			$('#FechaIni').datepicker({
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
			$('#FechaFin').datepicker({
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

			$("#reporteGeneralAuditoria").click(function(){
			    var fechaini = $('#FechaIni').val();
			    var fechafin = $('#FechaFin').val();
			    
				window.open('reporteGeneralAuditoria.php?fechaini='+fechaini+'&fechafin='+fechafin,'Reporte General Auditoria','');
			});

		});

		</script>
	</head>
	<body id="dt_example">
    <br/>
		<span class="Titulos">Reportes</span>
		<div id="container">
			<table>
				<tr height="40px">
					<td>
						Fecha Inicio:
					</td>
					<td>
						<input type="text" style="width:180px" name="FechaIni" id="FechaIni"/>
					</td>
				</tr>
				
				<tr height="40px">
					<td>
						Fecha Fin:
					</td>
					<td>
						<input type="text" style="width:180px" name="FechaFin" id="FechaFin"/>
					</td>
				</tr>
				
			</table>
			<div id="demo">
			<a id="reporteGeneralAuditoria" href="#" style="width:340px">Reporte General de Auditoria</a>
			<br/><br/>
            </div>
		</div>
   </body>
</html>