<?php
	require_once("comun/sesion.class.php");
	$sesion = new sesion();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ingreso - Control asistencia de personal</title>
	<link href="estilo/estilo.css" rel="stylesheet" type="text/css" />
	<link type="text/css" href="estilo/jquery.toastmessage.css" rel="stylesheet"/>
	<link type="text/css" href="jqueryui/css/redmond/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
	<script src="scripts/jquery.js" type="text/javascript"></script>
	<script type="text/javascript" src="scripts/jquery.toastmessage.js"></script>
    <script type="text/javascript" src="scripts/mensajes.js"></script>
	<script src="jqueryui/js/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>
	<link rel="shortcut icon" href="images/icon.ico">
	<link type="text/css" href="estilo/validationEngine.jquery.css" rel="stylesheet"/>
    <script type="text/javascript" src="scripts/jquery.validationEngine-es.js"></script>
	<script type="text/javascript" src="scripts/jquery.validationEngine.js"></script>
    <script type="text/javascript">
            jQuery(document).ready(function(){
                // binds form submission and fields to the validation engine
                $("#formlogin").validationEngine('attach');
            });
    </script>
</head>

<body>

<?php
	if( isset($_POST["Ingresar"]) )
	{
		
		$usuario = htmlentities(trim($_POST["usuario"]), ENT_QUOTES);
		$clave = htmlentities(trim($_POST["clave"]), ENT_QUOTES);
		
		if(validarUsuario($usuario,$clave) == true)
		{	
			//$sesion = new sesion();
			$sesion->set("usuario",$usuario);
			$sesion->set("ultimoAcceso",date("Y-n-j H:i:s"));
			echo " <script>"; 
			echo "window.location.href='index.php'"; 
			echo "</script> ";
		}
		else 
		{
			echo "<script type='text/javascript'>";
			echo "mostrarerroregajosoderecha('Nombre de usuario incorrecto, clave incorrecta o estado inactivo');";
			echo "</script>";
			//echo "Verifica tu nombre de usuario y clave";
		}
	}
	
	function validarUsuario($usuario, $clave)
	{
		require_once("conexion/conexion.php");

		$conexion = new mysqli($hostname,$username,$password,$database);
		/* check connection */
		if ($conexion->connect_errno) {
			echo "<script type='text/javascript'>";
			echo 'mostrarerroregajosoderecha("'.'Connect failed: %s\n'.$conexion->connect_error.'");';
			echo "</script>";
		    //echo "Connect failed: %s\n".$conexion->connect_error;
		    exit();
		}
		$consulta = "select CLAVE_USUARIO,NOMBRES_USUARIO, CODIGO_GRUPO from usuario where ESTADO_USUARIO = 1 AND NOMBRE_USUARIO = '".$usuario."';";
		if ($result = $conexion->query($consulta)) {
		    if($result->num_rows > 0)
			{
				//echo $result->num_rows;
				$fila = $result->fetch_assoc();
				//echo "<br/>";
				//echo $fila["CLAVE_USUARIO"];
				//echo $clave;
				$sesion = new sesion();
				$sesion->set("nombreusuario",$fila["NOMBRES_USUARIO"]);
				//$sesion->set("grupousuario",$fila["CODIGO_GRUPO"]);
				if(md5($clave) == $fila["CLAVE_USUARIO"] )
				{	
					$consulta = 'SELECT menu.NOMBRE_MENU, menugrupo.PERMISO_MENU
									FROM menugrupo
									JOIN menu ON menugrupo.CODIGO_MENU = menu.CODIGO_MENU
									JOIN grupo ON grupo.CODIGO_GRUPO = menugrupo.CODIGO_GRUPO
									WHERE menugrupo.CODIGO_GRUPO ='.$fila["CODIGO_GRUPO"];
					if ($result = $conexion->query($consulta)) {
					    if($result->num_rows > 0)
							{
								while ($row = $result->fetch_assoc()) 
								{
									$sesion->set($row["NOMBRE_MENU"],$row["PERMISO_MENU"]);
								}
							}		
					}
					
					$conexion->close();
					
					$conexion = new mysqli($hostname,$username,$password,$database);
					$consulta1 = "SELECT atraso_tiempo, sobre_tiempo FROM empresa;";
		
					if ($result1 = $conexion->query($consulta1)) {
						if($result1->num_rows > 0)
						{
							while ($row1 = $result1->fetch_assoc()) 
							{
								$sesion = new sesion();
								$sesion->set("atraso_tiempo",$row1["atraso_tiempo"]);
								$sesion->set("sobre_tiempo",$row1["sobre_tiempo"]);
							}
						}
					}
					else 
					{
						echo "<script type='text/javascript'>";
						echo 'mostrarerroregajosoderecha("'.$conexion->error.'");';
						echo "</script>";
						exit();
						//echo($conexion->error);
					}
					
					$result1->close();
					$result->close();
					$conexion->close();
					return true;
				}						
				else
				{
					$result->close();
					$conexion->close();
					return false;
				}
			}
			else{
				$result->close();
		    	$conexion->close();
				return false;
			}
		    
		}
		else 
		{
			echo "<script type='text/javascript'>";
			echo 'mostrarerroregajosoderecha("'.($conexion->error).'");';
			echo "</script>";
			exit();
			//echo($conexion->error);
		}
	}
	
	function cargarParametros()
	{
		
		$conexion = new mysqli($hostname,$username,$password,$database);
		
		/* check connection */
		if ($conexion->connect_errno) {
			echo "<script type='text/javascript'>";
			echo "mostrarerroregajosoderecha('"."Connect failed: %s\n".$conexion->connect_error."');";
			echo "</script>";
			exit();
		}
		
		$consulta = "SELECT atraso_tiempo, sobre_tiempo FROM empresa;";
		
		if ($result = $conexion->query($consulta)) {
			if($result->num_rows > 0)
			{
				while ($row = $result->fetch_assoc()) 
				{
					$sesion = new sesion();
					$sesion->set("atraso_tiempo",$row["atraso_tiempo"]);
					$sesion->set("sobre_tiempo",$row["sobre_tiempo"]);
				}
			}
		}
		else 
		{
			echo "<script type='text/javascript'>";
			echo 'mostrarerroregajosoderecha("'.$conexion->error.'");';
			echo "</script>";
			exit();
			//echo($conexion->error);
		}
		
		$result->close();
		$conexion->close();
	}

?>

<br/>
<br/>
<form id="formlogin" name="formlogin" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<table width="517" height="404" border="0" align="center" cellpadding="0" cellspacing="0" background="images/login.jpg">
	  <tr>
		<td width="242" height="82"></td>
		<td width="14"></td>
	    <td width="261"></td>
	  </tr>
	  <tr>
		<td height="58"></td>
		<td></td>
	    <td></td>
	  </tr>
	  <tr>
		<td height="34"><div align="right" class="login-letras">Usuario:</div></td>
		<td></td>
	    <td><input type="text" name="usuario" class="validate[required]" id="usuario" value="<?php if(isset($usuario)) echo $usuario; ?>"/></td>
	  </tr>
	  <tr>
		<td height="34"><div align="right" class="login-letras">Clave:</div></td>
		<td></td>
	    <td><input type="password" name="clave" class="validate[required]" id="clave"/></td>
	  </tr>
	  <tr>
		<td height="15"></td>
		<td></td>
	    <td></td>
	  </tr>
	  <tr>
	    <td></td>
	    <td></td>
	    <td valign="top"><input name="Ingresar" type="submit" class="botones" value="Ingresar" /></td>
      </tr>
	</table>
</form>
</body>
</html>

