<?php
global $USER, $CFG;
require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot . '/my/lib.php');

redirect_if_major_upgrade_required();

$edit   = optional_param('edit', null, PARAM_BOOL);    // Turn editing on and off
$reset  = optional_param('reset', null, PARAM_BOOL);

// **Conectando a la base de datos**
include ("connect.php");

//** Query SQL
$userid= $USER->id;
$usermail= $USER->email;
if(isset($_POST['sem2']) && !empty($_POST['sem2']) && $_POST['sem2']==1){
$result = mysql_query("SELECT DISTINCT asistencias2.*, fitnessgram.RUT FROM asistencias2 INNER JOIN fitnessgram WHERE asistencias2.rut = fitnessgram.RUT AND fitnessgram.email = '$usermail' AND asistencias2.Periodo='S-SEM. 2012/2'", $db);

}
else if(isset($_POST['sem3']) && !empty($_POST['sem3']) && $_POST['sem3']==1){
	$result = mysql_query("SELECT DISTINCT asistencias2.*, fitnessgram.RUT FROM asistencias2 INNER JOIN fitnessgram WHERE asistencias2.rut = fitnessgram.RUT AND fitnessgram.email = '$usermail' AND asistencias2.Periodo='S-SEM. 2013/1'", $db);
}
else if(isset($_POST['sem4']) && !empty($_POST['sem4']) && $_POST['sem4']==1){
	$result = mysql_query("SELECT DISTINCT asistencias2.*, fitnessgram.RUT FROM asistencias2 INNER JOIN fitnessgram WHERE asistencias2.rut = fitnessgram.RUT AND fitnessgram.email = '$usermail' AND asistencias2.Periodo='S-SEM. 2013/2'", $db);
}
else if(isset($_POST['sem5']) && !empty($_POST['sem5']) && $_POST['sem5']==1){
	$result = mysql_query("SELECT DISTINCT asistencias2.*, fitnessgram.RUT FROM asistencias2 INNER JOIN fitnessgram WHERE asistencias2.rut = fitnessgram.RUT AND fitnessgram.email = '$usermail' AND asistencias2.Periodo='S-SEM. 2014/1'", $db);
}
else if(isset($_POST['sem6']) && !empty($_POST['sem6']) && $_POST['sem6']==1){
	$result = mysql_query("SELECT DISTINCT asistencias2.*, fitnessgram.RUT FROM asistencias2 INNER JOIN fitnessgram WHERE asistencias2.rut = fitnessgram.RUT AND fitnessgram.email = '$usermail' AND asistencias2.Periodo='S-SEM. 2014/2'", $db);
}
else if(isset($_POST['sem7']) && !empty($_POST['sem7']) && $_POST['sem7']==1){
	$result = mysql_query("SELECT DISTINCT asistencias2.*, fitnessgram.RUT FROM asistencias2 INNER JOIN fitnessgram WHERE asistencias2.rut = fitnessgram.RUT AND fitnessgram.email = '$usermail' AND asistencias2.Periodo='S-SEM. 2015/1'", $db);
}
else if(isset($_POST['sem8']) && !empty($_POST['sem8']) && $_POST['sem8']==1){
	$result = mysql_query("SELECT DISTINCT asistencias2.*, fitnessgram.RUT FROM asistencias2 INNER JOIN fitnessgram WHERE asistencias2.rut = fitnessgram.RUT AND fitnessgram.email = '$usermail' AND asistencias2.Periodo='S-SEM. 2015/2'", $db);
}
else {
	$result = mysql_query("SELECT DISTINCT asistencias2.*, fitnessgram.RUT FROM asistencias2 INNER JOIN fitnessgram WHERE asistencias2.rut = fitnessgram.RUT AND fitnessgram.email = '$usermail' AND asistencias2.Periodo='S-SEM. 2012/1'", $db);
}


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
$PAGE->set_url('/local/Asistencias/index.php', $params);
$PAGE->set_pagelayout('standard');
$PAGE->set_pagetype('local-Asistencias-index');
$PAGE->blocks->add_region('content');
$PAGE->set_subpage($currentpage->id);
$PAGE->set_title(get_string('titleasistencias','local_wellness'));
$PAGE->set_heading($header);

