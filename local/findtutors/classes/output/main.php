<?php

namespace local_findtutors\output;

defined('MOODLE_INTERNAL') || die();

use renderable;
use templatable;
use renderer_base;

class main implements renderable, templatable {
    public function export_for_template(renderer_base $output): array {
        global $USER;

        $enabled = get_config('local_findtutors', 'enabled');
        $apikey  = (string)get_config('local_findtutors', 'apikey');

        return [
            'username' => fullname($USER),
            'enabled'  => !empty($enabled),
            'apikey'   => $apikey,
            'intro'    => get_string('intro', 'local_findtutors'),
            'hello'    => get_string('hello', 'local_findtutors', fullname($USER)),
            'manageonly' => has_capability('local/findtutors:manage', \context_system::instance())
                ? get_string('manageonly', 'local_findtutors') : ''
        ];
    }
    
}

