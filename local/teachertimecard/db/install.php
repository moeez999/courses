<?php
/**
 * Post installation procedure for teacher timecard plugin
 */

function xmldb_local_teachertimecard_install() {
    global $DB;
    
    // Add rate columns to user table if they don't exist
    $dbman = $DB->get_manager();
    $table = new xmldb_table('user');
    
    // Add group_rate column
    $field = new xmldb_field('group_rate', XMLDB_TYPE_NUMBER, '6,2', null, XMLDB_NOTNULL, null, '0.00');
    if (!$dbman->field_exists($table, $field)) {
        $dbman->add_field($table, $field);
    }
    
    // Add single_rate column
    $field = new xmldb_field('single_rate', XMLDB_TYPE_NUMBER, '6,2', null, XMLDB_NOTNULL, null, '0.00');
    if (!$dbman->field_exists($table, $field)) {
        $dbman->add_field($table, $field);
    }
    
    return true;
}