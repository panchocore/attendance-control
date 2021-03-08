<?php
require_once("conexion/conexion.php");
$codHorario=$_POST['codHorario'];
$EntradaSalida=$_POST['EntradaSalida'];
$codigoEmpleadonuevo=$_POST['codigoEmpleadonuevo'];
$horanueva=$_POST['horanueva'];
$fechanueva=$_POST['fechanueva'];
			//$conexion = new mysqli("localhost","usuario","password","base");
			$conexion = new mysqli($hostname,$username,$password,$database);
			$consulta = "INSERT INTO `controlasistencia`.`registros` (
				`CODIGO_EMPLEADO` ,
				`HORA_REGISTRO` ,
				`FECHA_REGISTRO` ,
				`ESTADO_REGISTRO` ,
				`CODIGO_HORARIO` ,
				`INOUT_REGISTRO`
				)
				VALUES (". $codigoEmpleadonuevo .',\''. $horanueva .'\',\''. $fechanueva .'\',1,'. $codHorario .',\''. $EntradaSalida ."');";
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
