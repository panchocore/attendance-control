<?php
require_once("conexion/conexion.php");

require_once("comun/sesion.class.php");
$sesion = new sesion();
$usuario = $sesion->get("nombreusuario");

$grupoMenuModificar=$_POST['grupoMenuModificar'];
$MenuModificar=$_POST['MenuModificar'];
$GrupoModificar=$_POST['GrupoModificar'];
$permisos=$_POST['permisos'];
			//$conexion = new mysqli("localhost","usuario","password","base");
			$conexion = new mysqli($hostname,$username,$password,$database);
			if($grupoMenuModificar == -1)
					$consulta = 'INSERT INTO menugrupo (
								`CODIGO_GRUPO` ,
								`CODIGO_MENU` ,
								`CODIGO_MENUGRUPO` ,
								`PERMISO_MENU`,
								usumod,
								fecmod
								)
								VALUES (
								"'.$GrupoModificar.'", "'.$MenuModificar.'", NULL , "'.$permisos.'", "'.$usuario.'", CURRENT_TIMESTAMP);';
			else 
					$consulta = 'UPDATE menugrupo SET `PERMISO_MENU` = '.$permisos.' WHERE CODIGO_MENUGRUPO ='.$grupoMenuModificar.' LIMIT 1;';
			
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
