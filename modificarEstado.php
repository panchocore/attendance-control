<?php
require_once("conexion/conexion.php");
$Id=$_POST['Id'];
$Estado=$_POST['Estado'];
$Tabla=$_POST['Tabla'];
//$conexion = new mysqli("localhost","usuario","password","base");
/*$hostname="localhost";
$username='root';
$password="";
$database="controlasistencia";*/
$conexion = new mysqli($hostname,$username,$password,$database);
switch ($Tabla) {
case 'usuario':
	$consulta = 'UPDATE usuario SET `ESTADO_USUARIO` = \''. $Estado .'\' WHERE `usuario`.`CODIGO_USUARIO` = '.$Id.' LIMIT 1;';
	break;
case 'empleado':
	$consulta = 'UPDATE empleado SET `ESTADO_EMPLEADO` = \''. $Estado .'\' WHERE `empleado`.`CODIGO_EMPLEADO` = '.$Id.' LIMIT 1;';
	break;
case 'registros':
	list($hora, $fecha, $empleado) = split('\|', $Id);
	$consulta = 'UPDATE registros SET `ESTADO_REGISTRO` = \''. $Estado .'\' WHERE HORA_REGISTRO = \''.$hora.'\' AND FECHA_REGISTRO = \''.$fecha.'\' AND CODIGO_EMPLEADO ='.$empleado.' LIMIT 1;';
	break;
}

if ($conexion->query($consulta)) {
	echo "Se ha cambiado el estado correctamente!";
	$conexion->close();
}
else 
{
	echo $conexion->error;
	$conexion->close();
	//exit();
} 
?>
