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
 * This file contains the restore code for the feedback_poodll plugin.
 *
 * @package   assignfeedback_poodll
 * @copyright 2013 Justin Hunt {@link http://www.poodll.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

use assignfeedback_poodll\constants;

/**
 * restore subplugin class that provides the necessary information needed to restore one assign_feedback subplugin.
 *
 * @package   assignfeedback_poodll
 * @copyright 2013 Justin Hunt {@link http://www.poodll.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class restore_assignfeedback_poodll_subplugin extends restore_subplugin {

    /**
     * Returns the paths to be handled by the subplugin at assignment level
     * @return array
     */
    protected function define_grade_subplugin_structure() {

        $paths = array();

        $elename = $this->get_namefor('grade');
        $elepath = $this->get_pathfor('/feedback_poodll'); // we used get_recommended_name() so this works
        $paths[] = new restore_path_element($elename, $elepath);

        return $paths; // And we return the interesting paths
    }

    /**
     * Processes one feedback_poodll element
     * @param mixed $data
     */
    public function process_assignfeedback_poodll_grade($data) {
        global $DB;

        $data = (object)$data;
        $data->assignment = $this->get_new_parentid('assign');
        $oldgradeid = $data->grade;
        // the mapping is set in the restore for the core assign activity. When a grade node is processed
        $data->grade = $this->get_mappingid('grade', $data->grade);

        $DB->insert_record(constants::M_TABLE, $data);

        $this->add_related_files(constants::M_COMPONENT, constants::M_FILEAREA, 'grade', null, $oldgradeid);
    }

}
