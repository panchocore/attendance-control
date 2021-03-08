<?php
require_once("conexion/conexion.php");

require_once("comun/sesion.class.php");
$sesion = new sesion();
$usuario = $sesion->get("nombreusuario");

$nombre=$_POST['nombre'];
$descripcion=$_POST['descripcion'];
			
			$conexion = new mysqli($hostname,$username,$password,$database);
			$consulta = "INSERT INTO area (NOMBRE_AREA, DESCRIPCION_AREA, usumod, fecmod)
				VALUES ('".$nombre."', '".$descripcion."', '".$usuario."', CURRENT_TIMESTAMP);";
			
			if ($conexion->query($consulta)) {
			    echo "Se ha ingresado el registro correctamente!";
				$conexion->close();
			}
			else 
			{
				echo $conexion->error;
				$conexion->close();
				//exit();
			} 
?>
