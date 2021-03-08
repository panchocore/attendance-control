<?php 
$area = $_POST["area"];
	require_once("conexion/conexion.php");
							echo '<select id ="comboSelecionaEmpleado" name="comboSelecionaEmpleado">';
			            	echo "<option id='opt_sel_default' value='-1'><span style='font-size:9pt;'>Mostrar todos</span></option>";
			            	$conexion = new mysqli($hostname,$username,$password,$database);
							$consulta = 'SELECT `NOMBRE_EMPLEADO` , `CODIGO_EMPLEADO`
										FROM empleado
										WHERE `ESTADO_EMPLEADO` = 1';
							if($area > 0)
							{
								$consulta = $consulta." and empleado.`CODIGO_AREA` = ".$area;
							}
							
							$consulta = $consulta.";";
							
							if ($result = $conexion->query($consulta)) {
								    if($result->num_rows > 0)
									{
										while ($row = $result->fetch_assoc()) {
											echo "<option id='opt_sel_".$row["CODIGO_EMPLEADO"]."' value='".$row["CODIGO_EMPLEADO"]."'><span style='font-size:9pt;'>".$row["NOMBRE_EMPLEADO"]."</span></option>";
										}
										$result->close();
								    	$conexion->close();
									}		
									else{
										$result->close();
								    	$conexion->close();
									}
							}
							echo '</select> ';

?>