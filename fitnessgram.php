<?php
global $USER, $CFG;
require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot . '/my/lib.php');

redirect_if_major_upgrade_required();


$edit   = optional_param('edit', null, PARAM_BOOL);    // Turn editing on and off
$reset  = optional_param('reset', null, PARAM_BOOL);

require_login();

$hassiteconfig = has_capability('moodle/site:config', context_system::instance());
if ($hassiteconfig && moodle_needs_upgrading()) {
	redirect(new moodle_url('/admin/index.php'));
}

$strmymoodle = get_string('myhome');

if (isguestuser()) {  // Force them to see system default, no editing allowed
	// If guests are not allowed my moodle, send them to front page.
	if (empty($CFG->allowguestmymoodle)) {
		redirect(new moodle_url('/', array('redirect' => 0)));
	}

	$userid = null;
	$USER->editing = $edit = 0;  // Just in case
	$context = context_system::instance();
	$PAGE->set_blocks_editing_capability('moodle/my:configsyspages');  // unlikely :)
	$header = "$SITE->shortname: $strmymoodle (GUEST)";
	$pagetitle = $header;

} else {        // We are trying to view or edit our own My Moodle page
	$userid = $USER->id;  // Owner of the page
	$context = context_user::instance($USER->id);
	$PAGE->set_blocks_editing_capability('moodle/my:manageblocks');
	$header = fullname($USER);
	$pagetitle = $strmymoodle;
}

// Get the My Moodle page info.  Should always return something unless the database is broken.
if (!$currentpage = my_get_page($userid, MY_PAGE_PRIVATE)) {
	print_error('mymoodlesetup');
}

// desde aqui se debe configurar la pag
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
// The Chart table contains two fields: weekly_task and percentage
// This example will display a pie chart. If you need other charts such as a Bar chart, you will need to modify the code a little to make it work with bar chart and other charts
$sth = mysql_query("SELECT * FROM fitnessgram WHERE email='$usermail'");

$rows = array();
$table = array();
$table['cols'] = array(

    // Labels for your chart, these represent the column titles
    // Note that one column is in "string" format and another one is in "number" format as pie chart only required "numbers" for calculating percentage and string will be used for column title
    array('label' => get_string('ano','local_wellness'), 'type' => 'string'),
    array('label' => get_string('peso','local_wellness'), 'type' => 'number'),
	array('label' => get_string('imcs','local_wellness'), 'type' => 'number'),
	array('label' => get_string('talla','local_wellness'), 'type' => 'number'),
	array('label' => get_string('grasas','local_wellness'), 'type' => 'number')

);

$rows = array();
while($r = mysql_fetch_assoc($sth)) {
    $temp = array();
    // the following line will be used to slice the Pie chart
    $temp[] = array('v' => (string) $r['Ano']); 

    // Values of each slice
    $temp[] = array('v' => ((float)$r['Peso']) ); 
    $temp[] = array('v' => (float) (trim($r['IMC'])) );
    $temp[] = array('v' => (float) (trim($r['Talla'])) );
    $temp[] = array('v' => (float) (trim($r['%Grasa'])) );
    $rows[] = array('c' => $temp);
  
}

$table['rows'] = $rows;
$jsonTable1 = json_encode($table);

