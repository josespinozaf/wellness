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
$PAGE->set_url('/local/wellness/clases.php', $params);
$PAGE->set_pagelayout('mydashboard');
$PAGE->set_pagetype('local-clases-index');
$PAGE->blocks->add_region('content');
$PAGE->set_subpage($currentpage->id);
$PAGE->set_title('Clases');
$PAGE->set_heading($header);
$PAGE->navbar->add(get_string('navclases','local_wellness'), new moodle_url('/local/wellness/clases.php'));

$userid= $USER->id;
$usermail= $USER->email;



echo $OUTPUT->header();

if(has_capability("local/wellness:seebutton", $context) ){
	echo "<form action='../wellness/formulariofoto.php' method='POST'>";
	echo "<input type='submit' style='clear: left' name='Agregar' value='Agregar foto a clase'>";
	echo "<input type='submit' name='Cambiar' value='Cambiar foto a clase'>";
	echo "</form>";
}

$result = mysql_query("SELECT DISTINCT mcm.* , mc.* FROM mdl_course_modules as mcm
		INNER JOIN mdl_course as mc ON mcm.course = mc.id
		WHERE mcm.module = 9
		GROUP BY mc.fullname", $db);

if (!$result) {
	die("Error en la peticion SQL: " . mysql_error());
}
$resultfoto = mysql_query("SELECT DISTINCT mc.* , pp.* FROM mdl_course as mc INNER JOIN imagenes as pp ON mc.fullname = pp.nombre", $db);
$clases = array();
$fotos = array();
while ($clase =  mysql_fetch_assoc($result))
{
	$clases[] = $clase;
}
while ($foto =  mysql_fetch_assoc($resultfoto))
{
	$fotos[] = $foto;
}
foreach ($clases as $clase)
{
	foreach ($fotos as $foto)
	{
	if 	($clase['fullname'] == $foto['nombre']){	
		echo '<div class="img">';	
		echo "<a href='/../../moodle/course/view.php?id=".$clase['course']."'>";
		echo "<img  src='/../../moodle/local/wellness/imagen.php?nombre=".$clase['fullname']."' alt=".$clase['fullname']."></img></a>";
		echo '<div class="desc">'.$clase['fullname'].'</div></div>';
	}
	}
} 

echo $OUTPUT->footer();
	?>
	
	