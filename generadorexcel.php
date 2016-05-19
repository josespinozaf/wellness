<?php 
if (isset($_POST['ExportarRut'])){
	$fitnessgram = "Fitnessgram";
	$excel=$_POST['export']; 
	$rut=$_POST['rut']; 
	$dv=$_POST['dv'];
	header('Content-Encoding: UTF-8');
	header("Content-type: application/vnd.ms-excel;charset=UTF-8");
	header("Content-disposition: attachment; filename=\"{$fitnessgram}_{$rut}-{$dv}.xls\""); 

  print $excel; 
  exit; 
}

if (isset($_POST['ExportarSede'])){
	$fitnessgram = "Fitnessgram";
	$excel=$_POST['export'];
	$sede=$_POST['sede'];
	$año=$_POST['ano'];
	$semestre=$_POST['semestre'];
	header('Content-Encoding: UTF-8');
	header("Content-type: application/vnd.ms-excel;charset=UTF-8");
	header("Content-disposition: attachment; filename=\"{$fitnessgram}_{$año}_Sem-{$semestre}_{$sede}.xls\"");
  print $excel;
  exit;
}
?>