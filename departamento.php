<?php
// Configuracion de la pagina
require_once (dirname ( __FILE__ ) . '/conf.php');
$params = array ();
$PAGE->set_context ( $context );
$PAGE->set_url ( '/local/wellness/departamento.php', $params );
$PAGE->set_pagelayout ( 'mydashboard' );
$PAGE->set_pagetype ( 'local-wellness-departamento' );
$PAGE->blocks->add_region ( 'content' );
$PAGE->set_subpage ( $currentpage->id );
$PAGE->set_title ( get_string ( 'navdepartamento', 'local_wellness' ) );
$PAGE->set_heading ( $header );
$PAGE->navbar->add ( get_string ( 'navdepartamento', 'local_wellness' ), new moodle_url ( '/local/wellness/departamento.php' ) );

// Header
echo $OUTPUT->header ();

echo html_writer::tag ( 'h1', get_string ( 'santiago', 'local_wellness' ) );

// HTML writer para mostrar imagen, nombre y cargo de la persona
// ****SANTIAGO****
// **Cargo 1**
echo html_writer::start_tag ( 'div', array (
		'class' => 'imgasd' 
) );
echo html_writer::empty_tag ( 'img', array (
		'src' => './pix/santiago/ampuerorodrigo.jpg',
		'alt' => 1,
		'width' => 300,
		'height' => 200 
) );
echo html_writer::tag ( 'div', 'Profesor Deportes UAI', array (
		'class' => 'descasd' 
) );
echo html_writer::tag ( 'div', '<b>Rodrigo Ampuero</b>', array (
		'class' => 'descasd' 
) );
echo html_writer::end_tag ( 'div', array (
		'class' => 'imgasd' 
) );

// **Cargo 4**
echo html_writer::start_tag ( 'div', array (
		'class' => 'imgasd' 
) );
echo html_writer::empty_tag ( 'img', array (
		'src' => './pix/santiago/andradeslilian.jpg',
		'alt' => 2,
		'width' => 300,
		'height' => 210 
) );
echo html_writer::tag ( 'div', 'Profesora Deportes UAI', array (
		'class' => 'descasd' 
) );
echo html_writer::tag ( 'div', '<b>Lilian Andrades</b>', array (
		'class' => 'descasd' 
) );
echo html_writer::end_tag ( 'div', array (
		'class' => 'imgasd' 
) );

// **Cargo 3**
echo html_writer::start_tag ( 'div', array (
		'class' => 'imgasd' 
) );
echo html_writer::empty_tag ( 'img', array (
		'src' => './pix/santiago/chamorroguillermo.jpg',
		'alt' => 3,
		'width' => 300,
		'height' => 200 
) );
echo html_writer::tag ( 'div', 'Profesor Deportes UAI', array (
		'class' => 'descasd' 
) );
echo html_writer::tag ( 'div', '<b>Guillermo Chamorro</b>', array (
		'class' => 'descasd' 
) );
echo html_writer::end_tag ( 'div', array (
		'class' => 'imgasd' 
) );

// **Cargo 4**
echo html_writer::start_tag ( 'div', array (
		'class' => 'imgasd' 
) );
echo html_writer::empty_tag ( 'img', array (
		'src' => './pix/santiago/diazdouglas.jpg',
		'alt' => 4,
		'width' => 300,
		'height' => 200 
) );
echo html_writer::tag ( 'div', 'Profesor Deportes UAI', array (
		'class' => 'descasd' 
) );
echo html_writer::tag ( 'div', '<b>Douglas DÃ­az</b>', array (
		'class' => 'descasd' 
) );
echo html_writer::end_tag ( 'div', array (
		'class' => 'imgasd' 
) );

// **Cargo 5**
echo html_writer::start_tag ( 'div', array (
		'class' => 'imgasd' 
) );
echo html_writer::empty_tag ( 'img', array (
		'src' => './pix/santiago/orellanaveronica.jpg',
		'alt' => 5,
		'width' => 300,
		'height' => 200 
) );
echo html_writer::tag ( 'div', 'Profesora Deportes UAI', array (
		'class' => 'descasd' 
) );
echo html_writer::tag ( 'div', '<b>VerÃ³nica Orellana</b>', array (
		'class' => 'descasd' 
) );
echo html_writer::end_tag ( 'div', array (
		'class' => 'imgasd' 
) );

