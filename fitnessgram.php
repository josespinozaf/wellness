<?php
global $USER, $CFG;
require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot . '/my/lib.php');

redirect_if_major_upgrade_required();


$edit   = optional_param('edit', null, PARAM_BOOL);    // Turn editing on and off
$reset  = optional_param('reset', null, PARAM_BOOL);

require_login();

//** Configuración de la página **//
$params = array();
$PAGE->set_context($context);
$PAGE->set_url('/local/wellness/fitnessgram.php', $params);
$PAGE->set_pagelayout('mydashboard');
$PAGE->set_pagetype('local-wellness-fitnessgram');
$PAGE->blocks->add_region('content');
$PAGE->set_subpage($currentpage->id);
$PAGE->set_title(get_string('navfitnessgram','local_wellness'));
$PAGE->set_heading($header);
$PAGE->navbar->add(get_string('navfitnessgram','local_wellness'), new moodle_url('/local/wellness/fitnessgram.php'));

echo $OUTPUT->header ();
?>
<html>
  <head>
	<link rel="stylesheet" type="text/css" href="style.css" media="screen">
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>  
	<?php
  	require_once("functions.php");
  	//Grafico antropometria
	$consulta = mysql_query("SELECT * FROM fitnessgram WHERE email='$usermail'");
	$rows = array();
	$tabla = array();
	$tabla['cols'] = array(
		    array('label' => get_string('ano','local_wellness'), 'type' => 'string'),
		    array('label' => get_string('peso','local_wellness'), 'type' => 'number'),
			array('label' => get_string('imcs','local_wellness'), 'type' => 'number'),
			array('label' => get_string('talla','local_wellness'), 'type' => 'number'),
			array('label' => get_string('grasas','local_wellness'), 'type' => 'number')
		
	);
	
	while($r = mysql_fetch_assoc($consulta)) {
		    $graf = array();
		    $graf[] = array('v' => (string) $r['Ano']); 
		    $graf[] = array('v' => ((float)$r['Peso']) ); 
		    $graf[] = array('v' => (float) (trim($r['IMC'])) );
		    $graf[] = array('v' => (float) (trim($r['Talla'])) );
		    $graf[] = array('v' => (float) (trim($r['%Grasa'])) );
		    $rows[] = array('c' => $graf);
		  
	}
	$tabla['rows'] = $rows;
	$graficotabla1 = json_encode($tabla);
	
	// GRAFICO FUERZA
	$sql = mysql_query("SELECT * FROM fitnessgram WHERE email='$usermail'");
	$rows1 = array();
	$tabla1 = array();
	if ($data['Sexo']=='M'){
		$tabla1['cols'] = array(
				array('label' => get_string('ano','local_wellness'), 'type' => 'string'),
				array('label' => get_string('abds','local_wellness'), 'type' => 'number'),
				array('label' => get_string('pushups','local_wellness'), 'type' => 'number')
		);
	}
	else if ($data['Sexo']=='F'){
		$tabla1['cols'] = array(
				array('label' => get_string('ano','local_wellness'), 'type' => 'string'),
				array('label' => get_string('abds','local_wellness'), 'type' => 'number'),
				array('label' => get_string('pullups','local_wellness'), 'type' => 'number')
		);
	}
	
	if ($data['Sexo']=='F'){
		while($r = mysql_fetch_assoc($sql)) {
			$graf1 = array();
			$graf1[] = array('v' => (string) $r['Ano']);
			$graf1[] = array('v' => (doubleval($r['Abd'])) );
			$graf1[] = array('v' => (float) (trim($r['Pull Up'])) );
			$rows1[] = array('c' => $graf1);
		}
	}
	else if ($data['Sexo']=='M'){
		while($r = mysql_fetch_assoc($sql)) {
			$graf1 = array();
			$graf1[] = array('v' => (string) $r['Ano']);
			$graf1[] = array('v' => (doubleval($r['Abd'])) );
			$graf1[] = array('v' => (float) (trim($r['Push Up'])) );
			$rows1[] = array('c' => $graf1);	
	}
	}
	$tabla1['rows'] = $rows1;
	$graficotabla2 = json_encode($tabla1);
	
	//Datos del grafico de flexibilidad
	$sql1 = mysql_query("SELECT * FROM fitnessgram WHERE email='$usermail'");
	$rows = array();
	$tabla2 = array();
	$tabla2['cols'] = array(
			array('label' => get_string('ano','local_wellness'), 'type' => 'string'),
			array('label' => get_string('sitandreachds','local_wellness'), 'type' => 'number'),
			array('label' => get_string('sitandreachis','local_wellness'), 'type' => 'number'),
			array('label' => get_string('trunklifts','local_wellness'), 'type' => 'number')
	);
	while($r = mysql_fetch_assoc($sql1)) {
		$graf2 = array();
		$graf2[] = array('v' => (string) $r['Ano']);
		$graf2[] = array('v' => (doubleval($r['Sit&reach-D'])) );
		$graf2[] = array('v' => (float) (trim($r['Sit&reach-IZ'])) );
		$graf2[] = array('v' => (float) (trim($r['Trunk Lift'])) );
		$rows[] = array('c' => $graf2);
	}
	$tabla2['rows'] = $rows;
	$graficotabla3 = json_encode($tabla2);
	// Datos de grafico de resistencia
	$sql2 = mysql_query("SELECT * FROM fitnessgram WHERE email='$usermail'");
	$rows = array();
	$tabla3 = array();
	$tabla3['cols'] = array(
			array('label' => get_string('ano','local_wellness'), 'type' => 'string'),
			array('label' => get_string('pacers','local_wellness'), 'type' => 'number'),
			array('label' => get_string('vo2maxs','local_wellness'), 'type' => 'number')
	);

	while($r = mysql_fetch_assoc($sql2)) {
		$graf3 = array();
		$graf3[] = array('v' => (string) $r['Ano']);
		$graf3[] = array('v' => (doubleval($r['Nivel'])) );
		$graf3[] = array('v' => (float) (trim($r['Vo2 max'])) );
		$rows[] = array('c' => $graf3);
	}
	$tabla3['rows'] = $rows;
	$graficotabla4 = json_encode($tabla3);
	?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript">
    google.load('visualization', '1', {'packages':['corechart']});
    function drawCharts() {
      //Datos de los graficos  
      var data = new google.visualization.DataTable(<?=$graficotabla1?>);
      var data2 = new google.visualization.DataTable(<?=$graficotabla2?>);
      var data3 = new google.visualization.DataTable(<?=$graficotabla3?>);
      var data4 = new google.visualization.DataTable(<?=$graficotabla4?>);
      var options = {
			       	  title: '<?php echo get_string('grafico','local_wellness')?>',
			          is3D: 'true',
			          width: 800,
			          height: 230,
        };
      //Crear los graficos
      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
  	  var chart2 = new google.visualization.LineChart(document.getElementById('chart_div2'));
  	  var chart3 = new google.visualization.LineChart(document.getElementById('chart_div3'));
  	  var chart4 = new google.visualization.LineChart(document.getElementById('chart_div4'));
  	  //Dibujar los graficos
  		chart.draw(data, options); 
   	    chart2.draw(data2, options);
   	 	chart3.draw(data3, options);
   	 	chart4.draw(data4, options);
    }
    google.setOnLoadCallback(drawCharts);
