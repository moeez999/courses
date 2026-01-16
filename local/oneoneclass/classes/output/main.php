<?php
namespace local_oneoneclass\output;

defined('MOODLE_INTERNAL') || die();

use renderable;
use templatable;
use renderer_base;

class main implements renderable, templatable {
    public function export_for_template(renderer_base $output): array {
        global $USER;

        $enabled = get_config('local_oneoneclass', 'enabled');
        $apikey  = (string)get_config('local_oneoneclass', 'apikey');

        return [
            'username' => fullname($USER),
            'enabled'  => !empty($enabled),
            'apikey'   => $apikey,
            'intro'    => get_string('intro', 'local_oneoneclass'),
            'hello'    => get_string('hello', 'local_oneoneclass', fullname($USER)),
            'manageonly' => has_capability('local/oneoneclass:manage', \context_system::instance())
                ? get_string('manageonly', 'local_oneoneclass') : ''
        ];
    }
}
