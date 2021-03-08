<?php
/*
 * Mostrar una imagen desde blob mysql usando PHP
 * Autor: Braulio Andrés Soncco Pimentel <braulio@buayacorp.com>
 * http://www.buayacorp.com/
 * 
 * Este script está bajo licencia de Creative Commons 
 * http://creativecommons.org/licenses/by/2.0/
 */

	// Nivel de errores
	error_reporting(E_ALL);

	// Constantes
	# Servidor de base de datos
	define("DBHOST", "localhost");
	# nombre de la base de datos
	define("DBNAME", "controlasistencia");
	# Usuario de base de datos
	define("DBUSER", "root");
	# Password de base de datos
	define("DBPASSWORD", "");
	
	// Parámetros para recuperar la imagen
	# Recuperamos el parámetro GET con el id único de la foto que queremos mostrar
	$idfoto = (isset($_GET["codigo_empleado"])) ? $_GET["codigo_empleado"] : exit();
	# Recuperamos el parámetro GET para elegir entre la miniatura o la foto real
	$tam = (isset($_GET["tam"])) ? $_GET["tam"] : 1;
	
	// Escojemos la foto real o la miniatura según la variable $tam
	switch($tam) {
		case "1":
			$campo = "foto_empleado";break;;
		case "2":
			$campo = "thumb_empleado";break;;
		default:
			$campo = "foto_empleado";break;;
	}
	
	// Recuperamos la foto de la tabla
	$sql = "SELECT $campo, mime_empleado
			FROM empleado 
			WHERE codigo_empleado = $idfoto";
			
	# Conexión a la base de datos
	$hostname="localhost";
	$username='root';
	$password="";
	$database="controlasistencia";
	$link = mysql_connect($hostname, $username, $password) or die(mysql_error($link));;
	mysql_select_db($database, $link) or die(mysql_error($link));
	
	$conn = mysql_query($sql, $link) or die(mysql_error($link));
	$datos = mysql_fetch_array($conn);
	
	// La imagen
	$imagen = $datos[0];
	// El mime type de la imagen
	$mime = $datos[1];
	
	// Gracias a esta cabecera, podemos ver la imagen 
	// que acabamos de recuperar del campo blob
	header("Content-Type: $mime");
	// Muestra la imagen
	echo $imagen;	
?>