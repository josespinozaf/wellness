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
	 
	require_once('forms/add_imc_form.php');
	require_once('forms/search_imc_form.php');

			$formsearch = new search_imc_form();
			if ($datasearch= $formsearch->get_data()){
				$email=$datasearch->email;
				$result= $DB->get_records_sql("SELECT * FROM `mdl_imc` WHERE `email`=?",array($email));
			
				$table = new html_table();
				$table->head = array('Año', 'Estatura (cm)','Peso (Kg)', 'IMC');
				foreach ($result as $records) {
					
					$ano = $records->ano;
					$imc = $records->imc;
					$estatura = $records->estatura;
					$peso = $records->peso;
					$table->data[] = array($ano, $estatura, $peso, $imc);
				}
				echo html_writer::table($table);
					
			}
				
			if ($formsearch->is_cancelled()){
				$url='local/wellness/imc.php';
				redirect($url);
			}else{
				$formsearch->display();
			}
			echo html_writer::end_tag('div',array('class'=>'buscarimc'));
			}
 	echo "<img src='http://www.deporlovers.com/wp-content/uploads/2015/12/%C3%ADndice-de-masa-corporal.jpg'>";
 	?>
  </body>
</html>
<?php
echo $OUTPUT->footer();
?>