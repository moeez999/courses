<?php
defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settings = new admin_settingpage('local_attendance', get_string('pluginname', 'local_attendance'));
    $ADMIN->add('localplugins', $settings);
    
    $settings->add(new admin_setting_heading(
        'local_attendance/meet_settings',
        get_string('meetsettings', 'local_attendance'),
        get_string('meetsettings_desc', 'local_attendance')
    ));
    
    $settings->add(new admin_setting_configtext(
        'local_attendance/adminimpersonate',
        get_string('adminimpersonate', 'local_attendance'),
        get_string('adminimpersonate_desc', 'local_attendance'),
        ''
    ));
    
    $settings->add(new admin_setting_configcheckbox(
        'local_attendance/enablesync',
        get_string('enablesync', 'local_attendance'),
        get_string('enablesync_desc', 'local_attendance'),
        1
    ));
    
    $settings->add(new admin_setting_configduration(
        'local_attendance/syncfrequency',
        get_string('syncfrequency', 'local_attendance'),
        get_string('syncfrequency_desc', 'local_attendance'),
        3600, // Default 1 hour
        1
    ));
}