<?php
//Configuracion de la pagina
require_once (dirname ( __FILE__ ) . '/conf.php');
$params = array();
$PAGE->set_context($context);
$PAGE->set_url('/local/wellness/departamento.php', $params);
$PAGE->set_pagelayout('mydashboard');
$PAGE->set_pagetype('local-wellness-departamento');
$PAGE->blocks->add_region('content');
$PAGE->set_subpage($currentpage->id);
$PAGE->set_title('Departamento');
$PAGE->set_heading($header);
$PAGE->navbar->add(get_string('navdepartamento','local_wellness'), new moodle_url('/local/wellness/departamento.php'));

//Header
echo $OUTPUT->header();
?>

<html>

<body>

<div class="imgasd">
  <a target="_blank" href="./pix/1.jpg">
    <img src="./pix/1.jpg" alt="1" width="300" height="200">
  </a>
  <div class="descasd">Presidente Deportes UAI</div>
  <div class="descasd"><b>Jose Pablo Espinoza</b></div>
</div>

<div class="imgasd">
  <a target="_blank" href="./pix/2.png">
	<img src="./pix/2.png" alt="2" width="300" height="200">
  </a>
  <div class="descasd">Sub-Presidente Deportes UAI</div>
  <div class="descasd"><b>Meiling Cárdenas</b></div>
</div>

<div class="imgasd">
  <a target="_blank" href="./pix/3.jpg">
    <img src="./pix/3.jpg" alt="3" width="300" height="200">
  </a>
  <div class="descasd">Profesor Crosstraining</div>
  <div class="descasd"><b>Sebastián Flores</b></div>
</div>

<div class="imgasd">
  <a target="_blank" href="./pix/4.jpg">
    <img src="./pix/4.jpg" alt="4" width="300" height="200">
  </a>
  <div class="descasd">Profesor Trekking</div>
  <div class="descasd"><b>Manolo Cololo</b></div>
</div>

<div class="imgasd">
  <a target="_blank" href="./pix/5.jpg">
    <img src="./pix/5.jpg" alt="5" width="300" height="200">
  </a>
  <div class="descasd">Profesora RPM</div>
  <div class="descasd"><b>Malala Lalala</b></div>
</div>

</body>
</html>

<?php
echo $OUTPUT->footer();
	?>
	
	