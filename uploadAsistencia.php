<?php
	require_once("comun/compruebasesion.php");
	
	$usuario = $sesion->get("nombreusuario");
	if($sesion->get("CargaArchivo"))
		$obtener_permisos = $sesion->get("CargaArchivo");
	else 
		$obtener_permisos = 0;
	
	if($obtener_permisos == 0)
		header("Location: finsesion.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link href="estilo/estilo.css" rel="stylesheet" type="text/css" />
	<link href="estilo/dhtmlxvault.css" rel="stylesheet" type="text/css" />
	<link type="text/css" href="estilo/jquery.toastmessage.css" rel="stylesheet"/>
	<link type="text/css" href="jqueryui/css/redmond/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
	<script src="scripts/jquery.js" type="text/javascript"></script>
	<script type="text/javascript" src="scripts/jquery.toastmessage.js"></script>
    <script type="text/javascript" src="scripts/mensajes.js"></script>
	<script type="text/javascript" src="scripts/dhtmlxvault.js"></script>
	<script src="jqueryui/js/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="scripts/permisos.js"></script>
	<script type="text/javascript">
		 var vault = null;
	     function doOnLoad() {
	         vault = new dhtmlXVaultObject();
	         vault.setImagePath("estilo/imgs/");
	         vault.setServerHandlers("UploadHandlerAsistencia.php", "GetInfoHandler.php", "GetIdHandler.php");
	     vault.onAddFile = function(fileName) { 
							var ext = this.getFileExtension(fileName); 
							if (ext != "txt") { 
								mostrarerroregajoso("Solo puede subir archivos de texto (.txt).");
								//alert("Solo puede subir imagenes (.jpg)."); 
								return false; 
							} else return true; };
	         vault.create("vault1");
		}
		
		$(function() {
			$( "#accordion" ).accordion({
				autoHeight: false,
				navigation: true
			});
			$( "input:submit, input:button" ).button();
			
			$("#reporteLogCarga").click(function(){		    
			window.open('reporteLogCarga.php','Reporte Log de Carga','');
			});
		});
		
		
	</script>
</head>
<body>
<body onload="doOnLoad();javascript:desabilitarMenusTabla(<?php echo $obtener_permisos;?>)">
<br/>
<span class="Titulos">Carga de Asistencia de personal</span>
<br/>
<br/>
    	<table width="100%">
        	<tr>
        		<td>
        		</td>
                <td width="500px">

                    <div id="accordion">
                        <!-- <h3><a href="#">Logo empresarial actual</a></h3>
                        <div align="center">
                            <img src="images/logo.jpg" alt="su logo"/>
                            <form method="post" action="uploadfoto.php">
                            	<input type="button" value="Recargar" class="botones_fondo_blanco" onClick="window.location.reload()">
                            </form>	
                        </div> -->
                        <h3><a href="#">Cargar archivo</a></h3>
                        <div>
                              <div id="vault1"></div>
                        </div>
                    </div>
            </td>
    	    <td>
	        </td>               
       </tr>
	   <td>
		 </td>
		  <td>
		   <input type="button" id="reporteLogCarga" style="width:100%" value="Reporte Log de Carga"/>
		  </td>
		   <td>
		 
		 </td>
		 </tr>
		<td>
	   
</table>
	
</body>
</body>
</html>
