<?php
include ("connect.php");
//si la variable imagen no ha sido definida nos dara un advertencia.
$id = $_GET['id'];

if ($id > 0){
	//vamos a crear nuestra consulta SQL
	$consulta = "SELECT imagen, tipo_imagen FROM imagenes WHERE imagen_id = $id";
	//con mysql_query la ejecutamos en nuestra base de datos indicada anteriormente
	//de lo contrario mostraremos el error que ocaciono la consulta y detendremos la ejecucion.
	$resultado= @mysql_query($consulta) or die(mysql_error());

	//si el resultado fue exitoso
	//obtendremos el dato que ha devuelto la base de datos
	$datos = mysql_fetch_assoc($resultado);

	//ruta va a obtener un valor parecido a "imagenes/nombre_imagen.jpg" por ejemplo
	$imagen = $datos['imagen'];
	$tipo = $datos['tipo_imagen'];

	//ahora colocamos la cabeceras correcta segun el tipo de imagen
	header("Content-type: $tipo");

	echo $imagen;
}

?>