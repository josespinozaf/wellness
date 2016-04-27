<?php
global $USER, $CFG;
require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot . '/my/lib.php');

include ("connect.php");

// ** Query SQL
$userid = $USER->id;
$usermail = $USER->email;

require_login ();

// desde aqui se debe configurar la pag
$params = array ();
$PAGE->set_context ( $context );
$PAGE->set_url ( '/local/wellness/Dbfitnessgram.php', $params );
$PAGE->set_pagelayout ( 'standard' );
$PAGE->set_pagetype ( 'local-wellness-Dbfitnessgram' );
$PAGE->blocks->add_region ( 'content' );
$PAGE->set_subpage ( $currentpage->id );
$PAGE->set_title(get_string('navfitnessgram','local_wellness'));
$PAGE->set_heading ( $header );
$PAGE->navbar->add ( get_string ( 'navfitnessgram', 'local_wellness' ), new moodle_url ( '/local/wellness/Dbfitnessgram.php' ) );


echo $OUTPUT->header();
?>
<!--SCRIPT PARA VALIDAR NUMERO -->
	<script language="javascript" type="text/javascript">

	function Solo_Numerico(variable){
		Numer=parseInt(variable);
		if (isNaN(Numer)){
			return "";
		}
		return Numer;
	}
	function ValNumero(Control){
		Control.value=Solo_Numerico(Control.value);
	}
	function aMayusculas(obj,id){
	    obj = obj.toUpperCase();
	    document.getElementById(id).value = obj;
	}
	</script>
<?php 
//** AGREGAR FITNESSGRAM  **//
if (isset($_POST['AgregarFIT'])){
	?>
	<!--INICIO FORMULARIO  -->
		<form action="Updatefitnessgram.php" method="POST">
		<h4><legend>Datos Alumno:</legend></h4>
		 *Nombres: <input type="text" name="name"  onkeyUp="return aMayusculas(this.value,this.id);"size="40"><br>
		 *RUT del alumno: <input type="text" onkeyUp="return ValNumero(this);" name="RUT" size="8" maxlength="8"> -
		 <input type="text" onkeyUp="return ValNumero(this);" name="DV" size="1" maxlength="1"><br>
		 *Apellido Paterno:<input type="text" name="ApellidoPaterno"  onkeyUp="return aMayusculas(this.value,this.id);" size="30"><br>
		 *Apellido Materno:<input type="text" name="ApellidoMaterno" onkeyUp="return aMayusculas(this.value,this.id);" size="30"><br>
		 *Sede:<select name="sede">
		 <option>Santiago</option>
		 <option>Viña</option>
		 		</select><br>
		 *Sexo:<br>
		 <input name="sexo" type="radio" checked="checked" value="M"/>M<br>
		 <input name="sexo" type="radio" value="F"/>F<br><br> 
		 *Mail UAI: <input type="text" name="mail" size="30"><br>
		 *Año:     <input type=text name="año" onkeyUp="return ValNumero(this);" maxlength="5" size="6" value="0"/><br>
		 *Semestre: <select name="semestre">
		 <option>1</option>
		 <option>2</option>
		 		</select><br>
		<h4><legend>Antropometria:</legend></h4>
		 *Altura:  <input type=text name="altura" onkeyUp="return ValNumero(this);" maxlength="3" size="4" value="0"/><br>
		 *Peso:    <input type=text name="peso" onkeyUp="return ValNumero(this);" maxlength="3" size="4" value="0"/><br>
		 *IMC:     <input type=text name="IMC" onkeyUp="return ValNumero(this);" maxlength="5" size="6" value="0"/><br>
		 *Suma mm:<input type=text name="sumamm" onkeyUp="return ValNumero(this);" maxlength="4" size="4" value="0"/><br>
		 *%Grasa:  <input type=text name="grasa" onkeyUp="return ValNumero(this);" maxlength="3" size="4" value="0"/><br>
		 <h4><legend>Fuerza:</legend></h4>
		 *Abd: 	   <input type=text name="ABD" onkeyUp="return ValNumero(this);" maxlength="3" size="3" value="0"/><br>
		 *Push Up: <input type=text name="PushUP" onkeyUp="return ValNumero(this);" maxlength="3" size="3" value="0"/> Solo si es hombre<br> 
		 *Pull Up: <input type=text name="PullUP" onkeyUp="return ValNumero(this);" maxlength="3" size="3" value="0"/> Solo si es mujer<br>
		<h4><legend>Flexibilidad:</legend></h4>
		 *Sit&Reach-D: <input type=text name="Sit&Reach-D" onkeyUp="return ValNumero(this);" maxlength="3" size="3" value="0"/><br>
		 *Sit&Reach-I: <input type=text name="Sit&Reach-I" onkeyUp="return ValNumero(this);" maxlength="3" size="3" value="0"/><br> 
		 *Trunk Lift: <input type=text name="TrunkLift" onkeyUp="return ValNumero(this);" maxlength="3" size="3" value="0"/><br>
		 <h4><legend>Resistencia:</legend></h4>
		 *Nivel:  <input type=text name="Nivel" onkeyUp="return ValNumero(this);" maxlength="3" size="3" value="0"/><br>
		 *Miles:  <input type=text name="Miles" onkeyUp="return ValNumero(this);" maxlength="3" size="3" value="0"/><br>
		 *Vo2max: <input type=text name="Vo2max" onkeyUp="return ValNumero(this);" maxlength="3" size="3" value="0"/><br> 
		 <input type="submit" name="AgregarFIT" value="Agregar!"><input type="reset" name="limpiar" value="Borrar datos del formulario" />
		  
		 </form>
		 
		 
<?php }

//** BUSCAR ALUMNO FITNESSGRAM  **//
if (isset($_POST['BuscarFIT'])){
	?>
	<!--INICIO FORMULARIO  -->
		<form action="Updatefitnessgram.php" method="POST">
		<h4><legend>Buscar Alumno:</legend></h4>
		 *RUT del alumno: <input type="text" onkeyUp="return ValNumero(this);" name="RUT" size="8" maxlength="8"> -
		 <input type="text" onkeyUp="return ValNumero(this);" name="DV" size="1" maxlength="1"><br>
		 <input type="submit" name="BuscarFIT" value="Buscar">
		 </form>
<?php }
echo $OUTPUT->footer();
?>
