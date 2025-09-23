<?php

/**
 * Local plugin "membership" - Settings file
 *
 * @package    membership
 * @copyright  2024 Fabian (NeiValHein), Costa Rica <neivalhein@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

global $CFG, $PAGE;

if ($hassiteconfig) {
    $ADMIN->add('root', new admin_category('local_membership', get_string('pluginname', 'local_membership')));

    $page = new admin_settingpage('local_membership_settings',
        get_string('membership_settings', 'local_membership', null, true));

    if ($ADMIN->fulltree) {
        $name = 'local_membership/noofmembershipplans';
        $title = get_string('noofmembershipplans', 'local_membership');
        $description = get_string('noofmembershipplansdesc', 'local_membership');
        $setting = new admin_setting_configselect($name, $title, $description, 3,
            array_combine(range(1, 30), range(1, 30))
        );
        $page->add($setting);

        for ($key = 1; $key <= get_config('local_membership', 'noofmembershipplans'); $key++) {

            $storedStatus = get_config('local_membership', 'planstatus' . $key);
            if ($storedStatus === 'new' || $storedStatus === false) {
                $newId = $key . '_' . time();
                set_config('planstatus' . $key, 'modified', 'local_membership');
                set_config('membershipid' . $key, $newId, 'local_membership');
            }

            $name = 'local_membership/membershipid' . $key;
            $title = get_string('membershipid', 'local_membership');
            $description = get_string('membershipiddesc', 'local_membership');
            $storedValue = get_config('local_membership', 'membershipid' . $key);
            if ($storedValue === false || $storedValue === '') {
                $defaultValue = $key . '_' . time();
                set_config('membershipid' . $key, $defaultValue, 'local_membership');
                $storedValue = $defaultValue;
            }

            $name = 'local_membership/membershipconfigzone' . $key;
            $title = 'Membership Settings for the plan';
            $planName = get_config('local_membership', 'membershipname' . $key);
            if ($planName === false || $planName === '') {
                $planName = '#' . $key;
            }
            $displayValue = $title . ': ' . $planName . ' (ID: ' . $storedValue . ')';
            $description = $title . ': ' . $storedValue;

            $setting = new admin_setting_heading($name, $displayValue, $description);
            $page->add($setting);

            $name = 'local_membership/planstatus' . $key;
            $title = get_string('planstatus', 'local_membership');
            $description = get_string('planstatusdesc', 'local_membership');
            $options = array(
                'new' => get_string('newplan', 'local_membership'),
                'modified' => get_string('modifiedplan', 'local_membership'
            ));
            $default = 'new';
            $setting = new admin_setting_configselect($name, $title, $description, $default, $options);
            $page->add($setting);

            $name = 'local_membership/membershipname'.$key;
            $title = get_string('membershipname', 'local_membership');
            $description = get_string('membershipnamedesc', 'local_membership');
            $default = get_string('membershipnameval'.$key, 'local_membership');
            $setting = new admin_setting_configtext($name, $title, $description, $default);
            $setting->set_updatedcallback('theme_reset_all_caches');
            $page->add($setting);

            $name = 'local_membership/membershipmonthlyfee'.$key;
            $title = get_string('membershipmonthlyfee', 'local_membership');
            $description = get_string('membershipmonthlyfeedesc', 'local_membership');
            $setting = new admin_setting_configtext($name, $title, $description, 0);
            $setting->set_updatedcallback('theme_reset_all_caches');
            $page->add($setting);

            $name = 'local_membership/membershipmonthlyintervalvalue'.$key;
            $title = get_string('membershipmonthlyintervalvalue', 'local_membership');
            $description = get_string('membershipmonthlyintervalvaluedesc', 'local_membership');
            $setting = new admin_setting_configselect($name, $title, $description, 1,
                array_combine(range(1, 12), range(1, 12))
            );
            $setting->set_updatedcallback('theme_reset_all_caches');
            $page->add($setting);

            $name = 'local_membership/noofmembershipmonthlybillingcycles'.$key;
            $title = get_string('noofmembershipmonthlybillingcycles', 'local_membership');
            $description = get_string('noofmembershipmonthlybillingcyclesdesc', 'local_membership');
            $setting = new admin_setting_configselect($name, $title, $description, 0,
                array(0 => get_string('neverexpires', 'local_membership')) + array_combine(range(1, 25), range(1, 25))
            );
            $page->add($setting);

            $name = 'local_membership/membershipbiannuallyfee'.$key;
            $title = get_string('membershipbiannualfee', 'local_membership');
            $description = get_string('membershipbiannualfeedesc', 'local_membership');
            $setting = new admin_setting_configtext($name, $title, $description, 0);
            $setting->set_updatedcallback('theme_reset_all_caches');
            $page->add($setting);

            $name = 'local_membership/membershipbiannuallyintervalvalue'.$key;
            $title = get_string('membershipbiannualintervalvalue', 'local_membership');
            $description = get_string('membershipbiannualintervalvaluedesc', 'local_membership');
            $setting = new admin_setting_configselect($name, $title, $description, 6,
                array_combine(range(6, 72, 6), range(1, 12))
            );
            $setting->set_updatedcallback('theme_reset_all_caches');
            $page->add($setting);

            $name = 'local_membership/noofmembershipbiannuallybillingcycles'.$key;
            $title = get_string('noofmembershipbiannualbillingcycles', 'local_membership');
            $description = get_string('noofmembershipbiannualbillingcyclesdesc', 'local_membership');
            $setting = new admin_setting_configselect($name, $title, $description, 0,
                array(0 => get_string('neverexpires', 'local_membership')) + array_combine(range(1, 25), range(1, 25))
            );
            $page->add($setting);

            $name = 'local_membership/membershipyearlyfee'.$key;
            $title = get_string('membershipyearlyfee', 'local_membership');
            $description = get_string('membershipyearlyfeedesc', 'local_membership');
            $setting = new admin_setting_configtext($name, $title, $description, 0);
            $setting->set_updatedcallback('theme_reset_all_caches');
            $page->add($setting);

            $name = 'local_membership/membershipyearlyintervalvalue'.$key;
            $title = get_string('membershipyearlyintervalvalue', 'local_membership');
            $description = get_string('membershipyearlyintervalvaluedesc', 'local_membership');
            $setting = new admin_setting_configselect($name, $title, $description, 12,
                array_combine(range(12, 144, 12), range(1, 12))
            );
            $setting->set_updatedcallback('theme_reset_all_caches');
            $page->add($setting);

            $name = 'local_membership/noofmembershipyearlybillingcycles'.$key;
            $title = get_string('noofmembershipyearlybillingcycles', 'local_membership');
            $description = get_string('noofmembershipyearlybillingcyclesdesc', 'local_membership');
            $setting = new admin_setting_configselect($name, $title, $description, 0,
                array(0 => get_string('neverexpires', 'local_membership')) + array_combine(range(1, 50), range(1, 50))
            );
            $page->add($setting);





            $cohortoption[0] = 'No cohort(s) selected';
            $cohorts = $DB->get_records_sql("SELECT * FROM {cohort} WHERE visible = 1 AND id != 1");
            foreach ($cohorts as $cohortskey => $cohortsvalue) {
                $cohortoption[$cohortskey] = $cohortsvalue->name;
            }
            for ($prekey = $key-1; $prekey > 0; $prekey--) {
                $membershipcohorts = explode(',', get_config('local_membership', 'membershipcohorts'.$prekey));
                if (!empty($membershipcohorts)) {
                    foreach ($membershipcohorts as $mcoursekey => $mcourseid) {
                        foreach ($cohortoption as $cohortskey => $cohortsvalue) {
                            if ($mcourseid == $cohortskey) {
                                unset($cohortoption[$cohortskey]);
                            }
                        }
                    }
                }
            }
            $cohortoption[0] = 'No cohort(s) selected';
            $name = 'local_membership/membershipcohorts'.$key;
            $title = get_string('membershipcohorts', 'local_membership');
            $description = get_string('membershipcohortsdesc', 'local_membership');
            $setting = new admin_setting_configmultiselect($name, $title, $description, [0], $cohortoption);
            $setting->set_updatedcallback('theme_reset_all_caches');
            $page->add($setting);

            $name = 'local_membership/membershipplandescription'.$key;
            $title = get_string('membershipplandescription', 'local_membership');
            $description = get_string('membershipplandescriptiondesc', 'local_membership');
            $setting = new admin_setting_configtextarea($name, $title, $description, '');
            $setting->set_updatedcallback('theme_reset_all_caches');
            $page->add($setting);



            $name = 'local_membership/noofmembershipfeatures'.$key;
            $title = get_string('noofmembershipfeatures', 'local_membership');
            $description = get_string('noofmembershipfeaturesdesc', 'local_membership');
            $setting = new admin_setting_configselect($name, $title, $description, 0,
                array_combine(range(0, 6), range(0, 6))
            );
            $page->add($setting);

            for ($fkey = 1; $fkey <= get_config('local_membership', 'noofmembershipfeatures'.$key); $fkey++) {
                $name = 'local_membership/membershipfeaturestext'.$key.$fkey;
                $title = get_string('membershipfeaturestext', 'local_membership');
                $description = get_string('membershipfeaturestextdesc', 'local_membership');
                $setting = new admin_setting_configtext($name, $title, $description, 'Empty');
                $setting->set_updatedcallback('theme_reset_all_caches');
                $page->add($setting);
            }

            $name = 'local_membership/noofmembershippromotioncodes'.$key;
            $title = get_string('noofmembershippromotioncodes', 'local_membership');
            $description = get_string('noofmembershippromotioncodesdesc', 'local_membership');
            $setting = new admin_setting_configselect($name, $title, $description, 0,
                array_combine(range(0, 6), range(0, 6))
            );
            $page->add($setting);

            for ($fkey = 1; $fkey <= get_config('local_membership', 'noofmembershippromotioncodes'.$key); $fkey++) {
                $name = 'local_membership/membershippromotioncodestext'.$key.$fkey;
                $title = get_string('membershippromotioncodestext'.$fkey, 'local_membership');
                $description = get_string('membershippromotioncodestextdesc'.$fkey, 'local_membership');
                $setting = new admin_setting_configtext($name, $title, $description, 'Empty');
                $setting->set_updatedcallback('theme_reset_all_caches');
                $page->add($setting);

                $name = 'local_membership/membershippromotioncodesdiscount'.$key.$fkey;
                $title = get_string('membershippromotioncodesdiscount'.$fkey, 'local_membership');
                $description = get_string('membershippromotioncodesdiscountdesc'.$fkey, 'local_membership');
                $setting = new admin_setting_configtext($name, $title, $description, 'Empty');
                $setting->set_updatedcallback('theme_reset_all_caches');
                $page->add($setting);
            }
        }

    }

    $ADMIN->add('local_membership', $page);

    $page = new admin_settingpage('local_membership_payment_settings',
        get_string('payment_settings', 'local_membership', null, true));

    if ($ADMIN->fulltree) {

        $options = array(1  => get_string('enable'),
           0 => get_string('disable'));
        $page->add(new admin_setting_configselect('local_membership/paypalsandboxstatus',
            get_string('paypalsandboxstatus', 'local_membership'), get_string('paypalsandboxstatus_desc', 'local_membership'), 0, $options));

        $name = 'local_membership/paymentcurrency';
        $title = get_string('paymentcurrency', 'local_membership');
        $setting = new admin_setting_configselect($name, $title, '', 'USD',
            $paypalcurrencies = enrol_get_plugin('paypal')->get_currencies());
        $page->add($setting);

        $page->add(new admin_setting_configtext('local_membership/paypalsubscriptionbusiness', get_string('paypalbusinessemail', 'local_membership'), get_string('paypalbusinessemail_desc', 'local_membership'), '', PARAM_EMAIL));

        $page->add(new admin_setting_configtext('local_membership/paypalsubscriptionclientid', get_string('paypalclientid', 'local_membership'), get_string('paypalclientid_desc', 'local_membership'), '', PARAM_RAW));

        $page->add(new admin_setting_configtext('local_membership/paypalsubscriptionsecret', get_string('paypalsecret', 'local_membership'), get_string('paypalsecret_desc', 'local_membership'), '', PARAM_RAW));

    }

    $ADMIN->add('local_membership', $page);

    $page = new admin_settingpage('local_membership_emailssettings',
        get_string('emailssettings', 'local_membership', null, true));
    if ($ADMIN->fulltree) {

        $page->add(new admin_setting_heading('local_membership/emailsettingsheading', ' ', ''));

        $name = 'local_membership/mailadmins';
        $title = get_string('mailadmins', 'local_membership');
        $setting = new admin_setting_configcheckbox($name, $title, '', 1);
        $page->add($setting);

        $name = 'local_membership/mailstudents';
        $title = get_string('mailstudents', 'local_membership');
        $setting = new admin_setting_configcheckbox($name, $title, '', 1);
        $page->add($setting);

        $name = 'local_membership/courseenrolmentmailsubject';
        $title = get_string('courseenrolmentmailsubject', 'local_membership');
        $default = get_string('courseenrolmentmailsubjectval', 'local_membership');
        $setting = new admin_setting_configtext($name, $title, '', $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $name = 'local_membership/courseenrolmentmailbody';
        $title = get_string('courseenrolmentmailbody', 'local_membership');
        $default = get_string('courseenrolmentmailbodyval', 'local_membership');
        $setting = new admin_setting_configtextarea($name, $title, '', $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $name = 'local_membership/courseenrolmentmailsubjectfree';
        $title = get_string('courseenrolmentmailsubjectfree', 'local_membership');
        $default = get_string('courseenrolmentmailsubjectvalfree', 'local_membership');
        $setting = new admin_setting_configtext($name, $title, '', $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $name = 'local_membership/courseenrolmentmailbodyfree';
        $title = get_string('courseenrolmentmailbodyfree', 'local_membership');
        $default = get_string('courseenrolmentmailbodyvalfree', 'local_membership');
        $setting = new admin_setting_configtextarea($name, $title, '', $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

    }

    $ADMIN->add('local_membership', $page);
}
