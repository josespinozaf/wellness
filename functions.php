<html>
<head>
<?php
//**Conexión base de datos**// 
include ("connect.php");

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


<!-- Tabla de antropometria -->
<script type="text/javascript" >
		google.load("visualization", "1.1", {packages:["table"]});
		google.setOnLoadCallback(drawTable);
		function drawTable() {
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
	  var table = new google.visualization.Table(document.getElementById('tabla_antropometria'));		
	  table.draw(data, {showRowNumber: false, width: '80%', height: '80%'});
		      }	      
</script>
		
		
<!-- Tabla de Fuerza	 -->
<script type="text/javascript" >

      google.load("visualization", "1.1", {packages:["table"]});
      google.setOnLoadCallback(drawTable);
      function drawTable() {
          var data = new google.visualization.DataTable();
          data.addColumn('string', '<?php echo get_string('ano','local_wellness')?>');
          data.addColumn('string', '<?php echo get_string('abds','local_wellness')?>');          
          data.addColumn('string', '<?php if ($data['Sexo']=='F')
          								  	echo get_string('pullups','local_wellness');
          								  else if ($data['Sexo']=='M') 
          								    echo get_string('pushups','local_wellness');?>');
       
          <?php	while ($row = mysql_fetch_array($result2)) { ?>
          data.addRows([
        ['<?php echo $row['Ano']?>',
         '<?php echo $row['Abd']?>',
         '<?php if ($row['Sexo']=='M') 
         				  echo $row['Push Up']; 
         			else 
         				  echo $row['Pull Up'];?>'],
        ]);
<?php }?>
        var table = new google.visualization.Table(document.getElementById('tabla_fuerza'));
        table.draw(data, {showRowNumber: false, width: '70%', height: '70%'});
      }
</script>


<!-- Tabla de Flexibilidad      -->
<script type="text/javascript" >
      google.load("visualization", "1.1", {packages:["table"]});
      google.setOnLoadCallback(drawTable);
      function drawTable() {
          var data = new google.visualization.DataTable();
          data.addColumn('string', '<?php echo get_string('ano','local_wellness')?>');
          data.addColumn('string', '<?php echo get_string('sitandreachds','local_wellness')?>');
          data.addColumn('string', '<?php echo get_string('sitandreachis','local_wellness')?>');
          data.addColumn('string', '<?php echo get_string('trunklifts','local_wellness')?>');
          <?php while ($row = mysql_fetch_array($result3)) { ?>
          data.addRows([
        ['<?php echo $row['Ano']?>',
         '<?php echo $row['Sit&reach-D']?>',
         '<?php echo $row['Sit&reach-IZ']?>',
         '<?php echo $row['Trunk Lift']?>'],
        ]);		
          <?php }?>
        var table = new google.visualization.Table(document.getElementById('tabla_flex'));
        table.draw(data, {showRowNumber: false, width: '70%', height: '70%'});
      }
</script>
          
          
<!-- Tabla de Resistencia -->
<script type="text/javascript" >
      google.load("visualization", "1.1", {packages:["table"]});
      google.setOnLoadCallback(drawTable);
      function drawTable() {
          var data = new google.visualization.DataTable();
          data.addColumn('string', '<?php echo get_string('ano','local_wellness')?>');
          data.addColumn('string', '<?php echo get_string('pacers','local_wellness')?>');
          data.addColumn('string', '<?php echo get_string('vo2maxs','local_wellness')?>');
          <?php while ($row = mysql_fetch_array($result4)) { ?>
          data.addRows([
        ['<?php echo $row['Ano']?>',
         '<?php echo $row['Nivel']?>',
         '<?php echo $row['Vo2 max']?>'],
        ]);
          <?php }?>
         var table = new google.visualization.Table(document.getElementById('tabla_resist'));
         table.draw(data, {showRowNumber: false, width: '70%', height: '70%'});
          }
</script>                          
</head>
</html>