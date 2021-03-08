<?php
require_once("conexion/conexion.php");
$usuarioEliminar=$_POST['usuarioEliminar'];
$estadoUsuario=$_POST['estadoUsuario'];
			//$conexion = new mysqli("localhost","usuario","password","base");
			$conexion = new mysqli($hostname,$username,$password,$database);
			$consulta = 'UPDATE usuario SET `ESTADO_USUARIO` = \''. $estadoUsuario .'\' WHERE `usuario`.`CODIGO_USUARIO` = '.$usuarioEliminar.' LIMIT 1;';
			if ($conexion->query($consulta)) {
			    echo "Se ha eliminado el usuario correctamente!";
				$conexion->close();
			}
			else 
			{
				echo $conexion->error;
				$conexion->close();
				//exit();
			} 
?>
