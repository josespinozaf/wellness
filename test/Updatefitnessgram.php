<meta http-equiv="refresh" content="10; url=/../../moodle/local/wellness/fitnessgram.php" />
<link rel="stylesheet" type="text/css" href="style.css" media="screen">

<?php
include ("connect.php");
if (isset($_POST['AgregarFIT'])){
	$Nombres = $_REQUEST['name'];
	$Rut = $_REQUEST['RUT'];
	$DV = $_REQUEST['DV'];
	$AP= $_REQUEST['ApellidoPaterno'];
	$AM = $_REQUEST['ApellidoMaterno'];
	$sede = $_REQUEST['sede'];
	$sexo = $_REQUEST['sexo'];
	$mail = $_REQUEST['mail'];
	$Año = $_REQUEST['año'];
	$Semestre = $_REQUEST['semestre'];
	$Altura = $_REQUEST['altura'];
	$Peso = $_REQUEST['peso'];
	$IMC = $_REQUEST['IMC'];
	$Sumamm = $_REQUEST['sumamm'];
	$grasa = $_REQUEST['grasa'];
	$SitD = $_REQUEST['Sit&Reach-D'];
	$SitIZ = $_REQUEST['Sit&Reach-I'];
	$TrunkLift = $_REQUEST['TrunkLift'];
	$Adb = $_REQUEST['ABD'];
	$PullUp = $_REQUEST['PullUP'];
	$PushUp = $_REQUEST['PushUP'];
	$Nivel = $_REQUEST['Nivel'];
	$Miles = $_REQUEST['Miles'];
	$Vo2Max = $_REQUEST['Vo2max'];
	$queryadd="INSERT INTO `fitnessgram`(`Ano`, `Sem`, `RUT`, `DV`, `Apellido Paterno`, `Apellido Materno`, `Nombres`, `Sexo`, `Sede`,
			`email`, `Talla`, `Peso`, `IMC`, `Suma mm`, `%Grasa`, `Sitandreach-D`, `Sitandreach-IZ`, `Trunk Lift`, `Abd`, `Pull Up`, `Push Up`,
			 `Nivel`, `Miles`, `Vo2 max`) 
			VALUES (".$Año.",".$Semestre.",".$Rut.",".$DV.",'".$AP."','".$AM."','".$Nombres."','".$sexo."','".$sede."','".$mail."',
			".$Altura.",".$Peso.",".$IMC.",".$Sumamm.",".$grasa.",".$SitD.",".$SitIZ.",".$TrunkLift.",".$Adb.",".$PullUp.",
			".$PushUp.",".$Nivel.",".$Miles.",".$Vo2Max.")";
	$resultqueryadd=mysql_query($queryadd) or die (mysql_error());
	if ($resultqueryadd){
		echo "<center><h1>Se ha ingresado con exito</h1>";
		echo"Desea ingresar otro?<br>";
		echo"<form action='/../../moodle/local/wellness/Dbfitnessgram.php' method='POST'>
		<input type='button' name='AgregarFIT' value='Agregar Fitnessgram'></center></form>";
		echo"<a href='/../../moodle/local/wellness/fitnessgram.php'>Volver</a>";
	}
	
	
}
if (isset($_POST['BuscarFIT'])){?>
<?php 
	$Rut = $_REQUEST['RUT'];
	$DV = $_REQUEST['DV'];
	$queryrut="SELECT * FROM fitnessgram WHERE RUT='".$Rut."' AND DV='".$DV."'";
	$resultqueryrut=mysql_query($queryrut) or die (mysql_error());
	if($resultqueryrut){
		?>
		<div id="cuadrofit">
		<center><br>
		<div id="titulofit">
		<center><h1><?php echo 'Registros de:'.$Rut.'-'.$DV; ?></h1></center>
		</div>
		<table>
		<thead>
		<tr class="centrofit">
		<td>Año</td>
		<td>Semestre</td>
		<td>Altura</td>
		<td>Peso</td>
		<td>IMC</td>
		<td>Suma mm</td>
		<td>%grasa</td>
		<td>Sit&reach-D</td>
		<td>Sit&reach-IZ</td>
		<td>Trunk Lift</td>
		<td>Adb</td>
		<td>Pull Up</td>
		<td>Push Up</td>
		<td>Nivel</td>
		<td>Miles</td>
		<td>Vo2 Max</td>
		</tr>
		<tbody><?php 
		$excel="";
		$excel.="Año\tSemestre\tAltura\tPeso\tIMC\tSumamm\t%Grasa\tSit&reach-D\tSit&reach-IZ\tTrunkLift\tAdb\tPullUp\tPushUP\tNivel\tMiles\tVo2Max\n";
		while($datos= mysql_fetch_array($resultqueryrut)) {
			?><tr>
							<td><?php echo $datos['Ano'];?></td>
							<td><?php echo $datos['Sem'];?>	</td>
							<td><?php echo $datos['Talla'];?></td>
							<td><?php echo $datos['Peso'];?></td>
							<td><?php echo $datos['IMC'];?></td>
							<td><?php echo $datos['Suma mm'];?>	</td>
							<td><?php echo $datos['%Grasa'];?></td>
							<td><?php echo $datos['Sit&reach-D'];?></td>
							<td><?php echo $datos['Sit&reach-IZ'];?></td>
							<td><?php echo $datos['Trunk Lift'];?></td>
							<td><?php echo $datos['Abd'];?>	</td>
							<td><?php echo $datos['Pull Up'];?></td>
							<td><?php echo $datos['Push Up'];?></td>
							<td><?php echo $datos['Nivel'];?></td>
							<td><?php echo $datos['Miles'];?></td>
							<td><?php echo $datos['Vo2 max'];?></td>
							
						</tr>
						
	<?php 		$excel.=$datos['Ano']."\t".$datos['Sem']."\t".$datos['Talla']."\t";
				$excel.=$datos['Peso']."\t".$datos['IMC']."\t".$datos['Suma mm']."\t";
				$excel.=$datos['%Grasa']."\t".$datos['Sit&reach-D']."\t".$datos['Sit&reach-IZ']."\t";
				$excel.=$datos['Trunk Lift']."\t".$datos['Abd']."\t".$datos['Pull Up']."\t".$datos['Push Up']."\t";
				$excel.=$datos['Nivel']."\t".$datos['Miles']."\t".$datos['Vo2 max']."\n";
				}
	
	
	echo'</tbody>
			</table>	
			</center>';
	echo "<br><form action=generadorexcel.php method = POST>
	<input type='hidden' name='export' value='$excel'/>
	<input type='hidden' name='rut' value='$Rut'/>
	<input type='hidden' name='dv' value='$DV'/>
	Descargar en excel <input type = submit name= 'ExportarRut' value = 'Exportar'></form>";
	echo"<a href='/../../moodle/local/wellness/fitnessgram.php'>Volver</a>";
	}
	
	
}
if (isset($_POST['BuscarAño'])){
	$año = $_REQUEST['año'];
	$sede = $_REQUEST['sede'];
	$semestre = $_REQUEST['semestre'];
	$queryrut="SELECT * FROM fitnessgram WHERE Ano='".$año."' AND Sede='".$sede."' AND Sem='".$semestre."'";
	$resultqueryrut=mysql_query($queryrut) or die (mysql_error());
	if($resultqueryrut){
		?>
			<div id="cuadrofit">
			<center><br>
			<div id="titulofit">
			<center><h1><?php echo 'Registros del Año '.$año.' de la sede '.$sede; ?></h1></center>
			</div>
			<table>
			<thead>
			<tr class="centrofit">
			<td>Nombres</td>
			<td>Apellido Paterno</td>
			<td>Apellido Materno</td>
			<td>Semestre</td>
			<td>Altura</td>
			<td>Peso</td>
			<td>IMC</td>
			<td>Suma mm</td>
			<td>%grasa</td>
			<td>Sit&reach-D</td>
			<td>Sit&reach-IZ</td>
			<td>Trunk Lift</td>
			<td>Adb</td>
			<td>Pull Up</td>
			<td>Push Up</td>
			<td>Nivel</td>
			<td>Miles</td>
			<td>Vo2 Max</td>
			</tr>
			<tbody><?php 
			$excel="";
			$excel.="Nombres\tApellido Paterno\tApellido Materno\tSemestre\tAltura\tPeso\tIMC\tSumamm\t%Grasa\tSit&reach-D\tSit&reach-IZ\tTrunkLift\tAdb\tPullUp\tPushUP\tNivel\tMiles\tVo2Max\n";
			while($datos= mysql_fetch_array($resultqueryrut)) {
				?><tr>
								
								<td><?php echo $datos['Nombres'];?></td>
								<td><?php echo $datos['Apellido Paterno'];?></td>	
								<td><?php echo $datos['Apellido Materno'];?></td>			
								<td><?php echo $datos['Sem'];?>	</td>
								<td><?php echo $datos['Talla'];?></td>
								<td><?php echo $datos['Peso'];?></td>
								<td><?php echo $datos['IMC'];?></td>
								<td><?php echo $datos['Suma mm'];?>	</td>
								<td><?php echo $datos['%Grasa'];?></td>
								<td><?php echo $datos['Sit&reach-D'];?></td>
								<td><?php echo $datos['Sit&reach-IZ'];?></td>
								<td><?php echo $datos['Trunk Lift'];?></td>
								<td><?php echo $datos['Abd'];?>	</td>
								<td><?php echo $datos['Pull Up'];?></td>
								<td><?php echo $datos['Push Up'];?></td>
								<td><?php echo $datos['Nivel'];?></td>
								<td><?php echo $datos['Miles'];?></td>
								<td><?php echo $datos['Vo2 max'];?></td>
								
							</tr>
							
		<?php 	
				$excel.=$datos['Nombres']."\t".$datos['Apellido Paterno']."\t".$datos['Apellido Materno']."\t".$datos['Sem']."\t".$datos['Talla']."\t";
				$excel.=$datos['Peso']."\t".$datos['IMC']."\t".$datos['Suma mm']."\t";
				$excel.=$datos['%Grasa']."\t".$datos['Sit&reach-D']."\t".$datos['Sit&reach-IZ']."\t";
				$excel.=$datos['Trunk Lift']."\t".$datos['Abd']."\t".$datos['Pull Up']."\t".$datos['Push Up']."\t";
				$excel.=$datos['Nivel']."\t".$datos['Miles']."\t".$datos['Vo2 max']."\n";
			}
		echo'</tbody>
				</table>	
				</center>';
		echo "<br><form action=generadorexcel.php method = POST>
		<input type='hidden' name='export' value='$excel'/>
		<input type='hidden' name='sede' value='$sede'/>
		<input type='hidden' name='ano' value='$año'/>
		<input type='hidden' name='semestre' value='$semestre'/>
		Descargar en excel <input type ='submit' name= 'ExportarSede' value = 'Exportar'></form>";
		echo"<a href='/../../moodle/local/wellness/fitnessgram.php' >Volver</a>";}
		
	}
?>			