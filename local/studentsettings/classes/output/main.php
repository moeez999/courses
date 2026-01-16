<?php
namespace local_studentsettings\output;

defined('MOODLE_INTERNAL') || die();

use renderable;
use templatable;
use renderer_base;

class main implements renderable, templatable {
    public function export_for_template(renderer_base $output): array {
        global $USER;

        $enabled = get_config('local_studentsettings', 'enabled');
        $apikey  = (string)get_config('local_studentsettings', 'apikey');

        return [
            'username' => fullname($USER),
            'enabled'  => !empty($enabled),
            'apikey'   => $apikey,
            'intro'    => get_string('intro', 'local_studentsettings'),
            'hello'    => get_string('hello', 'local_studentsettings', fullname($USER)),
            'manageonly' => has_capability('local/studentsettings:manage', \context_system::instance())
                ? get_string('manageonly', 'local_studentsettings') : ''
        ];
    }
}
