<?php
require_once("conexion/conexion.php");

require_once("comun/sesion.class.php");
$sesion = new sesion();
$usuario = $sesion->get("nombreusuario");

$empleado=$_POST['empleado'];
$descripcion=$_POST['descripcion'];
$fechaInicio=$_POST['fechainicio'];
$fechaFin=$_POST['fechafin'];
$horaInicio=$_POST['horainicio'];
$horaFin=$_POST['horafin'];
			
			$conexion = new mysqli($hostname,$username,$password,$database);
			$consulta = "INSERT INTO permiso (CODIGO_EMPLEADO, DESCRIPCION, FECHA_INICIO, FECHA_FIN, HORA_INICIO, HORA_FIN, usumod, fecmod)
				VALUES (".$empleado.", '".$descripcion."', '".$fechaInicio."', '".$fechaFin."', '".$horaInicio."', '".$horaFin."', '".$usuario."', CURRENT_TIMESTAMP);";
			
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
