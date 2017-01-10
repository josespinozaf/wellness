<link rel="stylesheet" type="text/css" href="style.css" media="screen">
<?php
global $USER, $CFG;
require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot . '/my/lib.php');
include ("connect.php");

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
$PAGE->set_url('/local/wellness/selecciones.php', $params);
$PAGE->set_pagelayout('mydashboard');
$PAGE->set_pagetype('local-selecciones-index');
$PAGE->blocks->add_region('content');
$PAGE->set_subpage($currentpage->id);
$PAGE->set_title('Selecciones UAI');
$PAGE->set_heading($header);
$PAGE->navbar->add(get_string('navselecciones','local_wellness'), new moodle_url('/local/wellness/selecciones.php'));

$userid= $USER->id;
$usermail= $USER->email;

echo $OUTPUT->header();
?>

<html>
<head>
<style>
div.imgasd {
    margin: 5px;
    border: 1px solid #ccc;
    float: left;
    width: 30%;
}

div.imgasd:hover {
    border: 1px solid #777;
}

div.imgasd img {
    width: 400px;
    height: 200px;
}

div.descasd {
    padding: 15px;
    text-align: center;
}
</style>
</head>
<body>

<div class="imgasd">
  <a target="_blank" href="./pix/1.jpg">
    <img src="./pix/basqueth.jpg" alt="1" width="500" height="300">
  </a>
  <div class="descasd"><b>Básquetbol Hombres 2016</b></div>
</div>

<div class="imgasd">
  <a target="_blank" href="./pix/2.png">
	<img src="./pix/basquetm.jpg" alt="2" width="500" height="200">
  </a>
  <div class="descasd"><b>Básquetbol Mujeres 2016</b></div>
</div>

<div class="imgasd">
  <a target="_blank" href="./pix/3.jpg">
    <img src="./pix/futbolitoh.png" alt="3" width="500" height="200">
  </a>
  <div class="descasd"><b>Futbolito Hombres 2016</b></div>
</div>

<div class="imgasd">
  <a target="_blank" href="./pix/4.jpg">
    <img src="./pix/futbolitom.jpg" alt="4" width="500" height="200">
  </a>
  <div class="descasd"><b>Futbolito Mujeres 2016</b></div>
</div>

<div class="imgasd">
  <a target="_blank" href="./pix/5.jpg">
    <img src="./pix/hockeym.jpg" alt="5" width="500" height="200">
  </a>
  <div class="descasd"><b>Hockey Mujeres 2016</b></div>
</div>

<div class="imgasd">
  <a target="_blank" href="./pix/4.jpg">
    <img src="./pix/voleim.jpg" alt="6" width="500" height="200">
  </a>
  <div class="descasd"><b>Voleibol Hombres 2016</b></div>
</div>

<div class="imgasd">
  <a target="_blank" href="./pix/4.jpg">
    <img src="./pix/voleim.jpg" alt="7" width="500" height="200">
  </a>
  <div class="descasd"><b>Voleibol Mujeres 2016</b></div>
</div>

</body>
</html>

<?php
echo $OUTPUT->footer();
	?>
	