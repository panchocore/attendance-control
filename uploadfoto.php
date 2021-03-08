<?php
	require_once("comun/compruebasesion.php");
	if($sesion->get("LogoEmpresarial"))
		$obtener_permisos = $sesion->get("LogoEmpresarial");
	else
	 	$obtener_permisos = 0;
	 
	if($obtener_permisos == 0)
		header("Location: index.php");
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
	         vault.setServerHandlers("UploadHandler.php", "GetInfoHandler.php", "GetIdHandler.php");
	         vault.setFilesLimit(1);
		 vault.onAddFile = function(fileName) { 
							var ext = this.getFileExtension(fileName); 
							if (ext != "jpg") { 
								mostrarerroregajoso("Solo puede subir imagenes (.jpg).");
								//alert("Solo puede subir imagenes (.jpg)."); 
								return false; 
							} else return true; };
	         vault.create("vault1");
		}
		
		$(function() {
			$( "input:submit, input:button" ).button();
			$( "#accordion" ).accordion({
				autoHeight: false,
				navigation: true
			});
		});
	</script>
</head>
<body>
<body onload="javascript:desabilitarMenusForm(<?php echo $obtener_permisos;?>);doOnLoad();">
<br/>
<span class="Titulos">Logo empresarial</span>
<br/>
<br/>
    	<table width="100%">
        	<tr>
        		<td>
        		</td>
                <td width="500px">

                    <div id="accordion">
                        <h3><a href="#">Logo empresarial actual</a></h3>
                        <div align="center">
                            <img src="images/logo.jpg" alt="su logo"/>
                            <form method="post" action="uploadfoto.php">
                            	<input type="button" value="Recargar" onClick="window.location.reload()">
                            </form>	
                        </div>
                        <h3><a href="#">Cambiar logo empresarial</a></h3>
                        <div>
                              <div id="vault1"></div>
                        </div>
                    </div>
            </td>
    	    <td>
	        </td>               
       </tr>
</table>

</body>
</body>
</html>
