<?php
require_once("conexion/conexion.php");

require_once("comun/sesion.class.php");
$sesion = new sesion();
$usuario = $sesion->get("nombreusuario");

$usuarioModificar=$_POST['usuarioModifica'];
$NuevaClave=$_POST['NuevaClaveUser'];
			
			$conexion = new mysqli($hostname,$username,$password,$database);
			$consulta = 'UPDATE usuario SET 
						`CLAVE_USUARIO` = \''. md5($NuevaClave) .'\',
						usumod = \''. $usuario .'\',
						fecmod = CURRENT_TIMESTAMP
						 WHERE `usuario`.`CODIGO_USUARIO` = '.$usuarioModificar.' LIMIT 1;';
			if ($conexion->query($consulta)) {
			    echo "Se han guardado los cambios correctamente!";
				$conexion->close();
			}
			else 
			{
				echo $conexion->error;
				$conexion->close();
				//exit();
			} 
?>