echo $OUTPUT->header ();
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" media="screen">
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1.1", {packages:["table"]});
      google.setOnLoadCallback(drawTable);

      function drawTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Periodo');
        data.addColumn('string', 'Fecha');
        data.addColumn('string', 'Hora Inicio');
        data.addColumn('string', 'Hora Termino');
        data.addColumn('string', 'Actividad');
        data.addColumn('string', 'Asistencia');
        <?php while ($row = mysql_fetch_array($result)) { ?>
        data.addRows([
      ['<?php echo $row['Periodo']?>','<?php echo $row['Fecha']?>','<?php echo $row['HoraInicio']?>','<?php echo $row['HoraTermino']?>','<?php echo $row['Actividad']?>','<?php echo $row['Asistencia']?>'],
       ]);
<?php }?>

        var table = new google.visualization.Table(document.getElementById('table_div'));

        table.draw(data, {showRowNumber: false, width: '100%', height: '100%'});
      }
      </script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Completadas', 45],
          ['No Completadas', 55],
         
        ]);

        var options = {
          title:'Mis Asistencias',
          is3D: true,
          slices: {
              0: { color: '#FE2E2E' },
              1: { color: '#2E2EFE' }
            }
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
         ['Mes', 'Asistencias', 'Deberias Llevar'],
         ['06',  8,      8],
         ['07',  14,     15],
         ['08',  18,      23],
         ['09',  0,     25  ],
         ['10',  0,    30]
      ]);

    var options = {
      title : 'Asistencia ideal-actual',
      vAxis: {title: 'Asistencia'},
      hAxis: {title: 'Meses'},
      seriesType: 'bars',
    
    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
    chart.draw(data, options);
  }
    </script>
    </head>
<body>


</head>
<body>

<?php if(isset($_POST['sem2']) && !empty($_POST['sem2']) && $_POST['sem2']==1){
$result = mysql_query("SELECT DISTINCT asistencias2.*, fitnessgram.RUT FROM asistencias2 INNER JOIN fitnessgram WHERE asistencias2.rut = fitnessgram.RUT AND fitnessgram.email = '$usermail' AND asistencias2.Periodo='S-SEM. 2012/2'", $db);
$asistenciasperiodo = 0;
while ($row = mysql_fetch_array($result)) {
	if ($row['Asistencia'] == '1'){
		$asistenciasperiodo = $asistenciasperiodo + 1;
	}
	else if ($row['Asistencia'] == '0,5'){
		$asistenciasperiodo = $asistenciasperiodo + 0.5;
	}
	else if ($row['Asistencia'] == '-1'){
		$asistenciasperiodo = $asistenciasperiodo - 1;
	}
}
echo "Tus asistencias en este periodo dan un total de: $asistenciasperiodo";
}
else if(isset($_POST['sem3']) && !empty($_POST['sem3']) && $_POST['sem3']==1){
	$result = mysql_query("SELECT DISTINCT asistencias2.*, fitnessgram.RUT FROM asistencias2 INNER JOIN fitnessgram WHERE asistencias2.rut = fitnessgram.RUT AND fitnessgram.email = '$usermail' AND asistencias2.Periodo='S-SEM. 2013/1'", $db);
$asistenciasperiodo = 0;
 while ($row = mysql_fetch_array($result)) { 
       if ($row['Asistencia'] == '1'){
       	$asistenciasperiodo = $asistenciasperiodo + 1;
       }
       else if ($row['Asistencia'] == '0,5'){
       	$asistenciasperiodo = $asistenciasperiodo + 0.5;
       }
       else if ($row['Asistencia'] == '-1'){
       	$asistenciasperiodo = $asistenciasperiodo - 1;
       }     	
 }
 echo "Tus asistencias en este periodo dan un total de: $asistenciasperiodo";}
