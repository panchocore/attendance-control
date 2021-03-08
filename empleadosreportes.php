<?php
	require_once("comun/compruebasesion.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		
		<title>Empleados</title>
		<link href="estilo/estilo.css" rel="Stylesheet" type="text/css" />
        <link href="estilo/demo_table.css" rel="Stylesheet" type="text/css" />
        <link href="media/css/TableTools.css" rel="Stylesheet" type="text/css" />
	    <script src="scripts/jquery.js" type="text/javascript"></script>
		<script type="text/javascript" src="media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" src="media/js/ZeroClipboard.js"></script>
		<script type="text/javascript" src="media/js/TableTools.js"></script>
   		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('#example').dataTable( {
					"sDom": 'T<"clear">lfrtip',
					"oTableTools": {
						"aButtons": [
							"copy",
							"csv",
							"xls",
							{
								"sExtends": "pdf",
								"sPdfOrientation": "portrait",//landscape
								"sPdfMessage": "Reporte de usuarios."
							},
							"print"
						]
					}
				} );
			} );
		</script>
	</head>
	<body id="dt_example">
	<br/>
		<span style="padding-left:10px" class="Titulos">Empleados</span>
		<div id="container">
			<div id="demo">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Area</th>
                            <th>Id</th>
                            <th>Cedula</th>
                            <th>Nombre</th>
							<th>Telefono</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    <?php 
                    require_once("conexion/conexion.php");
					//$conexion = new mysqli("localhost","usuario","password","base");
					$conexion = new mysqli($hostname,$username,$password,$database);
					/* check connection */
					if ($conexion->connect_errno) {
						echo "<script type='text/javascript'>";
						echo "mostrarerroregajosoderecha('"."Connect failed: %s\n".$conexion->connect_error."');";
						echo "</script>";
					    //echo "Connect failed: %s\n".$conexion->connect_error;
					    exit();
					}
					$consulta = "select e.ID_EMPLEADO, e.CODIGO_EMPLEADO, a.NOMBRE_AREA, a.CODIGO_AREA, e.CEDULA_EMPLEADO, e.NOMBRE_EMPLEADO, e.TELEFONO_EMPLEADO, e.ESTADO_EMPLEADO ".
								"from	empleado e, area a ".
								"where	e.CODIGO_AREA = a.CODIGO_AREA ";
					if ($result = $conexion->query($consulta)) {
					    if($result->num_rows > 0)
						{
							while ($row = $result->fetch_assoc()) {
								?>
								<?php if ($row["ESTADO_EMPLEADO"] == 1)
		                          	{
		                        ?>
		                           	<tr class="gradeA">
		                        <?php 
		                           	}
		                           	else if ($row["ESTADO_EMPLEADO"] == 0){
		                        ?>
		                           	<tr class="gradeX">
		                        <?php 
		                           	}
		                           	else{
		                        ?>
		                            	<tr class="gradeU">
		                        <?php 
		                            	}
		                        ?>
		                            <td><?php echo $row["CODIGO_EMPLEADO"];?></td>
		                            <td><?php echo $row["NOMBRE_AREA"];?></td>
									<td><?php echo $row["ID_EMPLEADO"];?></td>
									<td><?php echo $row["CEDULA_EMPLEADO"];?></td>
		                            <td><?php echo $row["NOMBRE_EMPLEADO"];?></td>
									<td><?php echo $row["TELEFONO_EMPLEADO"];?></td>
		                            <td class="center">
		                            	<?php if ($row["ESTADO_EMPLEADO"] == 1)
		                            	{
		                            	?>
		                            	Activo<!--<img src="Ribbon/images/1323286599_status.png" alt="Activo" />-->
		                            	<?php 
		                            	}
		                            	else if ($row["ESTADO_EMPLEADO"] == 0){
		                            	?>
		                            	Inactivo<!-- <img src="Ribbon/images/1323286606_status-offline.png" alt="Inactivo" />-->
		                            	<?php 
		                            	}
		                            	else{
		                            	?>
		                            	Eliminado<!-- <img src="Ribbon/images/1323450190_user_male_delete.png" alt="Eliminado" />-->
		                            	<?php 
		                            	}
		                            	?>
		                            	
		                            </td>
		                        </tr>
								
								<?php 
						    }  
							$result->close();
					    	$conexion->close();							
						}
						else{
							$result->close();
					    	$conexion->close();
						}
					    
					}
					else 
					{
						echo "<script type='text/javascript'>";
						echo "mostrarerroregajosoderecha('".($conexion->error)."');";
						echo "</script>";
						exit();
						//echo($conexion->error);
					}
                    ?>
                    
                    <!--     <tr class="odd gradeC">
                            <td>Trident</td>
                            <td>Internet
                                 Explorer 4.0</td>
                            <td>Win 95+</td>
                            <td class="center"> 4</td>
                            <td class="center">X</td>
                        </tr>
                        <tr class="gradeA">
                        <tr class="gradeX">
                        <tr class="gradeU">
                    -->
                    </tbody>
                    <tfoot>
                        <tr>
                      		<th>Codigo</th>
                            <th>Area</th>
                            <th>Id</th>
                            <th>Cedula</th>
                            <th>Nombre</th>
							<th>Telefono</th>
                            <th>Estado</th>
                        </tr>
                    </tfoot>
                </table>
			</div>
			
			</div>
		</div>
	</body>
</html>