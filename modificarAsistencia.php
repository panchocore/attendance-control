<?php
require_once("conexion/conexion.php");

require_once("comun/sesion.class.php");
$sesion = new sesion();
$usuario = $sesion->get("nombreusuario");

$codigoEmpleado=$_POST['codigoEmpleado'];
$hora=$_POST['hora'];
$fecha=$_POST['fecha'];
$codHorario=$_POST['codHorario'];
$EntradaSalida=$_POST['EntradaSalida'];
$codigoEmpleadonuevo=$_POST['codigoEmpleadonuevo'];
$horanueva=$_POST['horanueva'];
$fechanueva=$_POST['fechanueva'];
			//$conexion = new mysqli("localhost","usuario","password","base");
			$conexion = new mysqli($hostname,$username,$password,$database);
			$consulta = 'UPDATE registros SET 
						`HORA_REGISTRO` = \''. $horanueva .'\',
						`FECHA_REGISTRO` = \''. $fechanueva .'\',
						`CODIGO_HORARIO` = '. $codHorario .', 
						`INOUT_REGISTRO` = \''. $EntradaSalida .'\',
						usumod = \''. $usuario .'\',
						fecmod = CURRENT_TIMESTAMP
						WHERE HORA_REGISTRO = \''.$hora.'\' AND FECHA_REGISTRO = \''.$fecha.'\' AND CODIGO_EMPLEADO ='.$codigoEmpleado.' LIMIT 1;';
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
