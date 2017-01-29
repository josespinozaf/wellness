<html>
<head>
<?php
//**Conexión base de datos**// 
include ("../connect.php");

//** DATOS DEL USUARIO QUE ENTREGA MOODLE**//
$userid= $USER->id;
$usermail= $USER->email;

// **Peticion al SQL**//
$result = mysql_query("SELECT * FROM fitnessgram WHERE email='$usermail'", $db);
if (!$result) {
	die("Error en la peticion SQL: " . mysql_error());
}

$result2 = mysql_query("SELECT * FROM fitnessgram WHERE email='$usermail'", $db);
if (!$result) {
	die("Error en la peticion SQL: " . mysql_error());
}

$result3 = mysql_query("SELECT * FROM fitnessgram WHERE email='$usermail'", $db);
if (!$result) {
	die("Error en la peticion SQL: " . mysql_error());
}

$result4 = mysql_query("SELECT * FROM fitnessgram WHERE email='$usermail'", $db);
if (!$result) {
	die("Error en la peticion SQL: " . mysql_error());
}

$result5 = mysql_query("SELECT * FROM fitnessgram WHERE email='$usermail'", $db);
if (!$result) {
	die("Error en la peticion SQL: " . mysql_error());
}
$data = mysql_fetch_array($result5);
?>

<!-- Tablas -->
<script type="text/javascript" >
		google.load("visualization", "1.1", {packages:["table"]});
		google.setOnLoadCallback(drawTable);
		function drawTable() {
			//Datos tabla antropometria
			var data = new google.visualization.DataTable();
						data.addColumn('string', '<?php echo get_string('ano','local_wellness')?>');
						data.addColumn('string', '<?php echo get_string('talla','local_wellness')?>');
						data.addColumn('string', '<?php echo get_string('peso','local_wellness')?>');
						data.addColumn('string', '<?php echo get_string('imcs','local_wellness')?>');
						data.addColumn('string', '<?php echo get_string('grasas','local_wellness')?>');
		    <?php while ($row = mysql_fetch_array($result)) { ?>
		         		 data.addRows([
									  ['<?php echo $row['Ano']?>',
									   '<?php echo $row['Talla']?>',
									   '<?php echo $row['Peso']?>',
									   '<?php echo $row['IMC']?>',
									   '<?php echo $row['%Grasa']?>'],
									  ]);
			<?php }?>
			// Datos de la tabla fuerza			
		 	var data2 = new google.visualization.DataTable();
				         data2.addColumn('string', '<?php echo get_string('ano','local_wellness')?>');
				         data2.addColumn('string', '<?php echo get_string('abds','local_wellness')?>');          
				         data2.addColumn('string', '<?php if ($data['Sexo']=='F')
				         								  	echo get_string('pullups','local_wellness');
				         								  else if ($data['Sexo']=='M') 
				         								    echo get_string('pushups','local_wellness');?>');
				      
        	<?php	while ($row = mysql_fetch_array($result2)) { ?>
         				data2.addRows([
								       ['<?php echo $row['Ano']?>',
								        '<?php echo $row['Abd']?>',
								        '<?php if ($row['Sexo']=='M') 
								        				  echo $row['Push Up']; 
								        			else 
								        				  echo $row['Pull Up'];?>'],
								       ]);
			<?php }?>
			//Datos tabla flexibilidad
			var data3 = new google.visualization.DataTable();
			            data3.addColumn('string', '<?php echo get_string('ano','local_wellness')?>');
			            data3.addColumn('string', '<?php echo get_string('sitandreachds','local_wellness')?>');
			            data3.addColumn('string', '<?php echo get_string('sitandreachis','local_wellness')?>');
			            data3.addColumn('string', '<?php echo get_string('trunklifts','local_wellness')?>');
            <?php while ($row = mysql_fetch_array($result3)) { ?>
        				data3.addRows([
							        ['<?php echo $row['Ano']?>',
							         '<?php echo $row['Sit&reach-D']?>',
							         '<?php echo $row['Sit&reach-IZ']?>',
							         '<?php echo $row['Trunk Lift']?>'],
							        ]);		
            <?php }?>
            //Datos tabla resistencia
			var data4 = new google.visualization.DataTable();
			            data4.addColumn('string', '<?php echo get_string('ano','local_wellness')?>');
			            data4.addColumn('string', '<?php echo get_string('pacers','local_wellness')?>');
			            data4.addColumn('string', '<?php echo get_string('vo2maxs','local_wellness')?>');
            <?php while ($row = mysql_fetch_array($result4)) { ?>
          				data4.addRows([
							        ['<?php echo $row['Ano']?>',
							         '<?php echo $row['Nivel']?>',
							         '<?php echo $row['Vo2 max']?>'],
							        ]);
            <?php }?>
            //Crear las tablas
	 		var table = new google.visualization.Table(document.getElementById('tabla_antropometria'));		
	 		var table2 = new google.visualization.Table(document.getElementById('tabla_fuerza'));
	 		var table3 = new google.visualization.Table(document.getElementById('tabla_flex'));
	 		var table4 = new google.visualization.Table(document.getElementById('tabla_resist'));
	 		//Dibujar las tablas
			table.draw(data, {showRowNumber: false, width: '80%', height: '80%'});
			table2.draw(data2, {showRowNumber: false, width: '70%', height: '70%'});
			table3.draw(data3, {showRowNumber: false, width: '70%', height: '70%'});
			table4.draw(data4, {showRowNumber: false, width: '70%', height: '70%'});
		      }	      
</script>                       
</head>
</html>