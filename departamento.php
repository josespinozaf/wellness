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


echo html_writer::start_tag('div',array('class'=>'imgasd'));
echo html_writer::empty_tag('img', array('src' => './pix/1.jpg', 'alt' => 1,'width'=>300 ,'height'=>200));
echo html_writer::tag('div','Presidente Deportes UAI',array('class'=> 'descasd'));
echo html_writer::tag('div','<b>Nombre Apellido</b>',array('class'=> 'descasd'));
echo html_writer::end_tag('div',array('class'=>'imgasd'));

echo html_writer::start_tag('div',array('class'=>'imgasd'));
echo html_writer::empty_tag('img', array('src' => './pix/2.png', 'alt' => 2,'width'=>300 ,'height'=>200));
echo html_writer::tag('div','Sub-Presidente Deportes UAI',array('class'=> 'descasd'));
echo html_writer::tag('div','<b>Nombre Apellido</b>',array('class'=> 'descasd'));
echo html_writer::end_tag('div',array('class'=>'imgasd'));

echo html_writer::start_tag('div',array('class'=>'imgasd'));
echo html_writer::empty_tag('img', array('src' => './pix/3.jpg', 'alt' => 3,'width'=>300 ,'height'=>200));
echo html_writer::tag('div','Profesor Trekking',array('class'=> 'descasd'));
echo html_writer::tag('div','<b>Nombre Apellido</b>',array('class'=> 'descasd'));
echo html_writer::end_tag('div',array('class'=>'imgasd'));

echo html_writer::start_tag('div',array('class'=>'imgasd'));
echo html_writer::empty_tag('img', array('src' => './pix/4.jpg', 'alt' => 3,'width'=>300 ,'height'=>200));
echo html_writer::tag('div','Profesora RPM',array('class'=> 'descasd'));
echo html_writer::tag('div','<b>Nombre Apellido</b>',array('class'=> 'descasd'));
echo html_writer::end_tag('div',array('class'=>'imgasd'));

echo $OUTPUT->footer();

?>
	
	