else if(isset($_POST['sem4']) && !empty($_POST['sem4']) && $_POST['sem4']==1){
	$result = mysql_query("SELECT DISTINCT asistencias2.*, fitnessgram.RUT FROM asistencias2 INNER JOIN fitnessgram WHERE asistencias2.rut = fitnessgram.RUT AND fitnessgram.email = '$usermail' AND asistencias2.Periodo='S-SEM. 2013/2'", $db);
$asistenciasperiodo = 0;
 while ($row = mysql_fetch_array($result)) { 
       if ($row['Asistencia'] == '1'){
       	$asistenciasperiodo = $asistenciasperiodo + 1;
       }
       else if ($row['Asistencia'] == '0,5'){
       	$asistenciasperiodo = $asistenciasperiodo + 0.5;
       }
       else if ($row['Asistencia'] == '-1'){
       	$asistenciasperiodo = $asistenciasperiodo - 1;
       }     	
 }
 echo "Tus asistencias en este periodo dan un total de: $asistenciasperiodo";}
else if(isset($_POST['sem5']) && !empty($_POST['sem5']) && $_POST['sem5']==1){
	$result = mysql_query("SELECT DISTINCT asistencias2.*, fitnessgram.RUT FROM asistencias2 INNER JOIN fitnessgram WHERE asistencias2.rut = fitnessgram.RUT AND fitnessgram.email = '$usermail' AND asistencias2.Periodo='S-SEM. 2014/1'", $db);
$asistenciasperiodo = 0;
 while ($row = mysql_fetch_array($result)) { 
       if ($row['Asistencia'] == '1'){
       	$asistenciasperiodo = $asistenciasperiodo + 1;
       }
       else if ($row['Asistencia'] == '0,5'){
       	$asistenciasperiodo = $asistenciasperiodo + 0.5;
       }
       else if ($row['Asistencia'] == '-1'){
       	$asistenciasperiodo = $asistenciasperiodo - 1;
       }     	
 }
 echo "Tus asistencias en este periodo dan un total de: $asistenciasperiodo";}
else if(isset($_POST['sem6']) && !empty($_POST['sem6']) && $_POST['sem6']==1){
	$result = mysql_query("SELECT DISTINCT asistencias2.*, fitnessgram.RUT FROM asistencias2 INNER JOIN fitnessgram WHERE asistencias2.rut = fitnessgram.RUT AND fitnessgram.email = '$usermail' AND asistencias2.Periodo='S-SEM. 2014/2'", $db);
$asistenciasperiodo = 0;
 while ($row = mysql_fetch_array($result)) { 
       if ($row['Asistencia'] == '1'){
       	$asistenciasperiodo = $asistenciasperiodo + 1;
       }
       else if ($row['Asistencia'] == '0,5'){
       	$asistenciasperiodo = $asistenciasperiodo + 0.5;
       }
       else if ($row['Asistencia'] == '-1'){
       	$asistenciasperiodo = $asistenciasperiodo - 1;
       }     	
 }
 echo "Tus asistencias en este periodo dan un total de: $asistenciasperiodo";}
else if(isset($_POST['sem7']) && !empty($_POST['sem7']) && $_POST['sem7']==1){
	$result = mysql_query("SELECT DISTINCT asistencias2.*, fitnessgram.RUT FROM asistencias2 INNER JOIN fitnessgram WHERE asistencias2.rut = fitnessgram.RUT AND fitnessgram.email = '$usermail' AND asistencias2.Periodo='S-SEM. 2015/1'", $db);
$asistenciasperiodo = 0;
 while ($row = mysql_fetch_array($result)) { 
       if ($row['Asistencia'] == '1'){
       	$asistenciasperiodo = $asistenciasperiodo + 1;
       }
       else if ($row['Asistencia'] == '0,5'){
       	$asistenciasperiodo = $asistenciasperiodo + 0.5;
       }
       else if ($row['Asistencia'] == '-1'){
       	$asistenciasperiodo = $asistenciasperiodo - 1;
       }     	
 }
 echo "Tus asistencias en este periodo dan un total de: $asistenciasperiodo";}
