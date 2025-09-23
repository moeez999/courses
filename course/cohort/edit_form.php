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
 * Cohort related management functions, this file needs to be included manually.
 *
 * @package    core_cohort
 * @copyright  2010 Petr Skoda  {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/lib/formslib.php');

class cohort_edit_form extends moodleform {

    /**
     * Define the cohort edit form
     */
    public function definition() {
        global $CFG, $DB;

        $mform = $this->_form;
        $editoroptions = $this->_customdata['editoroptions'];
        $cohort = $this->_customdata['data'];

        $mform->addElement('text', 'name', get_string('name', 'cohort'), 'maxlength="254" size="50"');
        $mform->addRule('name', get_string('required'), 'required', null, 'client');
        $mform->setType('name', PARAM_TEXT);

        $mform->addElement('text', 'shortname', get_string('shortname', 'cohort'), 'maxlength="254" size="50"');
        $mform->addRule('shortname', get_string('required'), 'required', null, 'client');
        $mform->setType('shortname', PARAM_TEXT);

        $options = $this->get_category_options($cohort->contextid);
        $mform->addElement('autocomplete', 'contextid', get_string('context', 'role'), $options);
        $mform->addRule('contextid', null, 'required', null, 'client');

        $mform->addElement('text', 'idnumber', get_string('idnumber', 'cohort'), 'maxlength="254" size="50"');
        $mform->setType('idnumber', PARAM_RAW); // Idnumbers are plain text, must not be changed.


        $checkboxes = array();
        $checkboxes[] = &$mform->createElement('advcheckbox', 'visible', get_string('visible', 'cohort'));
        $checkboxes[] = &$mform->createElement('advcheckbox', 'enabled', get_string('enabled', 'cohort'));

        $mform->addGroup($checkboxes, 'visibilitygroup', get_string('visible', 'cohort'), array(' '), false);
        $mform->addHelpButton('visibilitygroup', 'visible', 'cohort');

        $mform->setDefault('visible', 1);
        $mform->setDefault('enabled', 1);


        //custom configurations for schedules


        // teachers
        $teachers = $DB->get_records_sql("SELECT id, CONCAT(firstname, ' ', lastname) as fullname FROM {user} WHERE id IN (SELECT DISTINCT(userid) FROM {role_assignments} WHERE roleid = ?)", array(3));

        $teacher_options = array();
        foreach ($teachers as $teacher) {
            $teacher_options[$teacher->id] = $teacher->fullname;
        }

        $tutorteachers = $DB->get_records_sql("SELECT id, CONCAT(firstname, ' ', lastname) as fullname FROM {user} WHERE id IN (SELECT DISTINCT(userid) FROM {role_assignments} WHERE roleid = ?)", array(4));

        $tutorteacher_options = array();
        foreach ($tutorteachers as $tutorteacher) {
            $tutorteacher_options[$tutorteacher->id] = $tutorteacher->fullname;
        }

        $teacherarray = array();
        $teacherarray[] = $mform->createElement('select', 'cohortmainteacher', 'Main teacher', $teacher_options);
        $teacherarray[] = $mform->createElement('select', 'cohortguideteacher', 'Guide teacher', $tutorteacher_options);
        $mform->addGroup($teacherarray, 'cohortteacher', get_string('cohortteacher', 'cohort'), ' ', false);
        $mform->addHelpButton('cohortteacher', 'cohortteacher', 'cohort');
        $mform->setType('cohortteacher', PARAM_RAW);



        //days
        $days = array(
            $mform->createElement('advcheckbox', 'cohortmonday', '', 'Monday'),
            $mform->createElement('advcheckbox', 'cohorttuesday', '', 'Tuesday'),
            $mform->createElement('advcheckbox', 'cohortwednesday', '', 'Wednesday'),
            $mform->createElement('advcheckbox', 'cohortthursday', '', 'Thursday'),
            $mform->createElement('advcheckbox', 'cohortfriday', '', 'Friday'),
        );
        $mform->addGroup($days, 'cohortdaysgroup', get_string('cohortdays', 'cohort'), array(' '), false);
        $mform->addHelpButton('cohortdaysgroup', 'cohortdays', 'cohort');
        $mform->setType('cohortdaysgroup', PARAM_RAW);
        
        //time
        for ($i = 0; $i <= 23; $i++) {
            $hours[$i] =  sprintf("%02d", $i) ;
        }
        for ($i = 0; $i < 60; $i++) {
            $minutes[$i] ="   " .  sprintf("%02d", $i);
        }
        $timearray = array();
        $timearray[] = $mform->createElement('select', 'cohorthours', '', $hours);
        $timearray[] = $mform->createElement('select', 'cohortminutes', '', $minutes);
        $mform->addGroup($timearray, 'cohorttime', get_string('cohorttime', 'cohort'), ' ', false);
        $mform->addHelpButton('cohorttime', 'cohorttime', 'cohort');
        $mform->setType('cohorttime', PARAM_RAW);

        //tutor days
        $days = array(
            $mform->createElement('advcheckbox', 'cohorttutormonday', '', 'Monday'),
            $mform->createElement('advcheckbox', 'cohorttutortuesday', '', 'Tuesday'),
            $mform->createElement('advcheckbox', 'cohorttutorwednesday', '', 'Wednesday'),
            $mform->createElement('advcheckbox', 'cohorttutorthursday', '', 'Thursday'),
            $mform->createElement('advcheckbox', 'cohorttutorfriday', '', 'Friday'),
        );
        $mform->addGroup($days, 'cohorttutordaysgroup', get_string('cohorttutordays', 'cohort'), array(' '), false);
        $mform->addHelpButton('cohorttutordaysgroup', 'cohorttutordays', 'cohort');
        $mform->setType('cohorttutordaysgroup', PARAM_RAW);
        
        //tutor time
        $tutortimearray = array();
        $tutortimearray[] = $mform->createElement('select', 'cohorttutorhours', '', $hours);
        $tutortimearray[] = $mform->createElement('select', 'cohorttutorminutes', '', $minutes);
        $mform->addGroup($tutortimearray, 'cohorttutortime', get_string('cohorttutortime', 'cohort'), ' ', false);
        $mform->addHelpButton('cohorttutortime', 'cohorttutortime', 'cohort');
        $mform->setType('cohorttutortime', PARAM_RAW);

        // start date
        $mform->addElement('date_time_selector', 'startdate', get_string('cohortstartdate', 'cohort'));
        $mform->addHelpButton('startdate', 'cohortstartdate', 'cohort');
        $date = (new DateTime())->setTimestamp(usergetmidnight(time()));
        $date->modify('+1 day');
        $mform->setDefault('startdate', $date->getTimestamp());

        // end date
        $mform->addElement('date_time_selector', 'enddate', get_string('cohortenddate', 'cohort'));
        $mform->addHelpButton('enddate', 'cohortenddate', 'cohort');
        $date = (new DateTime())->setTimestamp(usergetmidnight(time()));
        $date->modify('+2 day');
        $mform->setDefault('enddate', $date->getTimestamp());


        // Cohort color field.
        $mform->addElement('text', 'cohortcolor', get_string('cohortcolor', 'cohort'), 'maxlength="20" size="10"');
        $mform->addHelpButton('cohortcolor', 'cohortcolor', 'cohort');
        $mform->setType('cohortcolor', PARAM_TEXT);


        $mform->addElement('editor', 'description_editor', get_string('description', 'cohort'), null, $editoroptions);
        $mform->setType('description_editor', PARAM_RAW);

        if (!empty($CFG->allowcohortthemes)) {
            $themes = array_merge(array('' => get_string('forceno')), cohort_get_list_of_themes());
            $mform->addElement('select', 'theme', get_string('forcetheme'), $themes);
        }

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        if (isset($this->_customdata['returnurl'])) {
            $mform->addElement('hidden', 'returnurl', $this->_customdata['returnurl']->out_as_local_url());
            $mform->setType('returnurl', PARAM_LOCALURL);
        }

        $handler = core_cohort\customfield\cohort_handler::create();
        $handler->instance_form_definition($mform, empty($cohort->id) ? 0 : $cohort->id);

        $this->add_action_buttons();

        $handler->instance_form_before_set_data($cohort);
        $this->set_data($cohort);
    }

    public function validation($data, $files) {
        global $DB;

        $errors = parent::validation($data, $files);

        $idnumber = trim($data['idnumber']);
        if ($idnumber === '') {
            // Fine, empty is ok.

        } else if ($data['id']) {
            $current = $DB->get_record('cohort', array('id'=>$data['id']), '*', MUST_EXIST);
            if ($current->idnumber !== $idnumber) {
                if ($DB->record_exists('cohort', array('idnumber'=>$idnumber))) {
                    $errors['idnumber'] = get_string('duplicateidnumber', 'cohort');
                }
            }

        } else {
            if ($DB->record_exists('cohort', array('idnumber'=>$idnumber))) {
                $errors['idnumber'] = get_string('duplicateidnumber', 'cohort');
            }
        }

        if (!empty($data['cohortcolor']) && !preg_match('/^#([a-fA-F0-9]{3}|[a-fA-F0-9]{6})$|^[a-zA-Z]+$/', $data['cohortcolor'])) {
            $errors['cohortcolor'] = get_string('invalidcolor', 'cohort');
        }

        $handler = core_cohort\customfield\cohort_handler::create();
        $errors = array_merge($errors, $handler->instance_form_validation($data, $files));

        return $errors;
    }

    protected function get_category_options($currentcontextid) {
        $displaylist = core_course_category::make_categories_list('moodle/cohort:manage');
        $options = array();
        $syscontext = context_system::instance();
        if (has_capability('moodle/cohort:manage', $syscontext)) {
            $options[$syscontext->id] = $syscontext->get_context_name();
        }
        foreach ($displaylist as $cid=>$name) {
            $context = context_coursecat::instance($cid);
            $options[$context->id] = $name;
        }
        // Always add current - this is not likely, but if the logic gets changed it might be a problem.
        if (!isset($options[$currentcontextid])) {
            $context = context::instance_by_id($currentcontextid, MUST_EXIST);
            $options[$context->id] = $syscontext->get_context_name();
        }
        return $options;
    }

    /**
     *  Apply a logic after data is set.
     */
    public function definition_after_data() {
        $cohortid = $this->_form->getElementValue('id');
        $handler = core_cohort\customfield\cohort_handler::create();
        $handler->instance_form_definition_after_data($this->_form, empty($cohortid) ? 0 : $cohortid);
    }
}

