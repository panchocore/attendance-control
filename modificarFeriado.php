<?php
require_once("conexion/conexion.php");

require_once("comun/sesion.class.php");
$sesion = new sesion();
$usuario = $sesion->get("nombreusuario");

$codigo=$_POST['codigo'];
$nombre=$_POST['nombre'];
$fechaini=$_POST['fechaInicio'];
$fechafin=$_POST['fechaFin'];

			$conexion = new mysqli($hostname,$username,$password,$database);
			$consulta = 'UPDATE FERIADO SET 
						NOMBRE = \''. $nombre .'\',
						FECHA_INI = \''. $fechaini .'\',
						FECHA_FIN = \''. $fechafin .'\',
						usumod = \''. $usuario .'\',
						fecmod = CURRENT_TIMESTAMP
						WHERE CODIGO_FERIADO = '.$codigo.' LIMIT 1;';
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
