<?php
global $USER, $CFG;
require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot . '/my/lib.php');
include ("connect.php");

$userid= $USER->id;
$usermail= $USER->email;

echo $OUTPUT->header();

$result = mysql_query("SELECT DISTINCT mp.* , mc.* FROM mdl_course_modules as mc
		INNER JOIN mdl_page as mp ON mc.course = mp.course AND mc.instance = mp.id 
		WHERE mp.course = 1 and mc.module = 15 
		GROUP BY mp.name", $db);

if (!$result) {
	die("Error en la peticion SQL: " . mysql_error());
}

$resultfoto = mysql_query("SELECT DISTINCT mp.* , pp.* FROM mdl_page as mp
							INNER JOIN page_pix as pp ON mp.id = pp.pageid", $db);

if (!$resultfoto) {
	die("Error en la peticion SQL: " . mysql_error());
}


$clases = array();
$fotos = array();
while ($clase =  mysql_fetch_assoc($result))
{
	$clases[] = $clase;
}
while ($foto =  mysql_fetch_assoc($resultfoto))
{
	$fotos[] = $foto;
}
foreach ($clases as $clase)
{
	foreach ($fotos as $foto)
	{
 	if 	($foto['name'] == $clase['name']){		
// 	echo $clase['id'].'<br>';
// 	echo $clase['name'].'<br>';
// 	echo $foto['pix'].'<br>';
// 	echo $clase['intro'].'<br>';

	echo "<a href='/../../moodle/mod/page/view.php?id=".$clase['id']."'><img src=".$foto['pix']." border = '0' alt=".$clase['name']." width='200' height='200'>.    .</img></a>";
	}
	}
}


	

//  foreach($result as $listacursos){ 
// 	$id= $listacursos-> id; 
//  	$nombre= $listacursos-> name; 
// 	echo $id; 
// 	echo $nombre; 
	
//  } 



// $result1 = mysql_query("SELECT DISTINCT mp.* , mc.*,pp.* FROM mdl_course_modules as mc
// 		INNER JOIN mdl_page as mp ON mc.course = mp.course AND mc.instance = mp.id 
// 		INNER JOIN page_pix as pp ON mp.name = pp.name
// 		WHERE mp.course = 1 and mc.module = 15 GROUP BY mp.name", $db);

// if (!$result1) {
// 	die("Error en la peticion SQL: " . mysql_error());
// }

// $result3 = mysql_query("SELECT DISTINCT mp.* , mc.*, pp.* FROM mdl_page as mp
// 		INNER JOIN page_pix as pp ON mp.id = pp.pageid AND mp.id = pp.id
// 		INNER JOIN mdl_course_modules as mc ON mp.course = mc.course AND mc.instance = mp.id
// 		WHERE mp.course = 1 and mc.module = 15 GROUP BY mp.name
// 		", $db);

// while ($row = mysql_fetch_array($result) && $row1 = mysql_fetch_array($resultfoto)) {
// //   	 while (){
// 	 	if ($row['instance'] == $row1['pageid'] ){
// 	echo 'Name: '.$row['name'];
// 	echo "<br>";
// 	echo 'Foto: '.$row1['pix']; 	
// 	echo "<br>";
// 	echo 'course: '.$row['module'];
// 	echo "<br>";
// 	echo 'id: '.$row['id'];
// 	echo "<br>";
// 	//echo "<a href='/../../moodle/mod/page/view.php?id=".$row['id']."'>".$row['name']."</a>";
// 	echo "<a href='/../../moodle/mod/page/view.php?id=".$row['id']."'><img src=".$row1['pix']." border = '0' alt=".$row['name']." width='200' height='200'></img></a><br>";
// 	 	}
//  }
// //   	}	

echo $OUTPUT->footer();
	?>