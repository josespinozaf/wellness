<meta http-equiv="refresh" content="2; url=/../../moodle/local/wellness/clases.php" />
<?php
//Config de la pagina
require_once (dirname ( __FILE__ ) . '/conf.php');
$params = array ();
$PAGE->set_context ( $context );
$PAGE->set_url ( '/local/wellness/subir.php', $params );
$PAGE->set_pagelayout ( 'mydashboard' );
$PAGE->set_pagetype ( 'local-subir-index' );
$PAGE->blocks->add_region ( 'content' );
$PAGE->set_subpage ( $currentpage->id );
$PAGE->set_title('Clases');
$PAGE->set_heading ( $header );

//Header
echo $OUTPUT->header ();

$nombre= $_REQUEST['nombre'];

//comprobamos si ha ocurrido un error.
	if ( !isset($_FILES["imagen"]) || $_FILES["imagen"]["error"] > 0){
	echo "Ha ocurrido un error";
																} 
	else {
	//ahora vamos a verificar si el tipo de archivo es un tipo de imagen permitido.
	//y que el tamano del archivo no exceda los 16MB
	$permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
	$limite_kb = 16384;

		if (in_array($_FILES['imagen']['type'], $permitidos) && $_FILES['imagen']['size'] <= $limite_kb * 1024){

		//este es el archivo temporal
		$imagen_temporal  = $_FILES['imagen']['tmp_name'];
		//este es el tipo de archivo
		$tipo = $_FILES['imagen']['type'];
		//leer el archivo temporal en binario
                $fp = fopen($imagen_temporal, 'r+b');
                $data = fread($fp, filesize($imagen_temporal));
                fclose($fp);

                //escapar los caracteres
                $data = mysql_escape_string($data);
                if (isset($_POST['subiragregar'])){
		                //Existencia de foto 
		                $fotoexistente="SELECT * FROM imagenes WHERE nombre='".$nombre."'";
		                $resultadofotoexistente=mysql_query($fotoexistente) or die (mysql_error());
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

echo $OUTPUT->footer();
?>