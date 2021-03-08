<?php
require_once("conexion/conexion.php");

require_once("comun/sesion.class.php");
$sesion = new sesion();
$usuario = $sesion->get("nombreusuario");

$horario=$_POST['horario'];
$empleado=$_POST['empleado'];
$desde=$_POST['desde'];
$hasta=$_POST['hasta'];

			/*$hostname="localhost";
			$username="root";
			$password="";
			$database="controlasistencia";/**/
			
			$conexion = new mysqli($hostname,$username,$password,$database);
			$consulta = "INSERT INTO empleadohorario (CODIGO_HORARIO, CODIGO_EMPLEADO, DESDE_EMPLEADOHORARIO, HASTA_EMPLEADOHORARIO, usumod, fecmod)
				VALUES (".$horario.", ".$empleado.", '".$desde."', '".$hasta."', '".$usuario."', CURRENT_TIMESTAMP);";
			
			if ($conexion->query($consulta)) {
			    echo "Se ha ingresado el registro correctamente!";
				$conexion->close();
			}
			else 
			{
				echo $conexion->error;
				//echo $consulta;
				$conexion->close();
				//exit();
			} 
			
function cambiarFormatoFecha($fecha){
    list($mes,$dia,$anio)=explode("/",$fecha);
    return $anio."/".$mes."/".$dia;
} 
?>
