<?php
require_once("conexion/conexion.php");

require_once("comun/sesion.class.php");
$sesion = new sesion();
$usuario = $sesion->get("nombreusuario");

$codigo=$_POST['codigo'];
$empleado=$_POST['empleado'];
$descripcion=$_POST['descripcion'];
$fechaIni=$_POST['fechaInicio'];
$fechaFin=$_POST['fechaFin'];
$horaIni=$_POST['horaInicio'];
$horaFin=$_POST['horaFin'];

			$conexion = new mysqli($hostname,$username,$password,$database);
			$consulta = 'UPDATE permiso SET 
						CODIGO_EMPLEADO = \''. $empleado .'\',
						DESCRIPCION = \''. $descripcion .'\',
						FECHA_INICIO = \''. $fechaIni .'\',
						FECHA_FIN = \''. $fechaFin .'\',
						HORA_INICIO = \''. $horaIni .'\',
						HORA_FIN = \''. $horaFin .'\',
						usumod = \''. $usuario .'\',
						fecmod = CURRENT_TIMESTAMP
						WHERE CODIGO_PERMISO = '.$codigo.' LIMIT 1;';
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
