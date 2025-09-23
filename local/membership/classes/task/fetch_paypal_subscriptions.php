<?php
namespace local_membership\task;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/local/membership/braintree/paypal.php');

require_once(__DIR__ . '/../../braintree/paypal.php');

class fetch_paypal_subscriptions extends \core\task\scheduled_task {
    public function get_name() {
      return get_string('fetch_paypal_subscriptions', 'local_membership');

        
    }

    public function execute() {
         
     global $DB;
//      $subscriptionsIds = [
//     "I-4GD7XT34GU7V",
//     "I-EHUU090BY7LJ",
//     "I-C5N2HTRS338T",
//     "I-WGNAHYDTVT2J",
//     "I-RFH67K7BUW5B",
//     "I-2FK1X1SRS5VR",
//     "I-X1PU1S878VN5",
//     "I-B9WC4P3NUVPN",
//     "I-TF11JGUGBUBD",
//     "I-9D3BKJF9KEL8",
//     "I-SHVG8YCNRMP3",
//     "I-1XA4FVW0YAVE",
//     "I-AYBVTDW0WSWS",
//     "I-5NTVTV6GH81Y",
//     "I-RULXAFUU75H4",
//     "I-24FPKMTT5M1Y",
//     "I-Y0MC354GE3FF",
//     "I-591NEG60CAU0",
//     "I-X2KR5UYTWX1K",
//     "I-M24VCVG99311",
//     "I-CWEP4K1E8CYW",
//     "I-88PE2XL0MPE8",
//     "I-4MN23UN5XX67",
//     "I-33265681K30S",
//     "I-PYM8P2EDRPCE",
//     "I-FVW3DC9F41RD",
//     "I-65AMABW4KCR3",
//     "I-PA5SAYM253SV",
//     "I-H1UHV2HRV2SX",
//     "I-GUADYTW6E70J",
//     "I-22Y9AV7SX43T",
//     "I-DJX97S6SA86F",
//     "I-SE3JEP8SNU0R",
//     "I-JWPDCUN5F2S0",
//     "I-M9A090EU7RRV",
//     "I-ECPP238FXHSJ",
//     "I-RF4RYM1N8YWL",
//     "I-F9TUPJKDA6EE",
//     "I-4N8RU3T0YR9R",
//     "I-MU8LG5L61J0S",
//     "I-DHY05B8DDFGL",
//     "I-GRYE9DK5G9M7",
//     "I-798N34W0YPU0",
//     "I-ECCXP5E9UHNJ",
//     "I-N4C35U1TRXDC",
//     "I-N86ERVBTF90W",
//     "I-L8KJL3NMD20K",
//     "I-3AVBPC838DFT",
//     "I-2RMR2J0M695L",
//     "I-B9WML7MH361S",
//     "I-JKAGYVBE1ARC",
//     "I-WUF1YP4G22MB",
//     "I-GXE9SJTU8WGA",
//     "I-CCYASCA7MVL5",
//     "I-A91VJSBTLLVL",
//     "I-R9TSX3JUV3X2",
//     "I-GPV4KKP7XRGP",
//     "I-W2PA7LD0CEAP",
//     "I-MRPJSE082FPH",
//     "I-MNYYKSU34P41",
//     "I-JU7PTLASJ5LC",
//     "I-67X3HJRH6CXU",
//     "I-EPYYY9YUW6NG",
//     "I-N9SBYRKRTM66",
//     "I-AWA8YJP0E7JT",
//     "I-JU725TAH4JLC",
//     "I-64N94DFLV6U0",
//     "I-3YXP42GJ48AJ",
//     "I-42WXUTTA0800",
//     "I-UG7KF1E7PL6Y",
//     "I-X48UDG8B70AV",
//     "I-167AN6ACFCD7",
//     "I-7GNXD1MDW0EW",
//     "I-A2XU9BC44SN2",
//     "I-1DJYXRG3L741",
//     "I-TRPM0B51E6BW",
//     "I-F0DYRRWGH4FX",
//     "I-MKPTAFJRPCL3",
//     "I-WL8TTCPANE3W",
//     "I-4TN34N96U07P",
//     "I-TBC6EMUJ3VDP",
//     "I-10YNYFUKK5M8",
//     "I-VCS2W3GJYLG7",
//     "I-CFN8Y7703M3C",
//     "I-4484U8NBM607",
//     "I-RDJ62LEET4YH",
//     "I-XTYA4EUW45HK",
//     "I-HX1S3W5MJEXM",
//     "I-XLJJ5MJ0F07M",
//     "I-CWA2GWUBCGEF",
//     "I-TN49VV4KXJLW",
//     "I-Y3BH76DCGL7A",
//     "I-5DWGYS63PV8P",
//     "I-YRW106X7LCL6",
//     "I-6436YGEKN1YM",
//     "I-XJD7R8UFBGH3",
//     "I-JSEECAW94443",
//     "I-H1S2080MJKTR",
//     "I-ANNJGDKV8C4R",
//     "I-M76NXWRKMRN6",
//     "I-HU0LAN2DUTBJ",
//     "I-VG2RH05WWMVD",
//     "I-166X12R65AY0",
//     "I-KM96EFHYGN71",
//     "I-80CF8DAHT5JM",
//     "I-RJN4MGK2VVP2",
//     "I-XEG39TNG6P55",
//     "I-A1HS0LE5482L",
//     "I-8XPB8NVAXPW6",
//     "I-DYCDF6G6PXPH",
//     "I-VYRFB13PS5W4",
//     "I-0RSADLWD6DWK",
//     "I-LG6W2KND9DH8",
//     "I-GY92FKV9D834",
//     "I-7UFXGCVLH9GY",
//     "I-JE2RYF5WM6WU",
//     "I-YWENC12FKLLJ",
//     "I-ME7K372CGJNU",
//     "I-UT92A7JDP3NL",
//     "I-LHMX67XKBLLN",
//     "I-WY55MGF7KC0S",
//     "I-91VXCU3Y30T5",
//     "I-HV9V07P0BST8",
//     "I-WSHDKV2C1CD5",
//     "I-YWBUCG5D50PS",
//     "I-C8XU7C8H06KS",
//     "I-80C2GHALT5JM",
//     "I-FU5D7XPFHN48",
//     "I-7N13KH4C9L27",
//     "I-P3U5JJ0MJ5EC",
//     "I-WL56TH6XGB6S"
// ];

   // Create a manual lock (required to avoid stuck cron lock errors)
    $factory = \core\lock\lock_config::get_lock_factory('cron');
    $lock = $factory->get_lock('local_membership_fetch_paypal', 900); // 15-minute lock

    if (!$lock) {
        mtrace("❌ Could not acquire lock. Task already running.");
        return;
    }

    try {
        ini_set('max_execution_time', 0);
        set_time_limit(0);

        $accessToken = get_paypal_token();
        $subscriptions = $DB->get_records('paypal_subscriptions');

        foreach ($subscriptions as $sub) {
            mtrace("➡ Checking: {$sub->subscription_id}");

            $details = get_paypal_subscription_details($sub->subscription_id, $accessToken);
            if ($details) {
                $data = get_subscription_data($details);

                if (!isset($data['id'])) {
                    mtrace("⚠️ Invalid data received for {$sub->subscription_id}");
                    continue;
                }

                $record = $DB->get_record('paypal_subscriptions', ['subscription_id' => $data['id']]);
                if ($record) {
                    mtrace("🔄 Updating: {$data['id']} | Status: {$data['status']} | Price: {$data['price']}");
                    $record->status = $data['status'];
                    $record->price = $data['price'];
                    $record->start_date = $data['startDate'];
                    $record->end_date = $data['endDate'];
                    $record->billing_frequency = $data['billingFrequency'];
                    $record->timeupdated = time();
                    $DB->update_record('paypal_subscriptions', $record);
                } else {
                    mtrace("➕ Inserting new subscription ID: {$data['id']} | Status: {$data['status']}");
                    $newrecord = (object)[
                        'subscription_id' => $data['id'],
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'status' => $data['status'],
                        'price' => $data['price'],
                        'start_date' => $data['startDate'],
                        'end_date' => $data['endDate'],
                        'billing_frequency' => $data['billingFrequency'],
                        'timecreated' => time(),
                        'timeupdated' => time()
                    ];
                    $DB->insert_record('paypal_subscriptions', $newrecord);
                }
            } else {
                mtrace("❌ No details returned for {$sub->subscription_id}");
            }

            sleep(1); // 🔁 Throttle to avoid PayPal rate limits
        }

        mtrace("✅ Task completed.");
    } catch (\Throwable $e) {
        mtrace("💥 Exception occurred: " . $e->getMessage());
        debugging("Task crashed: " . $e->getMessage(), DEBUG_DEVELOPER);
    } finally {
        $lock->release(); // ✅ Critical: always release the lock
        mtrace("🔓 Lock released.");
    }
}
}