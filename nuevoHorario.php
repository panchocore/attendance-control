<?php
require_once("conexion/conexion.php");

require_once("comun/sesion.class.php");
$sesion = new sesion();
$usuario = $sesion->get("nombreusuario");

$nombre=$_POST['nombre'];
$horaInicio=$_POST['horaInicio'];
$horaFin=$_POST['horaFin'];
$dias=$_POST['dias'];
			
			$conexion = new mysqli($hostname,$username,$password,$database);
			$consulta = "INSERT INTO horario (NOMBRE_HORARIO, HORAINICIO_HORARIO, HORAFIN_HORARIO, dias, usumod, fecmod)
				VALUES ('".$nombre."', '".$horaInicio."', '".$horaFin."', '".$dias."', '".$usuario."', CURRENT_TIMESTAMP);";
			
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
