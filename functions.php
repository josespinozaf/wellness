<html>
<head>
<?php
//**Conexión base de datos**// 
include ("connect.php");
//** USUARIO**//
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
?>


<!-- Tabla de antropometria -->
<script type="text/javascript" >
		google.load("visualization", "1.1", {packages:["table"]});
		google.setOnLoadCallback(drawTable);
		function drawTable() {
			var data = new google.visualization.DataTable();
			data.addColumn('string', 'Año');
			data.addColumn('string', 'Talla');
			data.addColumn('string', 'Peso');
			data.addColumn('string', 'IMC');
			data.addColumn('string', '% Grasa');
		          <?php
		          while ($row = mysql_fetch_array($result)) { ?>
		          data.addRows([
		          ['<?php echo $row['Ano']?>','<?php echo $row['Talla']?>','<?php echo $row['Peso']?>','<?php echo $row['IMC']?>','<?php echo $row['%Grasa']?>'],
		          ]);
		<?php }?>
		        var table = new google.visualization.Table(document.getElementById('table_div1'));
		
		        table.draw(data, {showRowNumber: false, width: '80%', height: '80%'});
		      }
</script>
<!-- Tabla de Fuerza	 -->
<script type="text/javascript" >

      google.load("visualization", "1.1", {packages:["table"]});
      google.setOnLoadCallback(drawTable);
      function drawTable() {
          var data = new google.visualization.DataTable();
          data.addColumn('string', 'Año');
          data.addColumn('string', 'Abd');
          data.addColumn('string', 'Push Up');
          <?php
			
			while ($row = mysql_fetch_array($result2)) { ?>
          data.addRows([
        ['<?php echo $row['Ano']?>','<?php echo $row['Abd']?>','<?php echo $row['Push Up']?>'],
         ]);
<?php }?>
        var table = new google.visualization.Table(document.getElementById('table_div2'));
        table.draw(data, {showRowNumber: false, width: '70%', height: '70%'});
      }
</script>
<!-- Tabla de Flexivilidad      -->
<script type="text/javascript" >
      google.load("visualization", "1.1", {packages:["table"]});
      google.setOnLoadCallback(drawTable);
      function drawTable() {
          var data = new google.visualization.DataTable();
          data.addColumn('string', 'Año');
          data.addColumn('string', 'Sit&Reach-D');
          data.addColumn('string', 'Sit&Reach-I');
          data.addColumn('string', 'Trunk Lift');
          <?php while ($row = mysql_fetch_array($result3)) { ?>
          data.addRows([
        ['<?php echo $row['Ano']?>','<?php echo $row['Sit&reach-D']?>','<?php echo $row['Sit&reach-IZ']?>','<?php echo $row['Trunk Lift']?>'],
            ]);		
          <?php }?>
        var table = new google.visualization.Table(document.getElementById('table_div3'));
        table.draw(data, {showRowNumber: false, width: '70%', height: '70%'});
      }
</script>
<!-- Tabla de Resistencia -->
<script type="text/javascript" >
      google.load("visualization", "1.1", {packages:["table"]});
      google.setOnLoadCallback(drawTable);
      function drawTable() {
          var data = new google.visualization.DataTable();
          data.addColumn('string', 'Año');
          data.addColumn('string', 'Pacer');
          	data.addColumn('string', 'Vo2 Max');
          <?php while ($row = mysql_fetch_array($result4)) { ?>
          data.addRows([
                        ['<?php echo $row['Ano']?>','<?php echo $row['Nivel']?>','<?php echo $row['Vo2 max']?>'],
                            ]);
                          <?php }?>
                        var table = new google.visualization.Table(document.getElementById('table_div4'));
                        table.draw(data, {showRowNumber: false, width: '70%', height: '70%'});
          }   
</script>
                          
</head>
</html>