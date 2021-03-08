<?php
require_once("conexion/conexion.php");

require_once("comun/sesion.class.php");
$sesion = new sesion();
$usuario = $sesion->get("nombreusuario");

$codigo=$_POST['codigo'];
$horario=$_POST['horario'];
$empleado=$_POST['empleado'];
$desde=$_POST['desde'];
$hasta=$_POST['hasta'];
echo $nombre;
			$conexion = new mysqli($hostname,$username,$password,$database);
			$consulta = 'UPDATE empleadohorario SET 
						CODIGO_HORARIO = '. $horario .',
						CODIGO_EMPLEADO = '. $empleado .', 
						DESDE_EMPLEADOHORARIO = \''. $desde .'\', 
						HASTA_EMPLEADOHORARIO = \''. $hasta .'\',
						usumod = \''. $usuario .'\',
						fecmod = CURRENT_TIMESTAMP
						WHERE CODIGO_EMPLEADOHORARIO = '.$codigo.' LIMIT 1;';
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
			//echo $consulta;
function cambiarFormatoFecha($fecha){
    list($mes,$dia,$anio)=explode("/",$fecha);
    return $anio."/".$mes."/".$dia;
} 
?>
