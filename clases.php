<?php
//Config de la pagina
require_once (dirname ( __FILE__ ) . '/conf.php');
$params = array ();
$PAGE->set_context ( $context );
$PAGE->set_url ( '/local/wellness/clases.php', $params );
$PAGE->set_pagelayout ( 'mydashboard' );
$PAGE->set_pagetype ( 'local-clases-index' );
$PAGE->blocks->add_region ( 'content' );
$PAGE->set_subpage ( $currentpage->id );
$PAGE->set_title ( get_string ( 'navclases', 'local_wellness' ) );
$PAGE->set_heading ( $header );
$PAGE->navbar->add ( get_string ( 'navclases', 'local_wellness' ), new moodle_url ( '/local/wellness/clases.php' ) );

//Header
echo $OUTPUT->header ();

//Capabilities para botones
if (has_capability ( "local/wellness:seebutton", $context )) {
	//include simplehtml_form.php
	require_once('forms/buttons_form.php');
	require_once('forms/formulariofoto_form.php');
	
	//Instantiate simplehtml_form
	$mform = new buttons_form();
	
	if ($data = $mform->get_data()) {
		$submitagregar= $data->submitagregar;
		$submiteditar= $data->submiteditar;
		if(isset($submitagregar)){
			$formadd = new formulariofoto_form();
			if ($dataadd = $formadd->get_data()){
				$nombre= $dataadd->selectclases;
				$imagen= $dataadd->imagen;

				//comprobamos si ha ocurrido un error.
				if ( !isset($imagen) || $imagen["error"] > 0){
					echo "Ha ocurrido un error";
				}
				else {
					//ahora vamos a verificar si el tipo de archivo es un tipo de imagen permitido.
					//y que el tamano del archivo no exceda los 16MB
					$permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
					$limite_kb = 16384;
				
					if (in_array($imagen['type'], $permitidos) && $imagen['size'] <= $limite_kb * 1024){
				
						//este es el archivo temporal
						$imagen_temporal  = $imagen['tmp_name'];
						//este es el tipo de archivo
						$tipo = $imagen['type'];
						//leer el archivo temporal en binario
						$fp = fopen($imagen_temporal, 'r+b');
						$data = fread($fp, filesize($imagen_temporal));
						fclose($fp);
				
						//escapar los caracteres
						$data = mysql_escape_string($data);
						if (isset($_POST['subiragregar'])){
							//Existencia de foto
							$fotoexistente="SELECT * FROM imagenes WHERE nombre='".$nombre."'";
							$resultadofotoexistente=$DB->get_records_sql($fotoexistente);
							if (mysql_num_rows($resultadofotoexistente)>0)
							{
								echo 'Ya existe registro si desea cambiar la foto, apriete <a href="/../../moodle/local/wellness/clases.php">AQUI</a>';
							} else {
				
								$resultado = @mysql_query("INSERT INTO imagenes (nombre, imagen, tipo_imagen) VALUES ('$nombre','$data', '$tipo')");
				
								if ($resultado){
									echo "Felicitaciones, la foto ha sido subida exitosamente. Esta pagina se redireccionará";
								}
								else {
									echo "Oh, ocurrio un error al copiar el archivo.";
								}
							}
						}
						if (isset($_POST['subircambiar'])){
							$resultado = @mysql_query("UPDATE imagenes SET imagen= '$data', tipo_imagen='$tipo' WHERE nombre='".$nombre."'");
				
							if ($resultado){
								echo "Felicitaciones, la foto ha sido cambiada exitosamente. Esta pagina se redireccionará";
							}
							else {
								echo "Oh, ocurrio un error al copiar el archivo.";
							}
						}
					}
					else {
						echo "Cuidado, archivo no permitido, es tipo de archivo prohibido o excede el tamano de $limite_kb Kilobytes";
					}
				}
				
			}else{		
			$formadd->display();
			}
		}
		if (isset($submiteditar)){
			$formeditar= new formulariofoto_form();
			if ($dataeditar = $formeditar->get_data()){
				$nombre= $dataeditar->selectclases;
				$imagen= $dataeditar->imagen;
			
			}else{
				$formeditar->display();
			}
		}
	}
	else{
	$mform->set_data($toform);
	
	$mform->display();
	}
}
//Query para las clases
$result = $DB->get_recordset_sql("SELECT DISTINCT mc.* , pp.* FROM mdl_course as mc INNER JOIN imagenes as pp ON mc.fullname = pp.nombre");

foreach ($result as $rs){
			echo '<div class="img">';
			echo "<a href='../../course/view.php?id=".$rs->id."'>";
			echo "<img  src='../../local/wellness/imagen.php?nombre=".$rs->fullname."' alt=". $rs->fullname."></img></a>";
			echo '<div class="desc">'.$rs->fullname.'</div></div>';
		}
$result->close();
//Footer
echo $OUTPUT->footer ();
?>
	
	