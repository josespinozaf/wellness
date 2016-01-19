<?php
global $USER, $CFG;
require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot . '/my/lib.php');

redirect_if_major_upgrade_required();


$edit   = optional_param('edit', null, PARAM_BOOL);    // Turn editing on and off
$reset  = optional_param('reset', null, PARAM_BOOL);

require_login();

// $hassiteconfig = has_capability('moodle/site:config', context_system::instance());
// if ($hassiteconfig && moodle_needs_upgrading()) {
// 	redirect(new moodle_url('/admin/index.php'));
// }

// $strmymoodle = get_string('myhome');

// if (isguestuser()) {  //** Force them to see system default, no editing allowed**//
// 	//** If guests are not allowed my moodle, send them to front page.**//
// 	if (empty($CFG->allowguestmymoodle)) {
// 		redirect(new moodle_url('/', array('redirect' => 0)));
// 	}

// 	$userid = null;
// 	$USER->editing = $edit = 0;  // Just in case 
// 	$context = context_system::instance();
// 	$PAGE->set_blocks_editing_capability('moodle/my:configsyspages');  // unlikely :)
// 	$header = "$SITE->shortname: $strmymoodle (GUEST)";
// 	$pagetitle = $header;

// } else {        // We are trying to view or edit our own My Moodle page
// 	$userid = $USER->id;  // Owner of the page
// 	$context = context_user::instance($USER->id);
// 	$PAGE->set_blocks_editing_capability('moodle/my:manageblocks');
// 	$header = fullname($USER);
// 	$pagetitle = $strmymoodle;
// }

// // Get the My Moodle page info.  Should always return something unless the database is broken.
// if (!$currentpage = my_get_page($userid, MY_PAGE_PRIVATE)) {
// 	print_error('mymoodlesetup');
// }

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

	$rows = array();
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

	?>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript">
    google.load('visualization', '1', {'packages':['corechart']});

    function drawChart() {
      var data = new google.visualization.DataTable(<?=$graficotabla1?>);
      var options = {
           title: '<?php echo get_string('grafico','local_wellness')?>',
          is3D: 'true',
          width: 800,
          height: 230,
        };
      var formatter = new google.visualization.NumberFormat(
      {negativeColor: 'red', negativeParens: true, pattern: '###.###'});
     formatter.format(data, 1); 
      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
     chart.draw(data, options);
    }
    google.setOnLoadCallback(drawChart);
    </script>   
<?php
	$sql = mysql_query("SELECT * FROM fitnessgram WHERE email='$usermail'");
	
	$rows = array();
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
	$rows = array();
	while($r = mysql_fetch_assoc($sql)) {
			$graf1 = array();
			$graf1[] = array('v' => (string) $r['Ano']);
			$graf1[] = array('v' => (doubleval($r['Abd'])) );
			$graf1[] = array('v' => (float) (trim($r['Pull Up'])) );
			$rows[] = array('c' => $graf1);
	}
	}
	else if ($data['Sexo']=='M'){
	$rows = array();
	while($r = mysql_fetch_assoc($sql)) {
			$graf1 = array();
			$graf1[] = array('v' => (string) $r['Ano']);
			$graf1[] = array('v' => (doubleval($r['Abd'])) );				
			$graf1[] = array('v' => (float) (trim($r['Push Up'])) );	
			$rows[] = array('c' => $graf1);
	}
	}
	$tabla1['rows'] = $rows;
	$graficotabla2 = json_encode($tabla1);
?>
    <script type="text/javascript">

    google.load('visualization', '1', {'packages':['corechart']});
    function drawChart() {

      var data = new google.visualization.DataTable(<?=$graficotabla2?>);
      var options = {
           title: '<?php echo get_string('grafico','local_wellness')?>',
          is3D: 'true',
          width: 800,
          height: 230,          
        };
      var formatter = new google.visualization.NumberFormat(
      {negativeColor: 'red', negativeParens: true, pattern: '###.###'});
     formatter.format(data, 1); 
      var chart = new google.visualization.LineChart(document.getElementById('chart_div2'));
     chart.draw(data, options);
    }
    google.setOnLoadCallback(drawChart);
    </script>
<?php
	$sql1 = mysql_query("SELECT * FROM fitnessgram WHERE email='$usermail'");	
	$rows = array();
	$tabla2 = array();
	$tabla2['cols'] = array(
			array('label' => get_string('ano','local_wellness'), 'type' => 'string'),
		    array('label' => get_string('sitandreachds','local_wellness'), 'type' => 'number'),
			array('label' => get_string('sitandreachis','local_wellness'), 'type' => 'number'),
			array('label' => get_string('trunklifts','local_wellness'), 'type' => 'number')
	);

	$rows = array();
	while($r = mysql_fetch_assoc($sql1)) {
		    $graf2 = array();
		    $graf2[] = array('v' => (string) $r['Ano']); 
		    $graf2[] = array('v' => (doubleval($r['Sit&reach-D'])) ); 
		    $graf2[] = array('v' => (float) (trim($r['Sit&reach-IZ'])) );
		    $graf2[] = array('v' => (float) (trim($r['Trunk Lift'])) );
		    $rows[] = array('c' => $graf2);
	}
	$tabla2['rows'] = $rows;
	$graficotabla3 = json_encode($tabla2)
?>
    <script type="text/javascript">
    google.load('visualization', '1', {'packages':['corechart']});
    function drawChart() {
      var data = new google.visualization.DataTable(<?=$graficotabla3?>);
      var options = {
           title: '<?php echo get_string('grafico','local_wellness')?>',
          is3D: 'true',
          width: 800,
          height: 230,          
        };
      var formatter = new google.visualization.NumberFormat(
      {negativeColor: 'red', negativeParens: true, pattern: '###.###'});
     formatter.format(data, 1); 
      var chart = new google.visualization.LineChart(document.getElementById('chart_div3'));
     chart.draw(data, options);
    }
    google.setOnLoadCallback(drawChart);
    </script>   
<?php
	$sql2 = mysql_query("SELECT * FROM fitnessgram WHERE email='$usermail'");
	
	$rows = array();
	$tabla3 = array();
	$tabla3['cols'] = array(
		    array('label' => get_string('ano','local_wellness'), 'type' => 'string'),
		    array('label' => get_string('pacers','local_wellness'), 'type' => 'number'),
			array('label' => get_string('vo2maxs','local_wellness'), 'type' => 'number')
	);
	$rows = array();
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
    <script type="text/javascript">

    google.load('visualization', '1', {'packages':['corechart']});
    function drawChart() {

      var data = new google.visualization.DataTable(<?=$graficotabla4?>);
      var options = {
           title: '<?php echo get_string('grafico','local_wellness')?>',
          is3D: 'true',
          width: 800,
          height: 230,          
        };
      var formatter = new google.visualization.NumberFormat(
      {negativeColor: 'red', negativeParens: true, pattern: '###.###'});
     formatter.format(data, 1); 
      var chart = new google.visualization.LineChart(document.getElementById('chart_div4'));
     chart.draw(data, options);
    }
    google.setOnLoadCallback(drawChart);
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
	echo '<h3>'.get_string('nohayfitnessgram','local_wellness').'</h3>';}?>
</body>
</html>
<?php
echo $OUTPUT->footer();
?> 