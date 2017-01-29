<?php
//Configuracion de la pagina
require_once (dirname ( __FILE__ ) . '/conf.php');
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

//Header
echo $OUTPUT->header ();

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
				// **Peticion al SQL**//
				$result = $DB->get_records_sql("SELECT * FROM `imc` WHERE `email`='".$usermail."'");
			
				foreach($result as $rs){			
?>		      
	      data.addRows([
	        <?php echo "[".$rs->ano.",".$rs->imc."],";?>   
	      ]);
				<?php }?>
	      var options = {
	   		'width':700,
            'height':300,
            pointSize: 20,
            pointShape: { type: 'star', sides: 4,  dent: 0.5}	,
	        hAxis: {
	          title: '<?php echo get_string('ano','local_wellness');?>',
	          format: '####'
	        },
	        vAxis: {
	          title: '<?php echo get_string('imcs','local_wellness');?>',
	          ticks: [0, 18.5, 25, 30, 35, 40, 45]	
	        },
	        backgroundColor: '#f1f8e9'
	      };

	      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
	      chart.draw(data, options);
	    }
	</script>
  </head>
  <body>
<?php 
if(has_capability('local/wellness:seebutton', $context)){
	 
	require_once('forms/buttons_imc_form.php');
	require_once('forms/add_imc_form.php');
	require_once('forms/search_imc_form.php');
	
 	$form= new buttons_imc_form();
 	if($data=$form->get_data()){
		$submitadd=$data->submitadd;
		$submitsearch=$data->submitsearch;
		if($submitadd){
			$addform= new add_imc_form();
			if($dataadd= $addform->get_data()){
				$email=$dataadd->email;
				$ano=$dataadd->ano;
				$estatura=$dataadd->estatura;
				$peso=$dataadd->peso;
				$imc=$peso/($estatura*$estatura);
					
				$newimc = new stdClass();
				$newimc->email         = $email;
				$newimc->ano		   = $ano;
				$newimc->estatura	   = $estatura;
				$newimc->peso		   = $peso;
				$newimc->imc		   = $imc;
				$insert = $DB->insert_record("imc", $newimc, false);
				if($insert){
					echo "Se ha ingresado exitosamente.";
					}
				else{
					$url='local/wellness/clases.php';
					redirect($url);
				}
			}
			if($addform->is_cancelled()){
				$url="local/wellness/imc.php";
				redirect($url);
			}
			else{
				$addform->display();
			}
			}
		else if($submitsearch){
			$form = new search_imc_form();
			if ($datasearch= $form->get_data()){
				print_object($datasearch);
				echo "hola";
				$email=$datasearch->email;
				$result= $DB->get_records_sql("SELECT * FROM `imc` WHERE `email`=?",array($email));
				
				$table = new html_table();
				$table->head = array('Año','IMC');
				foreach ($result as $records) {
					$ano = $records->ano;
					$imc = $records->imc;
					$table->data[] = array($ano, $imc);
				}
				echo html_writer::table($table);
			
			}
			
			if ($form->is_cancelled()){
				$url='local/wellness/imc.php';
				redirect($url);
			}else{
				$form->display();
			}								
		}
		 		
 	}
	else{
		$form->set_data($toform);
		$form->display();
	}
 }else{
 	echo "<div id='chart_div'></div>";
 	}
 	echo "<img src='http://www.deporlovers.com/wp-content/uploads/2015/12/%C3%ADndice-de-masa-corporal.jpg'>";
 	?>
  </body>
</html>
<?php
echo $OUTPUT->footer();
?>