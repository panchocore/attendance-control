<?php
	require_once("comun/compruebasesion.php");
	if($sesion->get("CambiarTexto"))
		$obtener_permisos = $sesion->get("CambiarTexto");
	else 
		$obtener_permisos = 0;
	
	if($obtener_permisos == 0)
		header("Location: index.php");
			
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="estilo/estilo.css" rel="stylesheet" type="text/css" />
    <script src="scripts/jquery.js" type="text/javascript"></script>
 	<link type="text/css" href="estilo/jquery.toastmessage.css" rel="stylesheet"/>
    <script type="text/javascript" src="scripts/jquery.toastmessage.js"></script>
    <script type="text/javascript" src="scripts/mensajes.js"></script>
    <link type="text/css" href="jqueryui/css/redmond/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
	<script src="jqueryui/js/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="scripts/permisos.js"></script>
	<script type="text/javascript">
            
            $(function() {
    			
            	$( "input:submit, input:button" ).button();
            });
    </script>
</head>
<body onload="javascript:desabilitarMenusForm(<?php echo $obtener_permisos;?>)">
<br/>
<span class="Titulos">Configurar menus</span>
<br/>
<br/>
<? 
$fichero = "estilo/textos.php";
$texto = $_POST["Guardar"];
if ($texto) {
	if($fp = fopen($fichero,"w+")){
		fputs($fp,"<?php");
		fputs($fp,"\r\n");
		foreach($_POST as $nombre_campo => $valor){ 
			if($nombre_campo != "Guardar"){
				fputs($fp,"$" . $nombre_campo . '="' . $valor . '";');  
				fputs($fp,"\r\n");
				//eval($asignacion); 
			}
		} 
		fputs($fp,"?>");
	}
	fclose($fp);
	echo "<script type='text/javascript'>";
	echo "MuestraMensajeGuardadoCorrectoPegajoso('Se han guardado los cambios correctamente!');";
	echo "</script>";
}
$vlineas = file($fichero); 
echo "<form method=\"POST\">";
echo "<table>";
foreach ($vlineas as $sLinea) 
{
	if(substr($sLinea,0,1) != "<" and substr($sLinea,1,1) != ">"){
	   	echo "<tr>";
	   	echo "<td>";
		echo substr($sLinea,1,strpos($sLinea,"=")-1);
		echo "</td>";
		echo "<td>";
		echo "<input type='text' style='width:200px' name='".substr($sLinea,1,strpos($sLinea,"=")-1)."' value='".substr($sLinea,strpos($sLinea,"=")+2,strlen($sLinea)-(strpos($sLinea,"=")+6))."'/>";
		echo "</td>";
		echo "</tr>";
		}
}
echo "</table>";
?>
<br/>
&nbsp;<input name="Guardar" type="Submit" value="Guardar">
<?php
	echo "</form>";
?>
<br/>
</body>
</html>
