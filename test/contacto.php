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

// if(isset($_REQUEST['Submit'])){
// //Datos del mail (destinatario, asunto y mensaje del mail)
// $destinatario = "josespinozaf@gmail.com";
// $asunto = $_REQUEST['asunto'];
// $mensaje = $_REQUEST['mensaje'];
// // Enviar mail
// $ss = mail($destinatario,$asunto,$mensaje);
// //Mensaje de éxito
// if($ss){ echo "El mensaje ha sido enviado con éxito!";}
// }
// else
// { // Formulario del mail 
// ?>

 <body>
 <form name="contactform" method="post" action="mailcontacto.php">
 
<table width="450px">
 
<tr>
 
 <td valign="top">
 
  <label for="first_name">Nombre *</label>
 
 </td>
 
 <td valign="top">
 
  <input  type="text" name="first_name" maxlength="50" size="30">
 
 </td>
 
</tr>
 
<tr>
 
 <td valign="top"">
 
  <label for="last_name">Apellido *</label>
 
 </td>
 
 <td valign="top">
 
  <input  type="text" name="last_name" maxlength="50" size="30">
 
 </td>
 
</tr>
 
<tr>
 
 <td valign="top">
 
  <label for="email">E-mail *</label>
 
 </td>
 
 <td valign="top">
 
  <input  type="text" name="email" maxlength="80" size="30">
 
 </td>
 
</tr>
 
<tr>
 
 <td valign="top">
 
  <label for="telephone">Numero de telefono</label>
 
 </td>
 
 <td valign="top">
 
  <input  type="text" name="telephone" maxlength="30" size="30">
 
 </td>
 
</tr>
 
<tr>
 
 <td valign="top">
 
  <label for="comments">Comentarios/Preguntas *</label>
 
 </td>
 
 <td valign="top">
 
  <textarea  name="comments" maxlength="1000" cols="25" rows="6"></textarea>
 
 </td>
 
</tr>
 
<tr>
 
 <td colspan="2" style="text-align:center">
 
  <input type="submit" value="Submit">
 
 </td>
 
</tr>
 
</table>
 
</form>
<!--   <form method="post"> -->
<!--   <h3>¿Tienes alguna duda? Comunícate con nosotros.</h3> -->
<!--   Asunto: <input name="asunto" type="text" /><br /> -->
<!--   Mensaje:<br /> -->
<!--   <textarea name="mensaje" rows="10" cols="50"></textarea><br /> -->
<!--   <input type="submit" value="Submit" name="Submit" /> -->
<!--   </form> -->
<?php {}
 echo $OUTPUT->footer();
 ?> 
  </body>
  </html>

