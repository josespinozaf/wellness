<?php
//Configuracion de la pagina
require_once (dirname ( __FILE__ ) . '/conf.php');
$params = array();
$PAGE->set_context($context);
$PAGE->set_url('/local/wellness/contacto.php', $params);
$PAGE->set_pagelayout('mydashboard');
$PAGE->set_pagetype('local-wellness-contacto');
$PAGE->blocks->add_region('content');
$PAGE->set_subpage($currentpage->id);
$PAGE->set_title(get_string('navcontacto','local_wellness'));
$PAGE->set_heading($header);
$PAGE->navbar->add(get_string('navcontacto','local_wellness'), new moodle_url('/local/wellness/contacto.php'));

//Header
echo $OUTPUT->header ();

require_once('forms/contacto_form.php');
$form= new contacto_form();
if ($form->is_cancelled()){
	die;
}
if ($data= $form->get_data()){
	$first_name = $data->first_name;
	$apellido = $data->apellido;
	$email = $data->email;
	$comments = $data->comments;
	$to='josespinozaf@gmail.com';
	$subject='Mail enviado por: '.$first_name.' '.$apellido.' con este mail:'.$email;
	
	$mail_sent = @mail( $to, $subject, $comments);
	//if the message is sent successfully print "Mail sent". Otherwise print "Mail failed" 
	echo $mail_sent ? "Mail sent" : "Mail failed";
}else{
	$form->display();
}

// Footer
echo $OUTPUT->footer();

?> 

