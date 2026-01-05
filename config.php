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
$CFG->dbhost    = '127.0.0.1';
$CFG->dbname    = 'u668484366_dev_new1';
$CFG->dbuser    = 'u668484366_r1';
$CFG->dbpass    = 'Rahvk@232';
$CFG->prefix    = 'giax_';
$CFG->dboptions = array (
  'dbpersist' => 0,
  'dbport' => 3306,
  'dbsocket' => '0',
  'dbcollation' => 'utf8mb4_unicode_ci',
);

$CFG->wwwroot   = 'https://dev.latingles.com';
$CFG->dataroot  = '/home/u668484366/domains/latingles.com/public_html/dev/.htdjapeuqhelwd.data/';
$CFG->admin     = 'admin';

$CFG->directorypermissions = 0777;

require_once(__DIR__ . '/lib/setup.php');

// There is no php closing tag in this file,
// it is intentional because it prevents trailing whitespace problems!
