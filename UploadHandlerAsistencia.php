<?php
require_once("conexion/conexion.php");

    $id  = $_GET['sessionId'];
    $id = trim($id);
	
	$entrada=0;
	$salida=1;
	$salida_lunch=2;
	$entrada_lunch=3;
	$entrada_permiso=4;
	$salida_permiso=5;
	$entradaFeriado=6;
	$salidaFeriado=7;/**/
    
    session_name($id);
    session_start();
	
    $inputName = $_GET['userfile'];
    $fileName  = $_FILES[$inputName]['name'];
    $tempLoc   = $_FILES[$inputName]['tmp_name'];
    echo $_FILES[$inputName]['error'];
    //$target_path = $target_path . basename($fileName);
    
    $fp = fopen($tempLoc, "r");
        //LO RECORRE LÍNEA POR LÍNEA... ÚTIL POR SI TIENES VARIAS LINEAS DIFERENTES DE CSV
		while (!feof($fp)) { 

            //POR PONER UN EJEMPLO:
            //2012-6-10 13:28:49|1|3
            $data = fgets($fp);
			if($data != NULL)
            {
            	$elementos = explode("|", $data);
				$fechahora = explode(" ",$elementos[0]);
				
            	if($elementos[2]==$entrada)
            	{ 
					$conexion = new mysqli($hostname,$username,$password,$database);
					/* check connection */
					if ($conexion->connect_errno) {
						echo "<script type='text/javascript'>";
						echo "mostrarerroregajosoderecha('"."Connect failed: %s\n".$conexion->connect_error."');";
						echo "</script>";
						exit();
					}
					
					$consulta = "select f.codigo_feriado ".
								"from	feriado f ".
								"where	'".$fechahora[0]."' between f.fecha_ini and f.fecha_fin";
					
					if ($result = $conexion->query($consulta)) {
						if($result->num_rows > 0)
						{
							while ($row = $result->fetch_assoc()) 
							{
								$inout = $entradaFeriado; //entrada al trabajo en dia asignado como feriado o dia eventual (fuera de los dias considerados como laborables)
							}
						}
						else{
							$conexion = new mysqli($hostname,$username,$password,$database);
							/* check connection */
							if ($conexion->connect_errno) {
								echo "<script type='text/javascript'>";
								echo "mostrarerroregajosoderecha('"."Connect failed: %s\n".$conexion->connect_error."');";
								echo "</script>";
								exit();
							}
							
							$consulta = " select h.CODIGO_HORARIO ".
										" from	empleadohorario eh, empleado e, horario h ".
										" where	eh.CODIGO_EMPLEADO = e.CODIGO_EMPLEADO ".
										" and 	eh.CODIGO_HORARIO = h.CODIGO_HORARIO ".
										" and    e.ID_EMPLEADO = ".$elementos[1].
										" and	h.CODIGO_HORARIO != -1 ".
										" and	'".$fechahora[0]."' between eh.DESDE_EMPLEADOHORARIO and eh.HASTA_EMPLEADOHORARIO ".
										" and	h.DIAS like concat('%',DAYOFWEEK('".$fechahora[0]."'),'%') ";
							
							if ($result = $conexion->query($consulta)) {
								
								if($result->num_rows > 0)
								{
									while ($row = $result->fetch_assoc()) 
									{
										$inout = $elementos[2];
									}
								}
								else
								{
									$inout = $entradaFeriado;
								}
							}
							
							$conexion->close();
						}
					}
					$result->close();
					$conexion->close();
						 
            	}
				else if($elementos[2]==$salida)
            	{ 
					
					 $conexion = new mysqli($hostname,$username,$password,$database);
					/* check connection */
					if ($conexion->connect_errno) {
						echo "<script type='text/javascript'>";
						echo "mostrarerroregajosoderecha('"."Connect failed: %s\n".$conexion->connect_error."');";
						echo "</script>";
						exit();
					}
							
            		$consulta = "select f.codigo_feriado ".
								"from	feriado f ".
								"where	'".$fechahora[0]."' between f.fecha_ini and f.fecha_fin";
					
					if ($result = $conexion->query($consulta)) {
						if($result->num_rows > 0)
						{
							while ($row = $result->fetch_assoc()) 
							{
								$inout = $salidaFeriado; //salida del trabajo en dia asignado como feriado o dia eventual (fuera de los dias considerados como laborables)
							}
						}
						else
						{
							$conexion = new mysqli($hostname,$username,$password,$database);
							/* check connection */
							if ($conexion->connect_errno) {
								echo "<script type='text/javascript'>";
								echo "mostrarerroregajosoderecha('"."Connect failed: %s\n".$conexion->connect_error."');";
								echo "</script>";
								exit();
							}
						
							$consulta = " select h.CODIGO_HORARIO ".
										" from	empleadohorario eh, empleado e, horario h ".
										" where	eh.CODIGO_EMPLEADO = e.CODIGO_EMPLEADO ".
										" and 	eh.CODIGO_HORARIO = h.CODIGO_HORARIO ".
										" and    e.ID_EMPLEADO = ".$elementos[1].
										" and	h.CODIGO_HORARIO != -1 ".
										" and	'".$fechahora[0]."' between eh.DESDE_EMPLEADOHORARIO and eh.HASTA_EMPLEADOHORARIO ".
										" and	h.DIAS like concat('%',DAYOFWEEK('".$fechahora[0]."'),'%') ";
							
							if ($result = $conexion->query($consulta)) {
								if($result->num_rows > 0)
								{
									while ($row = $result->fetch_assoc()) 
									{
										$inout = $elementos[2];
									}
								}
								else
								{
									$inout = $salidaFeriado;
								}
							}
							$conexion->close();
						}
					} 
					$result->close();
					$conexion->close();
            	}
				
				
				$conexion = new mysqli($hostname,$username,$password,$database);
				/* check connection */
				if ($conexion->connect_errno) {
					echo "<script type='text/javascript'>";
					echo "mostrarerroregajosoderecha('"."Connect failed: %s\n".$conexion->connect_error."');";
					echo "</script>";
					exit();
				}
				
            	if(isset($inout)){
				
					$consulta = "select h.CODIGO_HORARIO ".
								"from	empleadohorario h, empleado e ".
								"where	h.CODIGO_EMPLEADO = e.CODIGO_EMPLEADO ".
								"and    e.ID_EMPLEADO = ".$elementos[1].
								" and	'".$fechahora[0]."' between h.DESDE_EMPLEADOHORARIO and h.HASTA_EMPLEADOHORARIO";
					
					if ($result = $conexion->query($consulta)) {
						if($result->num_rows > 0)
						{
							while ($row = $result->fetch_assoc()) 
							{
								$codigoHorario = $row["CODIGO_HORARIO"];
								
								$sql [] = "INSERT INTO registros (FECHA_REGISTRO, 
																	HORA_REGISTRO, 
																	CODIGO_EMPLEADO, 
																	ESTADO_REGISTRO, 
																	INOUT_REGISTRO,
																	CODIGO_HORARIO
																)
								VALUES ('".$fechahora[0]."','".$fechahora[1]."',".$elementos[1].",1,".$inout.",".$codigoHorario.");";
							}
						}
						else{
							$sql [] = "INSERT INTO logcarga (fecha_carga, registro, error)
										VALUES (CURRENT_TIMESTAMP,'".trim($data)."','No se encontró un horario para el empleado [".$elementos[1]."]');";
						}
					}
					
					$result->close();
					$conexion->close();
            	}
        	  	//echo "'".substr($data,0,2)."-".substr($data,2,2)."-".substr($data,4,4)."'"."'".substr($data,8,2).":".substr($data,10,2)."'".substr($data,12,4)."'".substr($data,20,1)."'";
            	//echo "<br/>";
            }
           
        }
		
        $conexion = new mysqli($hostname,$username,$password,$database);
		//echo "<table>";
    	foreach ($sql as $sqlStatement) {
	    	try{
	    		$conexion->query($sqlStatement);
			} catch (Exception $e) {
				echo "<script type='text/javascript'>";
				echo 'mostrarerroregajosoderecha("'.$e->getMessage().'");';
				echo "</script>";		
			}
    	}
        $conexion->close();
        fclose($fp); //CIERRA EL ARCHIVO
    	$_SESSION['value'] = -1;
    //if(move_uploaded_file($tempLoc,$target_path))
    //{            //}
?>
