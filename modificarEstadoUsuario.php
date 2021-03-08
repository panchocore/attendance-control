<?php
require_once("conexion/conexion.php");
$usuarioModificar=$_POST['usuarioModifica'];
$EstadoUsuario=$_POST['EstadoUsuario'];
			//$conexion = new mysqli("localhost","usuario","password","base");
			$conexion = new mysqli($hostname,$username,$password,$database);
			$consulta = 'UPDATE usuario SET `ESTADO_USUARIO` = \''. $EstadoUsuario .'\' WHERE `usuario`.`CODIGO_USUARIO` = '.$usuarioModificar.' LIMIT 1;';
				
			if ($conexion->query($consulta)) {
			    echo "Se ha cambiado el estado del usuario correctamente!";
				$conexion->close();
			}
			else 
			{
				echo $conexion->error;
				$conexion->close();
				//exit();
			} 
?>
