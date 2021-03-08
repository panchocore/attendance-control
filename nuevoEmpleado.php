<?php
require_once("conexion/conexion.php");

require_once("comun/sesion.class.php");
$sesion = new sesion();
$usuario = $sesion->get("nombreusuario");

$id=$_POST['id'];
$nombre=$_POST['nombre'];
$cedula=$_POST['cedula'];
$telefono=$_POST['telefono'];
$idArea=$_POST['idArea'];
			
			
			$conexion = new mysqli($hostname,$username,$password,$database);
			$consulta = "INSERT INTO empleado(ID_EMPLEADO, CEDULA_EMPLEADO, NOMBRE_EMPLEADO, TELEFONO_EMPLEADO, CODIGO_AREA, ESTADO_EMPLEADO, usumod, fecmod)
				VALUES (".$id.", '".$cedula."', '".$nombre."', '".$telefono."', ".$idArea.", 1, '".$usuario."', CURRENT_TIMESTAMP);";
			
			if ($conexion->query($consulta)) {
			    echo "Se ha ingresado el empleado correctamente!";
				$conexion->close();
			}
			else 
			{
				echo $conexion->error;
				$conexion->close();
				//exit();
			} 
?>
