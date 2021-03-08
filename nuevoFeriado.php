<?php
require_once("conexion/conexion.php");

require_once("comun/sesion.class.php");
$sesion = new sesion();
$usuario = $sesion->get("nombreusuario");

$nombre=$_POST['nombre'];
$fechaInicio=$_POST['fechainicio'];
$fechaFin=$_POST['fechafin'];
			
			$conexion = new mysqli($hostname,$username,$password,$database);
			$consulta = "INSERT INTO feriado (NOMBRE, FECHA_INI, FECHA_FIN, usumod, fecmod)
				VALUES ('".$nombre."', '".$fechaInicio."', '".$fechaFin."', '".$usuario."', CURRENT_TIMESTAMP);";
			
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