?>
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript">

    // Load the Visualization API and the piechart package.
    google.load('visualization', '1', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    

    function drawChart() {
      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(<?=$jsonTable1?>);
      var options = {
           title: '<?php echo get_string('grafico','local_wellness')?>',
          is3D: 'true',
          width: 800,
          height: 230,
        };
      // Instantiate and draw our chart, passing in some options.
      // Do not forget to check your div ID
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
	$table = array();
	$table['cols'] = array(

    array('label' => get_string('ano','local_wellness'), 'type' => 'string'),
    array('label' => get_string('abds','local_wellness'), 'type' => 'number'),
	array('label' => get_string('pushups','local_wellness'), 'type' => 'number')
	);

	$rows = array();
	while($r = mysql_fetch_assoc($sql)) {
		$temp = array();
		$temp[] = array('v' => (string) $r['Ano']);
	
		$temp[] = array('v' => (doubleval($r['Abd'])) );
		$temp[] = array('v' => (float) (trim($r['Push Up'])) );
		$rows[] = array('c' => $temp);
	}


	$table['rows'] = $rows;
	$jsonTable2 = json_encode($table);
?>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript">


    google.load('visualization', '1', {'packages':['corechart']});

    function drawChart() {

      var data = new google.visualization.DataTable(<?=$jsonTable2?>);
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
	$sth = mysql_query("SELECT * FROM fitnessgram WHERE email='$usermail'");	
	$rows = array();
	$table = array();
	$table['cols'] = array(

	array('label' => get_string('ano','local_wellness'), 'type' => 'string'),
    array('label' => get_string('sitandreachds','local_wellness'), 'type' => 'number'),
	array('label' => get_string('sitandreachis','local_wellness'), 'type' => 'number'),
	array('label' => get_string('trunklifts','local_wellness'), 'type' => 'number')

	);

	$rows = array();
	while($r = mysql_fetch_assoc($sth)) {
	    $temp = array();
	    $temp[] = array('v' => (string) $r['Ano']); 

	    $temp[] = array('v' => (doubleval($r['Sit&reach-D'])) ); 
	    $temp[] = array('v' => (float) (trim($r['Sit&reach-IZ'])) );
	    $temp[] = array('v' => (float) (trim($r['Trunk Lift'])) );
	    $rows[] = array('c' => $temp);
	}

	$table['rows'] = $rows;
	$jsonTable3 = json_encode($table)
?>

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript">

    google.load('visualization', '1', {'packages':['corechart']});

    function drawChart() {

      var data = new google.visualization.DataTable(<?=$jsonTable3?>);
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
	$sth = mysql_query("SELECT * FROM fitnessgram WHERE email='$usermail'");
	
	$rows = array();
	$table = array();
	$table['cols'] = array(

    array('label' => get_string('ano','local_wellness'), 'type' => 'string'),
    array('label' => get_string('pacers','local_wellness'), 'type' => 'number'),
	array('label' => get_string('vo2maxs','local_wellness'), 'type' => 'number')
	);

	$rows = array();

	while($r = mysql_fetch_assoc($sth)) {
		$temp = array();
		$temp[] = array('v' => (string) $r['Ano']);
	
		$temp[] = array('v' => (doubleval($r['Nivel'])) );
		$temp[] = array('v' => (float) (trim($r['Vo2 max'])) );
		$rows[] = array('c' => $temp);

	}

	$table['rows'] = $rows;
	$jsonTable4 = json_encode($table);
?>

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript">

    google.load('visualization', '1', {'packages':['corechart']});
    

    function drawChart() {

      var data = new google.visualization.DataTable(<?=$jsonTable4?>);
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
   <div class="tabs">
   <div class="tab">
       <input type="radio" id="tab-1" name="tab-group-1" checked>
       <label for="tab-1"><?php echo get_string('antropometria','local_wellness')?></label>
     <div class="content1">
     <div id="table_div1"></div><br>
     <h6><font color="white">
     <?php echo get_string('imcs','local_wellness').' = '.get_string('imc','local_wellness').'<br>';
     	   echo get_string('grasas','local_wellness').' = '.get_string('grasa','local_wellness').'<br>'; 
     	   ?></font></h6>   
  		<div id="chart_div"></div>
      </div>
   </div>
   <div class="tab">
       <input type="radio" id="tab-2" name="tab-group-1">
       <label for="tab-2"><?php echo get_string('fuerza','local_wellness')?></label>
       <div class="content1"> 
     <div id="table_div2"></div><br>
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
     <div id="table_div3"></div>
     <br>
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
     <div id="table_div4"></div><br>
      <h6><font color="white">
     <?php echo get_string('pacers','local_wellness').' = '.get_string('pacer','local_wellness').'<br>';
     	   echo get_string('vo2maxs','local_wellness').' = '.get_string('vo2max','local_wellness').'<br><br>';?></font></h6>
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