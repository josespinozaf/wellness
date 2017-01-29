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

echo html_writer::start_tag('div',array('class'=>'imgselec'));
echo html_writer::empty_tag('img', array('src' => './pix/basqueth.jpg', 'alt' => 1,'width'=>500 ,'height'=>300));
echo html_writer::tag('div','<b>Básquetbol Hombres 2016</b>',array('class'=> 'decselec'));
echo html_writer::end_tag('div',array('class'=>'imgselec'));

echo html_writer::start_tag('div',array('class'=>'imgselec'));
echo html_writer::empty_tag('img', array('src' => './pix/basquetm.jpg', 'alt' => 2,'width'=>500 ,'height'=>300));
echo html_writer::tag('div','<b>Básquetbol Mujeres 2016</b>',array('class'=> 'decselec'));
echo html_writer::end_tag('div',array('class'=>'imgselec'));

echo html_writer::start_tag('div',array('class'=>'imgselec'));
echo html_writer::empty_tag('img', array('src' => './pix/futbolitoh.png', 'alt' => 3,'width'=>500 ,'height'=>300));
echo html_writer::tag('div','<b>Futbolito Hombres 2016</b>',array('class'=> 'decselec'));
echo html_writer::end_tag('div',array('class'=>'imgselec'));

echo html_writer::start_tag('div',array('class'=>'imgselec'));
echo html_writer::empty_tag('img', array('src' => './pix/futbolitom.jpg', 'alt' => 4,'width'=>500 ,'height'=>300));
echo html_writer::tag('div','<b>Futbolito Mujeres 2016</b>',array('class'=> 'decselec'));
echo html_writer::end_tag('div',array('class'=>'imgselec'));

echo html_writer::start_tag('div',array('class'=>'imgselec'));
echo html_writer::empty_tag('img', array('src' => './pix/hockeym.jpg', 'alt' => 5,'width'=>500 ,'height'=>300));
echo html_writer::tag('div','<b>Hockey Mujeres 2016</b>',array('class'=> 'decselec'));
echo html_writer::end_tag('div',array('class'=>'imgselec'));


echo html_writer::start_tag('div',array('class'=>'imgselec'));
echo html_writer::empty_tag('img', array('src' => './pix/voleim.jpg', 'alt' => 6,'width'=>500 ,'height'=>300));
echo html_writer::tag('div','<b>Voleibol Hombres 2016</b>',array('class'=> 'decselec'));
echo html_writer::end_tag('div',array('class'=>'imgselec'));


echo html_writer::start_tag('div',array('class'=>'imgselec'));
echo html_writer::empty_tag('img', array('src' => './pix/voleim.jpg', 'alt' => 7,'width'=>500 ,'height'=>300));
echo html_writer::tag('div','<b>Voleibol Mujeres 2016</b>',array('class'=> 'decselec'));
echo html_writer::end_tag('div',array('class'=>'imgselec'));

echo $OUTPUT->footer();
	?>
	