// **Cargo 6**
echo html_writer::start_tag ( 'div', array (
		'class' => 'imgasd' 
) );
echo html_writer::empty_tag ( 'img', array (
		'src' => './pix/santiago/osoriodiego.jpg',
		'alt' => 6,
		'width' => 300,
		'height' => 200 
) );
echo html_writer::tag ( 'div', 'Profesor Deportes UAI', array (
		'class' => 'descasd' 
) );
echo html_writer::tag ( 'div', '<b>Diego Osorio</b>', array (
		'class' => 'descasd' 
) );
echo html_writer::end_tag ( 'div', array (
		'class' => 'imgasd' 
) );

// **Cargo 7**
echo html_writer::start_tag ( 'div', array (
		'class' => 'imgasd' 
) );
echo html_writer::empty_tag ( 'img', array (
		'src' => './pix/santiago/poncejaviera.jpg',
		'alt' => 7,
		'width' => 300,
		'height' => 200 
) );
echo html_writer::tag ( 'div', 'Profesora Deportes UAI', array (
		'class' => 'descasd' 
) );
echo html_writer::tag ( 'div', '<b>Javiera Ponce</b>', array (
		'class' => 'descasd' 
) );
echo html_writer::end_tag ( 'div', array (
		'class' => 'imgasd' 
) );

// **Cargo 8**
echo html_writer::start_tag ( 'div', array (
		'class' => 'imgasd' 
) );
echo html_writer::empty_tag ( 'img', array (
		'src' => './pix/santiago/ruzjaviera.jpg',
		'alt' => 8,
		'width' => 300,
		'height' => 200 
) );
echo html_writer::tag ( 'div', 'Profesora Deportes UAI', array (
		'class' => 'descasd' 
) );
echo html_writer::tag ( 'div', '<b>Javiera Ruz</b>', array (
		'class' => 'descasd' 
) );
echo html_writer::end_tag ( 'div', array (
		'class' => 'imgasd' 
) );

// **Cargo 9**
echo html_writer::start_tag ( 'div', array (
		'class' => 'imgasd' 
) );
echo html_writer::empty_tag ( 'img', array (
		'src' => './pix/santiago/torogloria.jpg',
		'alt' => 9,
		'width' => 300,
		'height' => 200 
) );
echo html_writer::tag ( 'div', 'Profesora Deportes UAI', array (
		'class' => 'descasd' 
) );
echo html_writer::tag ( 'div', '<b>Gloria Toro</b>', array (
		'class' => 'descasd' 
) );
echo html_writer::end_tag ( 'div', array (
		'class' => 'imgasd' 
) );

// **Cargo 10**
echo html_writer::start_tag ( 'div', array (
		'class' => 'imgasd' 
) );
echo html_writer::empty_tag ( 'img', array (
		'src' => './pix/santiago/uribevicente.jpg',
		'alt' => 10,
		'width' => 300,
		'height' => 200 
) );
echo html_writer::tag ( 'div', 'Profesor Deportes UAI', array (
		'class' => 'descasd' 
) );
echo html_writer::tag ( 'div', '<b>Vicente Uribe</b>', array (
		'class' => 'descasd' 
) );
echo html_writer::end_tag ( 'div', array (
		'class' => 'imgasd' 
) );

// **Cargo 11**
echo html_writer::start_tag ( 'div', array (
		'class' => 'imgasd' 
) );
echo html_writer::empty_tag ( 'img', array (
		'src' => './pix/santiago/sotolorena.jpg',
		'alt' => 11,
		'width' => 300,
		'height' => 200 
) );
echo html_writer::tag ( 'div', 'Secretaria Deportes UAI', array (
		'class' => 'descasd' 
) );
echo html_writer::tag ( 'div', '<b>Lorena Soto</b>', array (
		'class' => 'descasd' 
) );
echo html_writer::end_tag ( 'div', array (
		'class' => 'imgasd' 
) );
echo "<p>Deportes VIÑA</p>";
echo "<br>DEPORTES VIÑA";
echo html_writer::tag ( 'h1', get_string ( 'vina', 'local_wellness' ) );

// ****VIÑA****

// **Cargo 1**
echo html_writer::start_tag ( 'div', array (
		'class' => 'imgasd' 
) );
echo html_writer::empty_tag ( 'img', array (
		'src' => './pix/vina/torrescarolina.jpg',
		'alt' => 1,
		'width' => 300,
		'height' => 200 
) );
echo html_writer::tag ( 'div', 'Sub Directora Deportes UAI', array (
		'class' => 'descasd' 
) );
echo html_writer::tag ( 'div', '<b>Carolina Torres</b>', array (
		'class' => 'descasd' 
) );
echo html_writer::end_tag ( 'div', array (
		'class' => 'imgasd' 
) );

