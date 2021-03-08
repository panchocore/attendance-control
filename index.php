<?php
	require_once("comun/compruebasesionindex.php");
	$nombreusuario = $sesion->get("nombreusuario");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Control asistenacia de personal</title>
<link rel="shortcut icon" href="images/icon.ico">
<link href="estilo/estilo.css" rel="Stylesheet" type="text/css" />
<script src="scripts/jquery.js" type="text/javascript"></script>
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
$(function(){
	$(document).ready(function() {
		var alto = altoIframe() - 72;
		var altostring = alto + "px";
		$("#iframeMenu").attr({ 
			height: altostring
		});
	});
	$(document).resize(function() {
		var alto = altoIframe() - 72;
		var altostring = alto + "px";
		$("#iframeMenu").attr({ 
			height: altostring
		});
	});
});
</script>
</head>
<body>
		  <!--<iframe id="iframeLogo" src="logo.php" topmargin='0' leftmargin='0' frameborder='0' marginwidth='0' hspace='0' vspace='0' width='100%' height='40px'></iframe>-->
<div style="position:absolute;top:6px;right:15px" class="usuariologeado"> Bienvenido: <?php echo $nombreusuario; ?>, <a href="comun/cerrarsesion.php" class="usuariologeado">Salir del sistema</a></div>
<div style="width:100%; height:37px; padding-top:2px" >
	<table width="100%"  border="0" cellpadding="0" cellspacing="0" background="images/cabecera2.jpg">
      <tr>
        <td width="78%"><img src="images/cabecera1.jpg" alt="Control de asistencia de personal" /></td>
        <td width="22%"><div align="right"><img src="images/cabecera3.jpg"/></div></td>
      </tr>
	</table>
</div>

		  <iframe id="iframeMenu" src="menu.php" topmargin='0' leftmargin='00' frameborder='0' marginwidth='0' hspace='0' vspace='0' width='100%'></iframe>
 		  <iframe id="iframeBottom" src="base.php" topmargin='0' leftmargin='0' frameborder='0' marginwidth='0' hspace='0' vspace='0' width='100%' height='26px'></iframe>
</body>
</noframes></html>
