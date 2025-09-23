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
 * Upgrade code for install
 *
 * @package    assignsubmission_cloudpoodll
 * @copyright 2012 Justin Hunt {@link http://www.poodll.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use assignsubmission_cloudpoodll\constants;

defined('MOODLE_INTERNAL') || die();

/**
 * Stub for upgrade code
 * @param int $oldversion
 * @return bool
 */
function xmldb_assignsubmission_cloudpoodll_upgrade($oldversion) {
	 global $CFG, $DB;

    $dbman = $DB->get_manager();

    //do some upgrading
    if ($oldversion < 2017052201) {

        // Cloud Poodll savepoint reached
        upgrade_plugin_savepoint(true, 2017052201, 'assignsubmission', constants::M_SUBPLUGIN);
    }

    //add filename field.
    if ($oldversion < 2021062400) {
        $table = new xmldb_table(constants::M_TABLE);
        $field = new xmldb_field('secureplayback', XMLDB_TYPE_INTEGER, '2', null, XMLDB_NOTNULL, null, 0);


        // Conditionally launch add field filename.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // online PoodLL savepoint reached
        upgrade_plugin_savepoint(true, 2021062400, 'assignsubmission', constants::M_SUBPLUGIN);

    }

    return true;
}


