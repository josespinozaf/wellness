<?php
global $USER, $CFG;
require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot . '/my/lib.php');

redirect_if_major_upgrade_required();


$edit   = optional_param('edit', null, PARAM_BOOL);    // Turn editing on and off
$reset  = optional_param('reset', null, PARAM_BOOL);

require_login();

//** Configuración de la página **//
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

echo $OUTPUT->header ();

if(isset($_REQUEST['Submit'])){
//Datos del mail (destinatario, asunto y mensaje del mail)
$destinatario = "josespinozaf@gmail.com";
$asunto = $_REQUEST['asunto'];
$mensaje = $_REQUEST['mensaje'];
// Enviar mail
$ss = mail($destinatario,$asunto,$mensaje);
//Mensaje de éxito
if($ss){ echo "El mensaje ha sido enviado con éxito!";}
}
else
{ // Formulario del mail 
?>
  <body>
  <form method="post">
  <h3>¿Tienes alguna duda? Comunícate con nosotros.</h3>
  Asunto: <input name="asunto" type="text" /><br />
  Mensaje:<br />
  <textarea name="mensaje" rows="10" cols="50"></textarea><br />
  <input type="submit" value="Submit" name="Submit" />
  </form>
<?php }
 echo $OUTPUT->footer();
 ?> 
  </body>
  </html>

