<?php
require_once("conexion/conexion.php");

require_once("comun/sesion.class.php");
$sesion = new sesion();
$usuario = $sesion->get("nombreusuario");

$ClaveUsuarioNuevo=$_POST['ClaveUsuarioNuevo'];
$nombreUsuario=$_POST['nombresUsuario'];
$nickUsuario=$_POST['NicksUsuario'];
$idGrupo=$_POST['IdGrupoUsuario'];
			//$conexion = new mysqli("localhost","usuario","password","base");
			$conexion = new mysqli($hostname,$username,$password,$database);
			$consulta = "INSERT INTO usuario( `CODIGO_USUARIO` , `CODIGO_GRUPO` , `NOMBRE_USUARIO` , `CLAVE_USUARIO` , `ESTADO_USUARIO` , `NOMBRES_USUARIO`, usumod, fecmod )
				VALUES (NULL , '".$idGrupo."', '".$nickUsuario."', '".md5($ClaveUsuarioNuevo)."', '1', '".$nombreUsuario."', '".$usuario."', CURRENT_TIMESTAMP);";
			if ($conexion->query($consulta)) {
			    echo "Se ha ingresado el nuevo usuario correctamente!";
				$conexion->close();
			}
			else 
			{
				echo $conexion->error;
				$conexion->close();
				//exit();
			} 
?>
