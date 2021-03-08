<?php
require_once("conexion/conexion.php");
$Id=$_POST['Id'];
$Estado=$_POST['Estado'];
$Tabla=$_POST['Tabla'];
			//$conexion = new mysqli("localhost","usuario","password","base");
			$conexion = new mysqli($hostname,$username,$password,$database);
			switch ($Tabla) {
				case 'usuario':
					$consulta = 'UPDATE usuario SET `ESTADO_USUARIO` = \''. $Estado .'\' WHERE `usuario`.`CODIGO_USUARIO` = '.$Id.' LIMIT 1;';
					break;
				case 'empleado':
					$consulta = 'UPDATE empleado SET `ESTADO_EMPLEADO` = \''. $Estado .'\' WHERE CODIGO_EMPLEADO = '.$Id.' LIMIT 1;';
					break;
				case 'area':
					$consulta = 'delete from area WHERE codigo_area = '. $Id .' LIMIT 1;';
					break;
				case 'horario':
					$consulta = 'delete from horario WHERE codigo_horario = '. $Id .' LIMIT 1;';
					break;
				case 'cronograma':
					$consulta = 'delete from empleadohorario WHERE CODIGO_EMPLEADOHORARIO = '. $Id .' LIMIT 1;';
					break;
				case 'registros':
					list($hora, $fecha, $empleado) = split('\|', $Id);
					$consulta = 'DELETE FROM registros WHERE HORA_REGISTRO = \''.$hora.'\' AND FECHA_REGISTRO = \''.$fecha.'\' AND CODIGO_EMPLEADO ='.$empleado.' LIMIT 1;';
				case 'permiso':
					$consulta = 'delete from permiso WHERE codigo_permiso = '. $Id .' LIMIT 1;';
					break;
				case 'feriado':
					$consulta = 'delete from feriado WHERE codigo_feriado = '. $Id .' LIMIT 1;';
					break;
			}
			//echo $cosulta;
			if ($conexion->query($consulta)) {
			    echo "Se ha eliminado el registro correctamente!";
				$conexion->close();
			}
			else 
			{
				echo $conexion->error;
				$conexion->close();
				//exit();
			} 
?>
