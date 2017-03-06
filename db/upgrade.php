<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
/**
 * This file keeps track of upgrades to the asistencias block
 *
 * Sometimes, changes between versions involve alterations to database structures
 * and other major things that may break installations.
 *
 * The upgrade function in this file will attempt to perform all the necessary
 * actions to upgrade your older installation to the current version.
 *
 * If there's something it cannot do itself, it will tell you what you need to do.
 *
 * The commands in here will all be database-neutral, using the methods of
 * database_manager class
 *
 * Please do not forget to use upgrade_set_timeout()
 * before any action that may take longer time to finish.
 *
 * 
 * @package local
 * @subpackage wellness
 * @copyright 2016 MSC
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


function xmldb_local_wellness_upgrade($oldversion) {
 	global $DB;
    $dbman = $DB->get_manager();
	

    if ($oldversion < 20170106) {

        // Define table ejercicios to be created.
        $table = new xmldb_table('ejercicios');

        // Adding fields to table ejercicios.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('nombre', XMLDB_TYPE_TEXT, '75', null, XMLDB_NOTNULL, null, null);
        $table->add_field('link_video', XMLDB_TYPE_TEXT, '100', null, XMLDB_NOTNULL, null, null);
        $table->add_field('categoria', XMLDB_TYPE_TEXT, '50', null, XMLDB_NOTNULL, null, null);
        $table->add_field('intensidad', XMLDB_TYPE_TEXT, '50', null, XMLDB_NOTNULL, null, null);
        $table->add_field('rep1', XMLDB_TYPE_TEXT, '50', null, XMLDB_NOTNULL, null, null);
        $table->add_field('rep2', XMLDB_TYPE_TEXT, '50', null, XMLDB_NOTNULL, null, null);
        $table->add_field('rep3', XMLDB_TYPE_TEXT, '50', null, XMLDB_NOTNULL, null, null);
        $table->add_field('rep4', XMLDB_TYPE_TEXT, '50', null, XMLDB_NOTNULL, null, null);
        $table->add_field('rep5', XMLDB_TYPE_TEXT, '50', null, XMLDB_NOTNULL, null, null);
        

        // Adding keys to table ejercicios.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for ejercicios.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Define table imagenes to be created.
        $table = new xmldb_table('imagenes');
        
        // Adding fields to table imagenes.
        $table->add_field('imagen_id', XMLDB_TYPE_INTEGER, '11', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('imagen', XMLDB_TYPE_BINARY, '1', null, null, null, null);
        $table->add_field('nombre_imagen', XMLDB_TYPE_CHAR, '100', null, null, null, null);
        $table->add_field('nombre', XMLDB_TYPE_TEXT,'medium', null, XMLDB_NOTNULL, null, null);
        
        // Adding keys to table imagenes.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('imagen_id'));
        
        // Conditionally launch create table for imagenes.
        if (!$dbman->table_exists($table)) {
        	$dbman->create_table($table);
        }

        // Define table fitnessgram to be created.
//         $table = new xmldb_table('fitnessgram');
        
//         // Adding fields to table fitnessgram.
//         $table->add_field('id', XMLDB_TYPE_INTEGER, '11', null, null, XMLDB_SEQUENCE, null);
//         $table->add_field('Ano', XMLDB_TYPE_INTEGER, '4', null, null, null, null);
//         $table->add_field('Sem', XMLDB_TYPE_INTEGER,'1', null, null, null, null);
//         $table->add_field('RUT', XMLDB_TYPE_INTEGER, '8', null, null, null, null);
//         $table->add_field('DV', XMLDB_TYPE_INTEGER,'1', null, null, null, null);
//         $table->add_field('Apellido Paterno', XMLDB_TYPE_CHAR, '15', null, null, null, null);
//         $table->add_field('Apellido Materno', XMLDB_TYPE_CHAR,'15', null, null, null, null);
//         $table->add_field('Nombres', XMLDB_TYPE_VARCHAR, '25', null, null, null, null);
//         $table->add_field('Sexo', XMLDB_TYPE_CHAR,'1', null, null, null, null);
//         $table->add_field('Sede', XMLDB_TYPE_CHAR, '15', null, null, null, null);
//         $table->add_field('email', XMLDB_TYPE_CHAR,'26', null, null, null, null);
//         $table->add_field('Talla', XMLDB_TYPE_CHAR, '4', null, null, null, null);
//         $table->add_field('Peso', XMLDB_TYPE_CHAR,'	4', null, null, null, null);
//         $table->add_field('IMC', XMLDB_TYPE_CHAR, '11', null, null, null, null);
//         $table->add_field('Suma mm', XMLDB_TYPE_CHAR,'4', null, null, null, null);
//         $table->add_field('%Grasa', XMLDB_TYPE_CHAR,'5', null, null, null, null);
//         $table->add_field('Sitandreach-D', XMLDB_TYPE_CHAR,'5', null, null, null, null);
//         $table->add_field('Sitandreach-IZ', XMLDB_TYPE_CHAR,'5', null, null, null, null);
//         $table->add_field('Trunk Lift', XMLDB_TYPE_INTEGER,'3', null, null, null, null);
//         $table->add_field('Abd', XMLDB_TYPE_INTEGER,'3', null, null, null, null);
//         $table->add_field('Pull Up', XMLDB_TYPE_INTEGER,'3', null, null, null, null);
//         $table->add_field('Push Up', XMLDB_TYPE_INTEGER,'3', null, null, null, null);
//         $table->add_field('Nivel', XMLDB_TYPE_INTEGER,'5', null, null, null, null);
//         $table->add_field('Miles', XMLDB_TYPE_CHAR,'5', null, null, null, null);
//         $table->add_field('Vo2 max', XMLDB_TYPE_CHAR,'11', null, null, null, null);
         
        
       
//         // Conditionally launch create table for fitnessgram.
//         if (!$dbman->table_exists($table)) {
//         	$dbman->create_table($table);
//         }
        
        // Wellness savepoint reached.
        upgrade_plugin_savepoint(true, 20170106, 'local', 'wellness');
                
    }
    
    if ($oldversion < 20170107) {
    
    	$table = new xmldb_table('imc');
    	
    	// Adding fields to table imc.
    	$table->add_field('id', XMLDB_TYPE_INTEGER, '11', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
    	$table->add_field('email', XMLDB_TYPE_TEXT, '20', null, XMLDB_NOTNULL, null, null);
    	$table->add_field('ano', XMLDB_TYPE_TEXT, '4', null, XMLDB_NOTNULL, null, null);	 
    	$table->add_field('estatura', XMLDB_TYPE_TEXT, '3', null, XMLDB_NOTNULL, null, null);
    	$table->add_field('peso', XMLDB_TYPE_TEXT, '3', null, XMLDB_NOTNULL, null, null);
    	$table->add_field('imc', XMLDB_TYPE_TEXT, '8', null, XMLDB_NOTNULL, null, null);
    	 
    	// Adding keys to table imc.
    	$table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
    	
    	// Conditionally launch create table for imc.
    	if (!$dbman->table_exists($table)) {
    		$dbman->create_table($table);
    	}
    	// Wellness savepoint reached.
    	upgrade_plugin_savepoint(true, 20170107, 'local', 'wellness');
    	
    }
    return true;
}
?>