<?php
global $USER, $CFG;
require_once (dirname ( __FILE__ ) . '/../../config.php');
require_once ($CFG->dirroot . '/my/lib.php');

redirect_if_major_upgrade_required ();

$edit = optional_param ( 'edit', null, PARAM_BOOL ); // Turn editing on and off
$reset = optional_param ( 'reset', null, PARAM_BOOL );

// **Conectando a la base de datos**
include ("connect.php");

// ** Query SQL
$userid = $USER->id;
$usermail = $USER->email;

$result = mysql_query ( "SELECT DISTINCT asistencias2.*, fitnessgram.RUT FROM asistencias2 INNER JOIN fitnessgram WHERE asistencias2.rut = fitnessgram.RUT AND fitnessgram.email = '$usermail' AND asistencias2.Periodo='S-SEM. 2012/1' ORDER BY AsisId ASC", $db );

require_login ();

// desde aqui se debe configurar la pag
$params = array ();
$PAGE->set_context ( $context );
$PAGE->set_url ( '/local/wellness/asistencias.php', $params );
$PAGE->set_pagelayout ( 'standard' );
$PAGE->set_pagetype ( 'local-wellness-asistencias' );
$PAGE->blocks->add_region ( 'content' );
$PAGE->set_subpage ( $currentpage->id );
$PAGE->set_title ( get_string ( 'titleasistencias', 'local_wellness' ) );
$PAGE->set_heading ( $header );
$PAGE->navbar->add ( get_string ( 'navasistencias', 'local_wellness' ), new moodle_url ( '/local/wellness/asistencias.php' ) );

echo $OUTPUT->header ();
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" media="screen">

<!-- Tabla Asistencias -->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
      google.load("visualization", "1.1", {packages:["table"]});
      google.setOnLoadCallback(drawTable);

      function drawTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', '<?php echo get_string('periodo','local_wellness')?>');
        data.addColumn('string', '<?php echo get_string('fecha','local_wellness')?>');
        data.addColumn('string', '<?php echo get_string('horainicio','local_wellness')?>');
        data.addColumn('string', '<?php echo get_string('horatermino','local_wellness')?>');
        data.addColumn('string', '<?php echo get_string('actividad','local_wellness')?>');
        data.addColumn('string', '<?php echo get_string('asistencia','local_wellness')?>');
        <?php while ($row = mysql_fetch_array($result)) { ?>
        data.addRows([
      ['<?php echo $row['Periodo']?>',
       '<?php echo $row['Fecha']?>',
       '<?php echo $row['HoraInicio']?>',
       '<?php echo $row['HoraTermino']?>',
       '<?php echo $row['Actividad']?>',
       '<?php echo $row['Asistencia']?>'],
       ]);
<?php }?>

        var table = new google.visualization.Table(document.getElementById('table_div'));

        table.draw(data, {showRowNumber: false, width: '100%', height: '100%'});
      }
      </script>
     
    <?php //Codigo que suma asistencias del usuario.
      			$result = mysql_query ( "SELECT DISTINCT asistencias2.*, fitnessgram.RUT FROM asistencias2 INNER JOIN fitnessgram WHERE asistencias2.rut = fitnessgram.RUT AND fitnessgram.email = '$usermail' AND asistencias2.Periodo='S-SEM. 2012/1'", $db );
				$asistenciasperiodo = 0;
				while ( $row = mysql_fetch_array ( $result ) ) {
					if ($row ['Asistencia'] == '1') {
						$asistenciasperiodo = $asistenciasperiodo + 1;
					} else if ($row ['Asistencia'] == '0,5') {
						$asistenciasperiodo = $asistenciasperiodo + 0.5;
					} else if ($row ['Asistencia'] == '-1') {
						$asistenciasperiodo = $asistenciasperiodo - 1;
					}
				}
				$ultimopar = mysql_query ( "SELECT cantasist.totalasistencias FROM cantasist ORDER BY id DESC LIMIT 1" );
				while ( $row = mysql_fetch_array ( $ultimopar ) ) {
					$asistenciasnecesarias = ( int ) $row ['totalasistencias'];
				}
				?>
		 
    <!-- Grafico Torta Asistencias "Completadas / No completadas" -->
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['<?php echo get_string('task','local_wellness')?>', '<?php echo get_string('horascompletadas','local_wellness')?>'],
          ['<?php echo get_string('completadas','local_wellness')?>', <?php echo $asistenciasperiodo ?>],
          ['<?php echo get_string('nocompletadas','local_wellness')?>', <?php echo $asistenciasnecesarias-$asistenciasperiodo ?>],
         
        ]);

        var options = {
          title:'<?php echo get_string('titulografico1','local_wellness');?>',
          is3D: true,
          slices: {
              0: { color: '#FE2E2E' },
              1: { color: '#2E2EFE' }
            }
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>

<!-- Grafico asistencias "Llevas/Deberias Llevar" -->
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
         ['Semana', 'Asistencias', 'Deberias Llevar'],
         ['01',  8,      8],
         ['02',  14,     15],
         ['03',  18,      23],
         ['04',  0,     25  ],
         ['10',  0,    30]
      ]);

    var options = {
      title :'<?php echo get_string('titulografico2','local_wellness')?>',
      vAxis: {title: '<?php echo get_string('ejey','local_wellness')?>'},
      hAxis: {title: '<?php echo get_string('ejex','local_wellness')?>'},
      seriesType: 'bars',
    
    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
    chart.draw(data, options);
  }
    </script>
</head>
<body>


</head>
<body>
	<div class="tabs">
		<div class="tab">
			<input type="radio" id="tab-1" name="tab-group-1" checked> <label
				for="tab-1"><?php echo get_string('tabasistencias','local_wellness')?></label>
			<div class="content1">
				<h3>
					<font color="white"><?php echo get_string('cantidadasistencias','local_wellness').$asistenciasperiodo;?></font>
				</h3>
				<div id="table_div"></div>
			</div>
		</div>
		<div class="tab">
			<input type="radio" id="tab-2" name="tab-group-1"> <label for="tab-2"><?php echo get_string('tabgraph1','local_wellness')?></label>
			<div class="content1">
				<div id="piechart_3d" style="width: 830px; height: 400px;"></div>
			</div>
		</div>
		<div class="tab">
			<input type="radio" id="tab-3" name="tab-group-1"> <label for="tab-3"><?php echo get_string('tabgraph2','local_wellness')?></label>
			<div class="content1">
				<div id="chart_div" style="width: 830px; height: 400px;"></div>
			</div>
		</div>
	</div>
</body>
</html>
<?php
echo $OUTPUT->footer ();
?>