// **Cargo 4**
echo html_writer::start_tag ( 'div', array (
		'class' => 'imgasd' 
) );
echo html_writer::empty_tag ( 'img', array (
		'src' => './pix/vina/abarcarodrigo.jpg',
		'alt' => 2,
		'width' => 300,
		'height' => 210 
) );
echo html_writer::tag ( 'div', 'Profesor Deportes UAI', array (
		'class' => 'descasd' 
) );
echo html_writer::tag ( 'div', '<b>Rodrigo Abarca</b>', array (
		'class' => 'descasd' 
) );
echo html_writer::end_tag ( 'div', array (
		'class' => 'imgasd' 
) );

// **Cargo 3**
echo html_writer::start_tag ( 'div', array (
		'class' => 'imgasd' 
) );
echo html_writer::empty_tag ( 'img', array (
		'src' => './pix/vina/blakeeric.jpg',
		'alt' => 3,
		'width' => 300,
		'height' => 200 
) );
echo html_writer::tag ( 'div', 'Profesor Deportes UAI', array (
		'class' => 'descasd' 
) );
echo html_writer::tag ( 'div', '<b>Eric Blake</b>', array (
		'class' => 'descasd' 
) );
echo html_writer::end_tag ( 'div', array (
		'class' => 'imgasd' 
) );

// **Cargo 4**
echo html_writer::start_tag ( 'div', array (
		'class' => 'imgasd' 
) );
echo html_writer::empty_tag ( 'img', array (
		'src' => './pix/vina/contrerasmarco.jpg',
		'alt' => 4,
		'width' => 300,
		'height' => 200 
) );
echo html_writer::tag ( 'div', 'Profesor Deportes UAI', array (
		'class' => 'descasd' 
) );
echo html_writer::tag ( 'div', '<b>Marco Contreras</b>', array (
		'class' => 'descasd' 
) );
echo html_writer::end_tag ( 'div', array (
		'class' => 'imgasd' 
) );

// **Cargo 5**
echo html_writer::start_tag ( 'div', array (
		'class' => 'imgasd' 
) );
echo html_writer::empty_tag ( 'img', array (
		'src' => './pix/vina/hernandezjaviera.jpg',
		'alt' => 5,
		'width' => 300,
		'height' => 200 
) );
echo html_writer::tag ( 'div', 'Profesora Deportes UAI', array (
		'class' => 'descasd' 
) );
echo html_writer::tag ( 'div', '<b>Javiera HernÃ¡ndez</b>', array (
		'class' => 'descasd' 
) );
echo html_writer::end_tag ( 'div', array (
		'class' => 'imgasd' 
) );

// **Cargo 6**
echo html_writer::start_tag ( 'div', array (
		'class' => 'imgasd' 
) );
echo html_writer::empty_tag ( 'img', array (
		'src' => './pix/vina/ortegajocelyn.jpg',
		'alt' => 6,
		'width' => 300,
		'height' => 200 
) );
echo html_writer::tag ( 'div', 'Profesora Deportes UAI', array (
		'class' => 'descasd' 
) );
echo html_writer::tag ( 'div', '<b>Jocelyn Ortega</b>', array (
		'class' => 'descasd' 
) );
echo html_writer::end_tag ( 'div', array (
		'class' => 'imgasd' 
) );

// **Cargo 7**
echo html_writer::start_tag ( 'div', array (
		'class' => 'imgasd' 
) );
echo html_writer::empty_tag ( 'img', array (
		'src' => './pix/vina/tapiarodrigo.jpg',
		'alt' => 7,
		'width' => 300,
		'height' => 200 
) );
echo html_writer::tag ( 'div', 'Profesor Deportes UAI', array (
		'class' => 'descasd' 
) );
echo html_writer::tag ( 'div', '<b>Rodrigo Tapia</b>', array (
		'class' => 'descasd' 
) );
echo html_writer::end_tag ( 'div', array (
		'class' => 'imgasd' 
) );

// **Cargo 8**
echo html_writer::start_tag ( 'div', array (
		'class' => 'imgasd' 
) );
echo html_writer::empty_tag ( 'img', array (
		'src' => './pix/vina/chevezvaleska.jpg',
		'alt' => 8,
		'width' => 300,
		'height' => 200 
) );
echo html_writer::tag ( 'div', 'Secretaria Deportes UAI', array (
		'class' => 'descasd' 
) );
echo html_writer::tag ( 'div', '<b>Valeska Chevez</b>', array (
		'class' => 'descasd' 
) );
echo html_writer::end_tag ( 'div', array (
		'class' => 'imgasd' 
) );

// Footer
echo $OUTPUT->footer ();

?>
	
	