<?php

namespace local_messages\output;

defined('MOODLE_INTERNAL') || die();

use renderable;
use templatable;
use renderer_base;

class main implements renderable, templatable {
    public function export_for_template(renderer_base $output): array {
        global $USER;

        $enabled = get_config('local_messages', 'enabled');
        $apikey  = (string)get_config('local_messages', 'apikey');

        return [
            'username' => fullname($USER),
            'enabled'  => !empty($enabled),
            'apikey'   => $apikey,
            'intro'    => get_string('intro', 'local_messages'),
            'hello'    => get_string('hello', 'local_messages', fullname($USER)),
            'manageonly' => has_capability('local/messages:manage', \context_system::instance())
                ? get_string('manageonly', 'local_messages') : ''
        ];
    }
    
}
