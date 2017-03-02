<?php 
$url= "https://webapi.uai.cl/wellness/asistenciasAlumno";
$token = "KknDlkLKmmm909b998vb92368nJuijs6s544sd";
//cambiar por user->mail
$email = "cselman@alumnos.uai.cl";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
		"token=".$token."&email=".$email);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));


// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec ($ch);
if($server_output){
	//var_dump($server_output);
	$decoded = json_decode($server_output);	
}else{
	print_r(curl_error($ch));
}
?>
