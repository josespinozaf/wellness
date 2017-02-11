<?php
require_once (dirname ( __FILE__ ) . '/conf.php');
//Header
$nombre = $_GET['nombre'];
//if ($id > 0){
	//vamos a crear nuestra consulta SQL
	//$consulta = $DB->get_recordset_sql("SELECT imagen, tipo_imagen, nombre FROM imagenes WHERE nombre = '$nombre'");
	//$result = $DB->get_records("imagenes");
	
	$table = 'imagenes';
	$select = "nombre = $nombre"; //is put into the where clause
	$result = $DB->get_records_select($table,$select);
	echo $result;
	
	//con mysql_query la ejecutamos en nuestra base de datos indicada anteriormente
	//de lo contrario mostraremos el error que ocaciono la consulta y detendremos la ejecucion.
// 	$resultado= @mysql_query($consulta) or die(mysql_error());

	//si el resultado fue exitoso
	//obtendremos el dato que ha devuelto la base de datos
// 	$datos = mysql_fetch_assoc($resultado);

// 	//ruta va a obtener un valor parecido a "imagenes/nombre_imagen.jpg" por ejemplo
// foreach ($result as $valor){
// 	if ($valor->nombre==$nombre){
// 		$imagen = $valor->imagen;
// 	}
// }
// // 	//ahora colocamos la cabeceras correcta segun el tipo de imagen
// //}
// echo '<img src="data:image/jpeg;base64,'.base64_encode( $imagen ).'"/>';
?>