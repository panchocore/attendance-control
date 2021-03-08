<?php
require_once("conexion/conexion.php");

require_once("comun/sesion.class.php");
$sesion = new sesion();
$usuario = $sesion->get("nombreusuario");

$codigo=$_POST['codigo'];
$Id=$_POST['id'];
$nombreEmpleado=$_POST['nombreEmpleado'];
$cedulaEmpleado=$_POST['cedulaEmpleado'];
$telefonoEmpleado=$_POST['telefonoEmpleado'];
$idArea=$_POST['idArea'];
			$conexion = new mysqli($hostname,$username,$password,$database);
			$consulta = 'UPDATE empleado SET CODIGO_AREA = \''. $idArea .'\',
						ID_EMPLEADO = \''. $Id .'\',
						NOMBRE_EMPLEADO = \''. $nombreEmpleado .'\',
						CEDULA_EMPLEADO = \''. $cedulaEmpleado .'\', 
						TELEFONO_EMPLEADO = \''. $telefonoEmpleado .'\',
						usumod = \''. $usuario .'\',
						fecmod = CURRENT_TIMESTAMP
						WHERE CODIGO_EMPLEADO = '.$codigo.' LIMIT 1;';
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
