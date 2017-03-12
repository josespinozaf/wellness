<?php  // Moodle configuration file

unset($CFG);
global $CFG;
$CFG = new stdClass();

$CFG->dbtype    = 'mysqli';
$CFG->dblibrary = 'native';
$CFG->dbhost    = 'localhost';
$CFG->dbname    = 'deportes_web';
$CFG->dbuser    = 'usrdeportes';
$CFG->dbpass    = '2tf7Q2GAbtGg5bPj';
$CFG->prefix    = 'mdl_';
$CFG->dboptions = array (
		'dbpersist' => 0,
		'dbport' => '',
		'dbsocket' => '',
);

$CFG->wwwroot   = 'http://deporte.uai.cl/moodle';
$CFG->dataroot  = '/home/deportes/moodledata';
$CFG->admin     = 'admin';

$CFG->directorypermissions = 02777;

require_once(dirname(__FILE__) . '/lib/setup.php');

// There is no php closing tag in this file,
// it is intentional because it prevents trailing whitespace problems!
