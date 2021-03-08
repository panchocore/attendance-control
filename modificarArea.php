<?php
require_once("conexion/conexion.php");

require_once("comun/sesion.class.php");
$sesion = new sesion();
$usuario = $sesion->get("nombreusuario");

$codigo=$_POST['codigo'];
$nombre=$_POST['nombre'];
$descripcion=$_POST['descripcion'];

			$conexion = new mysqli($hostname,$username,$password,$database);
			$consulta = 'UPDATE area SET 
						NOMBRE_AREA = \''. $nombre .'\',
						DESCRIPCION_AREA = \''. $descripcion .'\',
						usumod = \''. $usuario .'\',
						fecmod = CURRENT_TIMESTAMP
						WHERE CODIGO_AREA = '.$codigo.' LIMIT 1;';
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
