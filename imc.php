<?php
global $USER, $CFG;
require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot . '/my/lib.php');

redirect_if_major_upgrade_required();


$edit   = optional_param('edit', null, PARAM_BOOL);    // Turn editing on and off
$reset  = optional_param('reset', null, PARAM_BOOL);

require_login();

$context = context_system::instance();

//** Configuración de la página **//
$params = array();
$PAGE->set_context($context);
$PAGE->set_url('/local/wellness/imc.php', $params);
$PAGE->set_pagelayout('mydashboard');
$PAGE->set_pagetype('local-wellness-imc');
$PAGE->blocks->add_region('content');
$PAGE->set_subpage($currentpage->id);
$PAGE->set_title(get_string('imcs','local_wellness'));
$PAGE->set_heading($header);
$PAGE->navbar->add(get_string('imcs','local_wellness'), new moodle_url('/local/wellness/imc.php'));

echo $OUTPUT->header ();
include ("connect.php");

?>
<html>
  <head>
   
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">
	google.charts.load('current', {packages: ['corechart', 'line']});
	google.charts.setOnLoadCallback(drawBackgroundColor);

	function drawBackgroundColor() {
	      var data = new google.visualization.DataTable();
	      data.addColumn('number', 'X');
	      data.addColumn('number', '<?php echo get_string('imcs','local_wellness');?>');
			<?php 
				//** DATOS DEL USUARIO QUE ENTREGA MOODLE**//
				$userid= $USER->id;
				$usermail= $USER->email;
				
				// **Peticion al SQL**//
				$result = mysql_query("SELECT * FROM `imc` WHERE `email`='".$usermail."'", $db);
				if (!$result) {
					die("Error en la peticion SQL: " . mysql_error());
				}
				while($datos=mysql_fetch_array($result)){			
?>		
	      data.addRows([
	        <?php echo "[".$datos['ano'].",".$datos['imc' ]."],";?>   
	      ]);
				<?php }?>
	      var options = {
	        hAxis: {
	          title: '<?php echo get_string('ano','local_wellness');?>'
	        },
	        vAxis: {
	          title: '<?php echo get_string('imcs','local_wellness');?>'
	        },
	        backgroundColor: '#f1f8e9'
	      };

	      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
	      chart.draw(data, options);
	    }
	</script>
  </head>
  <body>
 	<h2><?php echo get_string('imcs','local_wellness')?></h2>
<?php if(has_capability('local/wellness:seebutton', $context)){
		if(isset($_POST['AgregarIMC'])){?>
			<form action="#" method="POST">
			Email:<input type="text" name="email"/><br>
			Año:<input type="text" name="ano"/><br>
			Estatura en metros (1.11):<input type="text" name="estatura" /><br>
			Peso en kg:<input type="text" name="peso" /><br>
			<input type="submit" name="AgregarIMC2" value="Agregar"/>
			</form>
		<?php 		
		}else if(isset($_POST['BuscarIMC'])){?>
			<form action="#" method="POST">
				Email:<input type="text" name="email"/><br>
				<input type="submit" name="BuscarIMC2" value="Buscar"/>
				</form>
		<?php 
		}
		else if(isset($_POST['AgregarIMC2'])){
			$email=$_REQUEST['email'];
			$ano=$_REQUEST['ano'];
			$estatura=$_REQUEST['estatura'];
			$peso=$_REQUEST['peso'];
			$imc=$peso/($estatura*$estatura);
			if($email && $ano && $estatura && $peso && $imc	){
				$result=mysql_query("INSERT INTO `imc`(`email`, `ano`, `estatura`, `peso`, `imc`) 
						VALUES ('".$email."','".$ano."','".$estatura."','".$peso."','".$imc."')", $db);
				if($result) echo "Se ingreso con éxito.<a href='imc.php'>Volver</a>";
				else echo "Hubo un error.";
			}else echo "Rellene todos los campos.";
		}
		else if(isset($_POST['BuscarIMC2'])){
			$email=$_REQUEST['email'];
			if($email){
				$result=mysql_query("SELECT * FROM `imc` WHERE `email`='".$email."'", $db);
				if ($result){
					echo"<table style='border: 1px solid #000; width: 250px;'>
									  <tr>
										<th>Año</th>
									    <th>IMC</th>
									  </tr>";
					while($datos=mysql_fetch_array($result)){
							echo"<tr><td>".$datos['ano']."</td>";
							echo"<td>".$datos['imc']."</td></tr>";							
														}	
				} 
				echo "<a href='imc.php'>Volver</a>";
			}
		}
		else{?>
			<form action="#" method="POST">
			<input type="submit" name="AgregarIMC" value="Agregar IMC alumno"/>
			<input type="submit" name="BuscarIMC" value="Buscar IMC alumno"/>
			</form>
			<?php }
		}else{?>
 	<div id="chart_div"></div>
 	<?php }?>
  </body>
</html>

				
