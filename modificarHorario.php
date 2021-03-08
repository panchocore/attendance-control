<?php
require_once("conexion/conexion.php");

require_once("comun/sesion.class.php");
$sesion = new sesion();
$usuario = $sesion->get("nombreusuario");

$codigo=$_POST['codigo'];
$nombre=$_POST['nombre'];
$horaInicio=$_POST['horaInicio'];
$horaFin=$_POST['horaFin'];
$dias=$_POST['dias'];
echo $nombre;
			$conexion = new mysqli($hostname,$username,$password,$database);
			$consulta = 'UPDATE horario SET 
						NOMBRE_HORARIO = \''. $nombre .'\',
						HORAINICIO_HORARIO = \''. $horaInicio .'\', 
						HORAFIN_HORARIO = \''. $horaFin .'\',
						dias = \''.$dias.'\',
						usumod = \''. $usuario .'\',
						fecmod = CURRENT_TIMESTAMP
						WHERE CODIGO_HORARIO = '.$codigo.' LIMIT 1;';
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
