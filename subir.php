
<meta http-equiv="refresh" content="7; url=/../../moodle/local/wellness/clases.php" />
<?php
include ("connect.php");
require_login ();
$nombre= $_REQUEST['nombre'];

//comprobamos si ha ocurrido un error.
	if ( !isset($_FILES["imagen"]) || $_FILES["imagen"]["error"] > 0){
	echo "ha ocurrido un error";
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
		                	echo 'Ya existe registro si desea cambiar la foto, apriete <a href="/../../moodle/local/wellness/clases.php">AQUÍ</a>'; 
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


?>