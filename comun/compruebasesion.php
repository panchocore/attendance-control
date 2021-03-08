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
	     //si pasaron 10 minutos o m�s
	      session_destroy(); // destruyo la sesi�n
	      header("Location: finsesion.php"); //env�o al usuario a la pag. de autenticaci�n
	      //sino, actualizo la fecha de la sesi�n
	    }else {
	    $sesion->set("ultimoAcceso",date("Y-n-j H:i:s"));	
	   } 
	}
?>