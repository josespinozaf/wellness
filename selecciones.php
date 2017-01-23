<?php
//Configuracion de la pagina
require_once (dirname ( __FILE__ ) . '/conf.php');
$params = array();
$PAGE->set_context($context);
$PAGE->set_url('/local/wellness/selecciones.php', $params);
$PAGE->set_pagelayout('mydashboard');
$PAGE->set_pagetype('local-wellness-selecciones');
$PAGE->blocks->add_region('content');
$PAGE->set_subpage($currentpage->id);
$PAGE->set_title('Selecciones UAI');
$PAGE->set_heading($header);
$PAGE->navbar->add(get_string('navselecciones','local_wellness'), new moodle_url('/local/wellness/selecciones.php'));

//Header
echo $OUTPUT->header();
?>

<html>
<body>
<!-- Dislay Selecciones -->
<div class="imgselec">
  <a target="_blank" href="./pix/1.jpg">
    <img src="./pix/basqueth.jpg" alt="1" width="500" height="300">
  </a>
  <div class="descselec"><b>Básquetbol Hombres 2016</b></div>
</div>

<div class="imgselec">
  <a target="_blank" href="./pix/2.png">
	<img src="./pix/basquetm.jpg" alt="2" width="500" height="200">
  </a>
  <div class="descselec"><b>Básquetbol Mujeres 2016</b></div>
</div>

<div class="imgselec">
  <a target="_blank" href="./pix/3.jpg">
    <img src="./pix/futbolitoh.png" alt="3" width="500" height="200">
  </a>
  <div class="descselec"><b>Futbolito Hombres 2016</b></div>
</div>

<div class="imgselec">
  <a target="_blank" href="./pix/4.jpg">
    <img src="./pix/futbolitom.jpg" alt="4" width="500" height="200">
  </a>
  <div class="descselec"><b>Futbolito Mujeres 2016</b></div>
</div>

<div class="imgselec">
  <a target="_blank" href="./pix/5.jpg">
    <img src="./pix/hockeym.jpg" alt="5" width="500" height="200">
  </a>
  <div class="descselec"><b>Hockey Mujeres 2016</b></div>
</div>

<div class="imgselec">
  <a target="_blank" href="./pix/4.jpg">
    <img src="./pix/voleim.jpg" alt="6" width="500" height="200">
  </a>
  <div class="descselec"><b>Voleibol Hombres 2016</b></div>
</div>

<div class="imgselec">
  <a target="_blank" href="./pix/4.jpg">
    <img src="./pix/voleim.jpg" alt="7" width="500" height="200">
  </a>
  <div class="descselec"><b>Voleibol Mujeres 2016</b></div>
</div>

</body>
</html>

<?php
echo $OUTPUT->footer();
	?>
	