</script>     
</head>
<body>
<?php  
 if (mysql_num_rows($result) > 0){?>
   <div class="tabs2">
   		<div class="tab">
       		<input type="radio" id="tab-1" name="tab-group-1" checked>
       		<label for="tab-1"><?php echo get_string('antropometria','local_wellness')?></label>
     		<div class="content1">
     			<div id="tabla_antropometria"></div><br>
     			<h6><font color="white">
     			<?php   echo get_string('imcs','local_wellness').' = '.get_string('imc','local_wellness').'<br>';
     	   				echo get_string('grasas','local_wellness').' = '.get_string('grasa','local_wellness').'<br>'; 
     	   		?></font></h6>   
  				<div id="chart_div"></div>
  			</div>
   		</div>
   		<div class="tab">
       		<input type="radio" id="tab-2" name="tab-group-1">
       		<label for="tab-2"><?php echo get_string('fuerza','local_wellness')?></label>
       		<div class="content1"> 
     			<div id="tabla_fuerza"></div><br>
    			 <h6><font color="white">
     			<?php echo get_string('abds','local_wellness').' = '.get_string('abd','local_wellness').'<br>';
     	   			  echo get_string('pushups','local_wellness').' = '.get_string('pushup','local_wellness').'<br>'; 
     	   			  echo get_string('pullups','local_wellness').' = '.get_string('pullup','local_wellness').'<br>';
     	   		?></font></h6>
     			<div id="chart_div2"></div>
     		</div>
     	</div>
   		<div class="tab">
       		<input type="radio" id="tab-3" name="tab-group-1">
       		<label for="tab-3"><?php echo get_string('flexibilidad','local_wellness')?></label>
       		<div class="content1"> 
     			<div id="tabla_flex"></div><br>
     			<h6><font color="white">
     			<?php echo get_string('sitandreachds','local_wellness').' = '.get_string('sitandreachd','local_wellness').'<br>';
     	   			  echo get_string('sitandreachis','local_wellness').' = '.get_string('sitandreachi','local_wellness').'<br>'; 
     	   			  echo get_string('trunklifts','local_wellness').' = '.get_string('trunklift','local_wellness').'<br>';
     	   		?></font></h6>
 				<div id="chart_div3"></div>
 			</div>
 		</div>
  		<div class="tab">
       		<input type="radio" id="tab-4" name="tab-group-1">
       		<label for="tab-4"><?php echo get_string('resistencia','local_wellness')?></label>
       		<div class="content1">   
     			<div id="tabla_resist"></div><br>
      			<h6><font color="white">
     			<?php echo get_string('pacers','local_wellness').' = '.get_string('pacer','local_wellness').'<br>';
     	   			  echo get_string('vo2maxs','local_wellness').' = '.get_string('vo2max','local_wellness').'<br><br>';
     	   		?></font></h6>
      			<div id="chart_div4"></div>
      		</div>
      	</div>
</div>  
<?php }
else { 
	echo '<h3>'.get_string('nohayfitnessgram','local_wellness').'</h3>';}
	?>
	<!-- FORMULARIO PARA AGREGAR FITNESSGRAM -- SOLO ADMIN TIENE PERMISO -->
	<br>
	<p> **Si necesitas agregar un fitnessgram o buscar a un alumno</p>
	<form action='/../../moodle/local/wellness/Dbfitnessgram.php' method='POST'>
		<input type='submit' name='AgregarFIT' value='Agregar Fitnessgram'>
		<input type='submit' name='BuscarFIT' value='Buscar Alumno'>
	</form>
</body>
</html>
<?php
echo $OUTPUT->footer();
?> 