else if(isset($_POST['sem8']) && !empty($_POST['sem8']) && $_POST['sem8']==1){
	$result = mysql_query("SELECT DISTINCT asistencias2.*, fitnessgram.RUT FROM asistencias2 INNER JOIN fitnessgram WHERE asistencias2.rut = fitnessgram.RUT AND fitnessgram.email = '$usermail' AND asistencias2.Periodo='S-SEM. 2015/2'", $db);
$asistenciasperiodo = 0;
 while ($row = mysql_fetch_array($result)) { 
       if ($row['Asistencia'] == '1'){
       	$asistenciasperiodo = $asistenciasperiodo + 1;
       }
       else if ($row['Asistencia'] == '0,5'){
       	$asistenciasperiodo = $asistenciasperiodo + 0.5;
       }
       else if ($row['Asistencia'] == '-1'){
       	$asistenciasperiodo = $asistenciasperiodo - 1;
       }     	
 }
 echo "Tus asistencias en este periodo dan un total de: $asistenciasperiodo";}
else {
	$result = mysql_query("SELECT DISTINCT asistencias2.*, fitnessgram.RUT FROM asistencias2 INNER JOIN fitnessgram WHERE asistencias2.rut = fitnessgram.RUT AND fitnessgram.email = '$usermail' AND asistencias2.Periodo='S-SEM. 2012/1'", $db);
$asistenciasperiodo = 0;
 while ($row = mysql_fetch_array($result)) { 
       if ($row['Asistencia'] == '1'){
       	$asistenciasperiodo = $asistenciasperiodo + 1;
       }
       else if ($row['Asistencia'] == '0,5'){
       	$asistenciasperiodo = $asistenciasperiodo + 0.5;
       }
       else if ($row['Asistencia'] == '-1'){
       	$asistenciasperiodo = $asistenciasperiodo - 1;
       }     	
 }
 echo "Tus asistencias en este periodo dan un total de: $asistenciasperiodo";}
		 ?>
		
<div class="tabs">
   <div class="tab">
       <input type="radio" id="tab-1" name="tab-group-1" checked>
       <label for="tab-1">Registro</label>
       <div class="content1">
<form name="Email Header" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<button type="submit" name="sem1" id="sem1" class="button" value="1">1er Semestre</button>
<button type="submit" name="sem2" id="sem2" class="button" value="1">2do Semestre</button>
<button type="submit" name="sem3" id="sem3" class="button" value="1">3er Semestre</button>
<button type="submit" name="sem4" id="sem4" class="button" value="1">4to Semestre</button>
<button type="submit" name="sem5" id="sem5" class="button" value="1">5to Semestre</button>
<button type="submit" name="sem6" id="sem6" class="button" value="1">6to Semestre</button>
<button type="submit" name="sem7" id="sem7" class="button" value="1">7mo Semestre</button>
<button type="submit" name="sem8" id="sem8" class="button" value="1">8vo Semestre</button>

        <div id="table_div"></div>
        </div>
   </div>
   <div class="tab">
       <input type="radio" id="tab-2" name="tab-group-1">
       <label for="tab-2">Asistencias</label>
       <div class="content1">   
        <div id="piechart_3d" style="width: 900px; height: 400px;"></div>
   </div>
   </div>
     <div class="tab">
       <input type="radio" id="tab-3" name="tab-group-1">
       <label for="tab-3">Comparación Actual-Ideal</label>
       <div class="content1">    
    <div id="chart_div" style="width: 900px; height: 400px;"></div>
    </div>
   </div>
   
</div>

</body>
</html>

<?php                        
echo $OUTPUT->footer();
?>