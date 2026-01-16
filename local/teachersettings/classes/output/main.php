<?php

namespace local_teachersettings\output;

defined('MOODLE_INTERNAL') || die();

use renderable;
use templatable;
use renderer_base;

class main implements renderable, templatable {
    public function export_for_template(renderer_base $output): array {
        global $USER;

        $enabled = get_config('local_teachersettings', 'enabled');
        $apikey  = (string)get_config('local_teachersettings', 'apikey');

        return [
            'username' => fullname($USER),
            'enabled'  => !empty($enabled),
            'apikey'   => $apikey,
            'intro'    => get_string('intro', 'local_teachersettings'),
            'hello'    => get_string('hello', 'local_teachersettings', fullname($USER)),
            'manageonly' => has_capability('local/teachersettings:manage', \context_system::instance())
                ? get_string('manageonly', 'local_teachersettings') : ''
        ];
    }
    
}
