<?php
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
$PAGE->set_url('/local/fitnessgram/fitnessgram.php', $params);
$PAGE->set_pagelayout('mydashboard');
$PAGE->set_pagetype('local-fitnessgram-fitnessgram');
$PAGE->blocks->add_region('content');
$PAGE->set_subpage($currentpage->id);
$PAGE->set_title('Fitnessgram');
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
          data.addColumn('string', 'Año');
          data.addColumn('string', 'Talla');
          data.addColumn('string', 'Peso');
          data.addColumn('string', 'IMC');
          data.addColumn('string', 'Suma MM');
          data.addColumn('string', '% Grasa');
          data.addRows([
            ['2015','29','69','20','100','19'],
            ['2015','29','69','20','100','19'],
            ['2015','29','69','20','100','19']
            ]);

        var table = new google.visualization.Table(document.getElementById('table_div1'));

        table.draw(data, {showRowNumber: false, width: '70%', height: '70%'});
      }
    </script>
  
    <script type="text/javascript">
      google.load("visualization", "1.1", {packages:["table"]});
      google.setOnLoadCallback(drawTable);
      function drawTable() {
          var data = new google.visualization.DataTable();
          data.addColumn('string', 'Año');
          data.addColumn('string', 'Abd');
          data.addColumn('string', 'Push Up');
          data.addRows([
            ['2015','29','69'],
            ['2015','29','69'],
            ]);
        var table = new google.visualization.Table(document.getElementById('table_div2'));
        table.draw(data, {showRowNumber: false, width: '70%', height: '70%'});
      }
    </script>
    <script type="text/javascript">
      google.load("visualization", "1.1", {packages:["table"]});
      google.setOnLoadCallback(drawTable);
      function drawTable() {
          var data = new google.visualization.DataTable();
          data.addColumn('string', 'Año');
          data.addColumn('string', 'Sit&Reach-D');
          data.addColumn('string', 'Sit&Reach-I');
          data.addColumn('string', 'Trunk Lift');
          data.addRows([
            ['2015','29','69','20'],
            ['2015','29','69','20'],
            ['2015','29','69','20']
            ]);

        var table = new google.visualization.Table(document.getElementById('table_div3'));
        table.draw(data, {showRowNumber: false, width: '70%', height: '70%'});
      }
    </script>   
    <script type="text/javascript">
      google.load("visualization", "1.1", {packages:["table"]});
      google.setOnLoadCallback(drawTable);
      function drawTable() {
          var data = new google.visualization.DataTable();
          data.addColumn('string', 'Año');
          data.addColumn('string', 'Pacer');
          data.addColumn('string', 'Vo2 Max');
          data.addRows([
            ['2015','29','69'],
            ['2015','29','69'],
            ['2015','29','69']
            ]);
        var table = new google.visualization.Table(document.getElementById('table_div4'));
        table.draw(data, {showRowNumber: false, width: '70%', height: '70%'});
      }
    </script>
    <script>
    
    </script>
  
  </head>
  <body>
  <div class="tabs">
   <div class="tab">
       <input type="radio" id="tab-1" name="tab-group-1" checked>
       <label for="tab-1">Antropometria</label>
       <div class="content1">
         <h3>Antropometria</h3>
     <div id="table_div1"></div>
     <br>
      </div>
   </div>
   <div class="tab">
       <input type="radio" id="tab-2" name="tab-group-1">
       <label for="tab-2">Fuerza</label>
       <div class="content1">  <h3>Fuerza</h3>
     <div id="table_div2"></div>
     <br></div>
   </div>
   <div class="tab">
       <input type="radio" id="tab-3" name="tab-group-1">
       <label for="tab-3">Flexibilidad</label>
       <div class="content1">  <h3>Flexibilidad</h3>
     <div id="table_div3"></div>
       <br> </div>
   </div>
   <div class="tab">
       <input type="radio" id="tab-4" name="tab-group-1">
       <label for="tab-4">Resistencia</label>
       <div class="content1">     <h3>Resistencia</h3>
     <div id="table_div4"></div>
   </div>
   </div>
 
	
</div>

   
  </body>
</html>
<?php

echo $OUTPUT->footer();
?> 