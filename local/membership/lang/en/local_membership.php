<?php

/**
 * Local plugin "membership" - Strings file
 *
 * @package    membership
 * @copyright  2024 Fabian (NeiValHein), Costa Rica <neivalhein@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Memberships';

$string['check_subscriptions_status'] = 'Check Subscriptions Status';
$string['check_cron_cohorts'] = 'Check Cron Cohorts';
$string['fetch_paypal_subscriptions'] = 'Fetch PayPal Subscriptions';

$string['apacherewrite'] = 'Force Apache mod_rewrite';
$string['apacherewrite_desc'] = 'Serve static pages only with a clean URL, rewritten by Apache mod_rewrite. See README file for details.';
$string['cleanhtml'] = 'Clean HTML code';
$string['cleanhtml_desc'] = 'Configure if the static page\'s HTML code should be cleaned (and thereby special tags like &lt;iframe&gt; being removed). See README for details.';
$string['cleanhtmlyes'] = 'Yes, clean HTML code';
$string['cleanhtmlno'] = 'No, don\'t clean HTML code';
$string['documents'] = 'Documents';
$string['documents_desc'] = 'The .html files with the static pages\' HTML code. See README file for details.';
$string['documentheadingsource'] = 'Data source of document heading';
$string['documentheadingsource_desc'] = 'The data source of the static page\'s document heading';
$string['expiryperiod'] = 'Expiry duration';
$string['expiryperiod_desc'] = 'Expiry duration is the addition time period that users can get even after their membership was over.';
$string['documentnavbarsource'] = 'Data source of breadcrumb item title';
$string['documentnavbarsource_desc'] = 'The data source of the static page\'s breadcrumb item title (used in the Moodle "Navbar")';
$string['documenttitlesource'] = 'Data source of document title';
$string['documenttitlesource_desc'] = 'The data source of the static page\'s document title (used in the browser titlebar)';
$string['documenttitlesourceh1'] = 'First h1 tag in HTML code (usually located shortly after opening the body tag)';
$string['documenttitlesourcehead'] = 'First title tag in HTML code (usually located within the head tag)';
$string['forcelogin'] = 'Force login';
$string['forcelogin_desc'] = 'Serve static pages only to logged in users or also to non-logged in visitors. This behaviour can be set specifically for static pages or can be set to respect Moodle\'s global forcelogin setting. See README for details.';
$string['forceloginglobal'] = 'Respect the global setting $CFG->forcelogin';
$string['pagenotfound'] = 'Page not found';
$string['privacy:metadata'] = 'The static pages plugin provides extended functionality to Moodle admins, but does not store any personal data.';
$string['processcontent'] = 'Process content';
$string['processfilters'] = 'Process filters';
$string['processfilters_desc'] = 'Configure if Moodle filters (especially the multilanguage filter) should be processed when serving the static page\'s content. See README for details.';
$string['processfiltersyes'] = 'Yes, process filters';
$string['processfiltersno'] = 'No, don\'t process filters';
$string['settingspagelist'] = 'List of static pages';
$string['settingspagelistnofiles'] = 'There are no .html files in the <a href="{$a}">static pages document area</a>, therefore there are no static pages to be delivered. See README file for details.';
$string['settingspagelistinstruction'] = 'This list shows all static pages which have been uploaded into the <a href="{$a}">static pages document area</a> and their URLs';
$string['settingspagelistentryfilename'] = 'The following document file was found:<br /><strong>{$a}</strong>';
$string['settingspagelistentrypagename'] = 'From the document file\'s filename, Moodle derived the following pagename:<br /><strong>{$a}</strong>';
$string['settingspagelistentrystandarddisabled'] = 'The static page should be available at the following standard URL, but is not checked because checking availability is disabled:<br /><strong>{$a}</strong>';
$string['settingspagelistentrystandarderror'] = 'The static page should be available at the following standard URL, but actually a browser won\'t be able to download and view it either because of connection error or responding slower than checkavailabilitytimeout config (perhaps there is something wrong with your webserver configuration - see README file for details):<br /><strong>{$a}</strong>';
$string['settingspagelistentrystandardfail'] = 'The static page should be available at the following standard URL, but actually a browser won\'t be able to download and view it due to a non-2xx HTTP status code (perhaps there is something wrong with your webserver configuration - see README file for details):<br /><strong>{$a}</strong>';
$string['settingspagelistentrystandardsuccess'] = 'The static page is available and can be linked to at the following standard URL:<br /><strong>{$a}</strong>';
$string['settingspagelistentryrewritedisabled'] = 'The static page should be available to at the following clean URL, but is not verified because checking availability is disabled:<br /><strong>{$a}</strong>';
$string['settingspagelistentryrewriteerror'] = 'The static page should be available to at the following clean URL, but actually a browser won\'t be able to download and view it either because of connection error or responding slower than checkavailabilitytimeout config (perhaps there is something wrong with your webserver or mod_rewrite configuration - see README file for details):<br /><strong>{$a}</strong>';
$string['settingspagelistentryrewritefail'] = 'The static page should be available to at the following clean URL, but actually a browser won\'t be able to download and view it due to a non-2xx HTTP status code (perhaps there is something wrong with your webserver or mod_rewrite configuration - see README file for details):<br /><strong>{$a}</strong>';
$string['settingspagelistentryrewritesuccess'] = 'The static page is available and can be linked to at the following clean URL:<br /><strong>{$a}</strong>';
$string['upgrade_notice_2016020307'] = '<strong>UPGRADE NOTICE:</strong> The static page document files were moved to the new filearea within Moodle. You can delete the legacy documents directory {$a} now. For more upgrade instructions, especially if you have been using the multilanguage features of this plugin, see README file.';
$string['checkavailability'] = 'Check availability';
$string['checkavailability_desc'] = 'Configure if Moodle should check for static file availability on the list of static pages or not.';
$string['checkavailabilityyes'] = 'Yes, check availability';
$string['checkavailabilityno'] = 'No, don\'t check availability';
$string['checkavailabilityconnecttimeout'] = 'Connect timeout';
$string['checkavailabilityconnecttimeout_desc'] = 'Configure the maximum number of seconds to wait while trying to connect during the availability check. Use 0 to wait indefinitely.';
$string['checkavailabilitytimeout'] = 'Timeout';
$string['checkavailabilitytimeout_desc'] = 'Configure the maximum number of seconds to allow cURL functions to execute during the availability check. Use 0 to allow indefinite execution time.';
$string['checkavailabilityresponsedisabled'] = 'Not checked';
$string['checkavailabilityresponseerror'] = 'Not available - Error';
$string['checkavailabilityresponsefail'] = 'Not available - Non-2xx';
$string['checkavailabilityresponsesuccess'] = 'Available';



$string['membership_settings'] = 'Membership Plan(s) Settings';
$string['noofmembershipplans'] = 'No of Membership Plan(s)';
$string['noofmembershipplansdesc'] = 'Select no of Membership Plan(s) you want to use';
$string['neverexpires'] = 'Never Expires';

$string['planstatus'] = 'Membership Role';
$string['planstatusdesc'] = 'Mark the membership as new if it is a new membership, otherwise the same identifier will continue to be used.';
$string['newplan'] = 'New';
$string['modifiedplan'] = 'Modified';


$string['zero'] = '0';
$string['one'] = '1';
$string['two'] = '2';
$string['three'] = '3';
$string['four'] = '4';
$string['five'] = '5';
$string['six'] = '6';
$string['seven'] = '7';
$string['eight'] = '8';
$string['nine'] = '9';
$string['ten'] = '10';
$string['eleven'] = '11';
$string['twelve'] = '12';
$string['thirteen'] = '13';
$string['fourteen'] = '14';
$string['fifteen'] = '15';
$string['sixteen'] = '16';
$string['seventeen'] = '17';
$string['eighteen'] = '18';
$string['nineteen'] = '19';
$string['twenty'] = '20';
$string['twentyone'] = '21';
$string['twentytwo'] = '22';
$string['twentythree'] = '23';
$string['twentyfour'] = '24';
$string['twentyfive'] = '25';
$string['membershipname'] = 'Membership Name';
$string['membershipnamedesc'] = 'Enter the Membership Name';

$string['membershipid'] = 'Membership ID (Braintree)';
$string['membershipiddesc'] = 'The Membership ID asigned for this plan.';


$string['membershipmonthlyfee'] = 'Membership Monthly fee';
$string['membershipmonthlyfeedesc'] = 'Enter Monthly fee for this membership plan. Zero or Empty for a Free Plan';
$string['membershipmonthlyintervalvalue'] = 'Membership Monthly interval value';
$string['membershipmonthlyintervalvaluedesc'] = 'Enter the membership interval value.';
$string['noofmembershipmonthlybillingcycles'] = 'Number of Membership Monthly Billing Cycles';
$string['noofmembershipmonthlybillingcyclesdesc'] = 'Enter the number of monthly billing cycles for this membership plan.';


$string['membershipbiannualfee'] = 'Membership Biannual fee';
$string['membershipbiannualfeedesc'] = 'Enter Biannual fee for this membership plan. Zero or Empty for a Free Plan';
$string['membershipbiannualintervalvalue'] = 'Membership Biannual interval value';
$string['membershipbiannualintervalvaluedesc'] = 'Enter the membership interval value.';
$string['noofmembershipbiannualbillingcycles'] = 'Number of Membership Biannual Billing Cycles';
$string['noofmembershipbiannualbillingcyclesdesc'] = 'Enter the number of biannual billing cycles for this membership plan.';


$string['membershipyearlyfee'] = 'Membership Yearly fee';
$string['membershipyearlyfeedesc'] = 'Enter Yearly fee for this membership plan. Zero or Empty for a Free Plan';
$string['membershipyearlyintervalvalue'] = 'Membership Yearly interval value';
$string['membershipyearlyintervalvaluedesc'] = 'Enter the membership interval value.';
$string['noofmembershipyearlybillingcycles'] = 'Number of Membership Yearly Billing Cycles';
$string['noofmembershipyearlybillingcyclesdesc'] = 'Enter the number of yearly billing cycles for this membership plan.';


$string['membershipcohorts'] = 'Membership Cohort(s)';
$string['membershipcohortsdesc'] = 'Select cohort(s) to mapping with this membership plan';


$string['membershipcourses'] = 'Membership Course(s)';
$string['membershipcoursesdesc'] = 'Select course(s) to mapping with this membership plan';
$string['membershipplandescription'] = 'Membership Plan Description';
$string['membershipplandescriptiondesc'] = 'Enter the description of this membership plan';


$string['noofmembershipfeatures'] = 'No of Membership Features';
$string['noofmembershipfeaturesdesc'] = 'Select no of Membership Features you want to add';
$string['membershipfeaturestext'] = 'Membership Feature Text';
$string['membershipfeaturestextdesc'] = 'Write the feature text';


$string['noofmembershippromotioncodes'] = 'No of Membership Promotion Codes';
$string['noofmembershippromotioncodesdesc'] = 'Select no of Membership Promotion Codes you want to add';

$string['membershippromotioncodestext1'] = 'Membership Promotion Code #1';
$string['membershippromotioncodestextdesc1'] = 'Write the Promotion Code #1';
$string['membershippromotioncodesdiscount1'] = 'Membership Promotion Code #1 Discount';
$string['membershippromotioncodesdiscountdesc1'] = 'Discount value for Promotion Code #1';

$string['membershippromotioncodestext2'] = 'Membership Promotion Code #2';
$string['membershippromotioncodestextdesc2'] = 'Write the Promotion Code #2';
$string['membershippromotioncodesdiscount2'] = 'Membership Promotion Code #2 Discount';
$string['membershippromotioncodesdiscountdesc2'] = 'Discount value for Promotion Code #2';

$string['membershippromotioncodestext3'] = 'Membership Promotion Code #3';
$string['membershippromotioncodestextdesc3'] = 'Write the Promotion Code #3';
$string['membershippromotioncodesdiscount3'] = 'Membership Promotion Code #3 Discount';
$string['membershippromotioncodesdiscountdesc3'] = 'Discount value for Promotion Code #3';

$string['membershippromotioncodestext4'] = 'Membership Promotion Code #4';
$string['membershippromotioncodestextdesc4'] = 'Write the Promotion Code #4';
$string['membershippromotioncodesdiscount4'] = 'Membership Promotion Code #4 Discount';
$string['membershippromotioncodesdiscountdesc4'] = 'Discount value for Promotion Code #4';

$string['membershippromotioncodestext5'] = 'Membership Promotion Code #5';
$string['membershippromotioncodestextdesc5'] = 'Write the Promotion Code #5';
$string['membershippromotioncodesdiscount5'] = 'Membership Promotion Code #5 Discount';
$string['membershippromotioncodesdiscountdesc5'] = 'Discount value for Promotion Code #5';

$string['membershippromotioncodestext6'] = 'Membership Promotion Code #6';
$string['membershippromotioncodestextdesc6'] = 'Write the Promotion Code #6';
$string['membershippromotioncodesdiscount6'] = 'Membership Promotion Code #6 Discount';
$string['membershippromotioncodesdiscountdesc6'] = 'Discount value for Promotion Code #6';



$string['membershipnameval1'] = 'Plan 1';
$string['membershipnameval2'] = 'Plan 2';
$string['membershipnameval3'] = 'Plan 3';
$string['membershipnameval4'] = 'Plan 4';
$string['membershipnameval5'] = 'Plan 5';
$string['membershipnameval6'] = 'Plan 6';
$string['membershipnameval7'] = 'Plan 7';
$string['membershipnameval8'] = 'Plan 8';
$string['membershipnameval9'] = 'Plan 9';
$string['membershipnameval10'] = 'Plan 10';
$string['membershipnameval11'] = 'Plan 11';
$string['membershipnameval12'] = 'Plan 12';
$string['membershipnameval13'] = 'Plan 13';
$string['membershipnameval14'] = 'Plan 14';
$string['membershipnameval15'] = 'Plan 15';
$string['membershipnameval16'] = 'Plan 16';
$string['membershipnameval17'] = 'Plan 17';
$string['membershipnameval18'] = 'Plan 18';
$string['membershipnameval19'] = 'Plan 19';
$string['membershipnameval20'] = 'Plan 20';
$string['membershipnameval21'] = 'Plan 21';
$string['membershipnameval22'] = 'Plan 22';
$string['membershipnameval23'] = 'Plan 23';
$string['membershipnameval24'] = 'Plan 24';
$string['membershipnameval25'] = 'Plan 25';
$string['no'] = 'No';
$string['yes'] = 'Yes';
$string['freetrial'] = 'Allow Free Trial';
$string['freetrialdesc'] = 'If you want to allow Free Trial for this membership plan then select \'Yes\'';
$string['freetrialduration'] = 'Free Trial day(s) duration';
$string['freetrialdurationdesc'] = 'Select Free Trial\'s day(s) duration for this membership plan. It must be a number. Ex: If you want a free trial for 15days then just enter 15';







$string['membershiplogo'] = 'Membership Logo';
$string['membershiplogodesc'] = 'Upload the logo of this Membership Plan';


$string['payment_settings'] = 'Membership Payment Settings';
$string['paymentcurrency'] = 'Payment Currency';
$string['enable'] = 'Enable';
$string['disable'] = 'Disable';
$string['sendpaymentbutton'] = 'Send payment via Paypal';
$string['paymentcancel'] = 'Paypal payment was cancelled. Please try later.';
$string['defaulterrorpsub'] = 'Something went wrong. Please try again later.';
$string['paymentdelay'] = 'Notification of payment is on the way, when we receive the notification that payment has been made your courses will be added automatically';
$string['paymentthanks'] = 'Thank you for your payment. You are successfully subscribe into .';
$string['paypalsandboxstatus'] = 'Allow Paypal Sandbox';
$string['paypalsandboxstatus_desc'] = 'Select \'Enable\' to use paypal sandbox otherwise for production sites Please select \'Disable\'.';
$string['paypalbusinessemail'] = 'Paypal business email';
$string['paypalbusinessemail_desc'] = 'The email address of your business paypal account. This setting is mandatory to use this plugin.';
$string['paypalclientid'] = 'Paypal client Id';
$string['paypalclientid_desc'] = 'The client id of your paypal app. This setting is used to view and cancel any subscription';
$string['paypalsecret'] = 'Paypal secret';
$string['paypalsecret_desc'] = 'The secret of your paypal app. This setting is used to view and cancel any subscription';
$string['emailssettings'] = 'Membership Emails Settings';
$string['mailadmins'] = 'Send mail to admins';
$string['mailstudents'] = 'Send mail to students';
$string['courseenrolmentmailsubject'] = 'Mail subject for buy any Tier';
$string['courseenrolmentmailsubjectval'] = '{$a->subscription_name} - Membership Subscription';
$string['courseenrolmentmailbody'] = 'Mail body for buy any Tier';
$string['courseenrolmentmailbodyval'] = 'Dear {$a->full_name}, You are successfully subscribed into {$a->subscription_name} membership. Your subscription id is {$a->subscription_id} and cost is {$a->subscription_currency} {$a->subscription_amount}. Thankyou for choosing this plan.';
$string['courseenrolmentmailsubjectfree'] = 'Mail subject for buy any FREE Tier';
$string['courseenrolmentmailsubjectvalfree'] = '{$a->subscription_name} - Membership Subscription';
$string['courseenrolmentmailbodyfree'] = 'Mail body for buy any FREE Tier';
$string['courseenrolmentmailbodyvalfree'] = 'Dear {$a->full_name}, You are successfully subscribed into {$a->subscription_name} membership. Thankyou for choosing this plan.';
$string['trailperiodexpiressubject'] = 'Mail subject for trail period expires';
$string['trailperiodexpiressubjectval'] = '{$a->subscription_name} - Trail period expires';
$string['trailperiodexpiresbody'] = 'Mail body for trail period expires';
$string['trailperiodexpiresbodyval'] = 'Dear {$a->full_name}, Your trail period for {$a->subscription_name} membership plan has been expired on {$a->trail_expires_date}.';
$string['licensepagesettings'] = 'Membership License Settings';
$string['licensepagesettings_desc'] = 'Activate your license to use this plugin. Click on <a href="'.$CFG->wwwroot.'/local/membership/license.php">License Settings</a> page to activate your license.';
$string['licensekey'] = 'License Key';
$string['licensekeydesc'] = 'Enter your license key to activate your license';


$string['membershipdashboard'] = 'Membership Dashboard'; 
$string['membership'] = 'Membership';
$string['home'] = 'Home';
$string['groups'] = 'Groups';
$string['attendance'] = 'Attendance';
$string['calendar'] = 'Calendar';
$string['timesheet'] = 'Timesheet';
$string['dashboard'] = 'Dashboard';
$string['settings'] = 'Settings';
$string['overall'] = 'Overall';
$string['dateranges'] = 'Date ranges';
$string['ondate'] = 'On {$a}';
$string['activestudents'] = 'Active Students';
$string['newstudents'] = 'New Students';
$string['pausedstudents'] = 'Paused Students';
$string['declinedstudents'] = 'Declined Students';
$string['dropoutstudent'] = 'Drop out Student';
$string['retention'] = 'Retention';
$string['vslastmonth'] = 'vs last month({$a})';
$string['overallstudentsgraph'] = 'Overall Students Graph';
$string['searchplaceholder'] = 'search by name, email, phone number';
$string['filter'] = 'Filter';
$string['patreonauth'] = 'Patreon Auth';
$string['copy'] = 'Copy';
$string['download'] = 'Download';
$string['create'] = 'Create';
$string['togglecolumns'] = 'Toggle Columns';
$string['showing'] = 'Showing';
$string['students'] = 'students';
$string['datalastrefresh'] = 'Data last refresh: {$a}';
$string['confirmaction'] = 'Confirm Action';
$string['confirmcanceltext'] = 'Are you sure that you want to cancel this subscription?';
$string['yes'] = 'Yes';
$string['no'] = 'No';
$string['startdate'] = 'Start Date';
$string['enddate'] = 'End Date';
$string['apply'] = 'Apply';
$string['reset'] = 'Reset';
$string['totalrevenue'] = 'Total Revenue';
$string['neutral'] = 'Neutral';
$string['daterange'] = 'Date Range';
$string['today'] = 'Today';
$string['yesterday'] = 'Yesterday';
$string['pastmonth'] = 'Past month';
$string['past3months'] = 'Past 3 months';
$string['past6months'] = 'Past 6 months';
$string['custom'] = 'Custom';
 