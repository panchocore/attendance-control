<?php
	require_once("comun/sesion.class.php");
	$tiemposesion = 600;
	$sesion = new sesion();
	$usuario = $sesion->get("usuario");
	
	if( $usuario == false )
	{	
		header("Location: finsesion.php");		
	}else 
	{		
		$fechaGuardada = $sesion->get("ultimoAcceso");
	    $ahora = date("Y-n-j H:i:s");
	    $tiempo_transcurrido = (strtotime($ahora)-strtotime($fechaGuardada));
	
	    //comparamos el tiempo transcurrido
	     if($tiempo_transcurrido >= $tiemposesion) {
	     //si pasaron 10 minutos o más
	      session_destroy(); // destruyo la sesión
	      header("Location: finsesion.php"); //envío al usuario a la pag. de autenticación
	      //sino, actualizo la fecha de la sesión
	    }else {
	    $sesion->set("ultimoAcceso",date("Y-n-j H:i:s"));	
	   } 
	}
?>