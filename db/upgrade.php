<?php

function xmldb_realtimequiz_upgrade($oldversion) {
    global $CFG;

    $result = true;

    if ($oldversion < 20160104) {

        // Define table asistencias to be created.
        $table = new xmldb_table('asistencias');

        // Adding fields to table asistencias.
        $table->add_field('sede', XMLDB_TYPE_CHAR, '8', null, XMLDB_NOTNULL, null, null);
        $table->add_field('asisid', XMLDB_TYPE_INTEGER, '7', null, XMLDB_NOTNULL, null, null);
        $table->add_field('rut', XMLDB_TYPE_INTEGER, '8', null, XMLDB_NOTNULL, null, null);
        $table->add_field('dv', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, null);
        $table->add_field('nombres', XMLDB_TYPE_CHAR, '25', null, XMLDB_NOTNULL, null, null);
        $table->add_field('apellidos', XMLDB_TYPE_CHAR, '17', null, XMLDB_NOTNULL, null, null);
        $table->add_field('fecha', XMLDB_TYPE_CHAR, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('horainicio', XMLDB_TYPE_CHAR, '8', null, XMLDB_NOTNULL, null, null);
        $table->add_field('horatermino', XMLDB_TYPE_CHAR, '8', null, XMLDB_NOTNULL, null, null);
        $table->add_field('actividad', XMLDB_TYPE_CHAR, '36', null, XMLDB_NOTNULL, null, null);
        $table->add_field('periodo', XMLDB_TYPE_CHAR, '13', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table asistencias.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('rut'));

        // Conditionally launch create table for asistencias.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Wellness savepoint reached.
        upgrade_plugin_savepoint(true, 20160104, 'local', 'wellness');
    }
    

    return $result;
}
?>