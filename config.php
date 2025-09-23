<?php  // Moodle configuration file

unset($CFG);
global $CFG;
$CFG = new stdClass();

// @error_reporting(E_ALL | E_STRICT);
// @ini_set('display_errors', '1');
// $CFG->debug = (E_ALL | E_STRICT);
// $CFG->debugdisplay = 1;
// $CFG->debugdeveloper = true;

$CFG->dbtype    = 'mariadb';
$CFG->dblibrary = 'native';
$CFG->dbhost    = 'localhost';
$CFG->dbname    = 'courses_one';
$CFG->dbuser    = 'root';
$CFG->dbpass    = '';
$CFG->prefix    = 'giax_';
$CFG->dboptions = array (
  'dbpersist' => 0,
  'dbport' => 3307,
  'dbsocket' => '0',
  'dbcollation' => 'utf8mb4_unicode_ci',
);

$CFG->wwwroot   = 'http://localhost/courses';
$CFG->dataroot  = 'C:\\wamp64\www\courses\.htdjapeuqhelwd.data/';
$CFG->admin     = 'admin';

$CFG->directorypermissions = 0777;

require_once(__DIR__ . '/lib/setup.php');

// There is no php closing tag in this file,
// it is intentional because it prevents trailing whitespace problems!