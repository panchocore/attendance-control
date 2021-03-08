<?php
require_once("conexion/conexion.php");

require_once("comun/sesion.class.php");
$sesion = new sesion();
$usuario = $sesion->get("nombreusuario");

$usuarioModificar=$_POST['usuarioModifica'];
$nombreUsuario=$_POST['nombresUsuario'];
$nickUsuario=$_POST['NicksUsuario'];
$idGrupo=$_POST['IdGrupoUsuario'];
			//$conexion = new mysqli("localhost","usuario","password","base");
			$conexion = new mysqli($hostname,$username,$password,$database);
			$consulta = 'UPDATE usuario SET `CODIGO_GRUPO` = \''. $idGrupo .'\',
						`NOMBRE_USUARIO` = \''. $nickUsuario .'\',
						`NOMBRES_USUARIO` = \''. $nombreUsuario .'\',
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
