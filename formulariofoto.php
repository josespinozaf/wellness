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

include ('connect.php');
$result = mysql_query("SELECT DISTINCT mcm.* , mc.* FROM mdl_course_modules as mcm
		INNER JOIN mdl_course as mc ON mcm.course = mc.id
		WHERE mcm.module = 9
		GROUP BY mc.fullname", $db);

$resultrutina = mysql_query("SELECT DISTINCT mp.* , mc.* FROM mdl_course_modules as mc
			INNER JOIN mdl_page as mp ON mc.course = mp.course AND mc.instance = mp.id
			WHERE mp.course = 5 and mc.module = 15
			GROUP BY mp.name", $db);

echo $OUTPUT->header();


if (has_capability("local/wellness:formclases", $context) ){
	if (isset($_POST['Agregar'])){
	?>
	
	<form action="subir.php" method="POST" enctype="multipart/form-data">
			<h3>Subir imagen de la clase:</h3>
			Nombre de la clase:
			<select name="nombre">
					  <?php
					  $clases = array();
					  while ($clase =  mysql_fetch_assoc($result))
					  {
					  	$clases[] = $clase;
					  }
					  foreach ($clases as $clase)
					  {
					  	echo "<option  value='".$clase['fullname'] ."'>".$clase['fullname'] ."</option>";
					  }
					  ?>
			</select><br>
			<label for="imagen">Imagen:* <input type="file" name="imagen" id="imagen" /></label>
			<p>*Este archivo debe ser .jpg, .jpeg, .gif, .png</p>
			<br>
			<input type="submit" name="subiragregar" value="Subir"/>
	</form>
	<?php }
	if (isset($_POST['Cambiar'])){	
	?>
			<form action="subir.php" method="POST" enctype="multipart/form-data">
			<h3>Cambiar imagen de la clase:</h3>
			Nombre de la clase:
			<select name="nombre">
					  <?php
					  $clases = array();
					  while ($clase =  mysql_fetch_assoc($result))
					  {
					  	$clases[] = $clase;
					  }
					  foreach ($clases as $clase)
					  {
					  	echo "<option  value='".$clase['fullname'] ."'>".$clase['fullname'] ."</option>";
					  }
					  ?>
			</select><br>
			<label for="imagen">Imagen:* <input type="file" name="imagen" id="imagen" /></label>
			<p>*Este archivo debe ser .jpg, .jpeg, .gif, .png</p>
			<br>
			<input type="submit" name="subircambiar" value="Subir"/>
	</form>
	<?php
	} 
	if (isset($_POST['AgregarRutina'])){
	?>	
			<form action="subir.php" method="POST" enctype="multipart/form-data">
			<h3>Agregar imagen de la rutina:</h3>
			Nombre de la clase:
			<select name="nombre">
					  <?php
					  $rutinas = array();
					  while ($rutina =  mysql_fetch_assoc($resultrutina))
					  {
					  	$rutinas[] = $rutina;
					  }
					  foreach ($rutinas as $rutina)
					  {
					  	echo "<option  value='".$rutina['name'] ."'>".$rutina['name'] ."</option>";
					  }
					  ?>
			</select><br>
			<label for="imagen">Imagen:* <input type="file" name="imagen" id="imagen" /></label>
			<p>*Este archivo debe ser .jpg, .jpeg, .gif, .png</p>
			<br>
			<input type="submit" name="subiragregar" value="Subir"/>
	</form>
	<?php 
	}
	if (isset($_POST['CambiarRutina'])){
		?>
			<form action="subir.php" method="POST" enctype="multipart/form-data">
			<h3>Cambiar imagen de la rutina:</h3>
			Nombre de la clase:
			<select name="nombre">
					  <?php
					  $rutinas = array();
					  while ($rutina =  mysql_fetch_assoc($resultrutina))
					  {
					  	$rutinas[] = $rutina;
					  }
					  foreach ($rutinas as $rutina)
					  {
					  	echo "<option  value='".$rutina['name'] ."'>".$rutina['name'] ."</option>";
					  }
					  ?>
			</select><br>
			<label for="imagen">Imagen:* <input type="file" name="imagen" id="imagen" /></label>
			<p>*Este archivo debe ser .jpg, .jpeg, .gif, .png</p>
			<br>
			<input type="submit" name="subircambiar" value="Subir"/>
	</form>
<?php 
	}
	}
	else {
		print_error('ACCESS DENIED');
	}
echo $OUTPUT->footer();
?>
