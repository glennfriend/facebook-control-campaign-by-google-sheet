<?php
/**
 * execute facebook active or pause
 *  - 從 facebook 取得所有的 campaigns id & name
 *  - 從 google sheet 取得需要修改的 campaigns 資料
 *  - 一筆一筆修改 campaign status
 */
require_once dirname(__DIR__) . '/core/bootstrap.php';

/**
 *
 */
use App\Business\GoogleSheet\Helper;
use App\Business\Facebook\FacebookHelper;
use App\Business\System\MailHelper;

// --------------------------------------------------------------------------------
//  start
// --------------------------------------------------------------------------------
Helper::checkOvertimeToDownloadFile();
$rows = Helper::getGoogleSheetByFile();

if (!$rows) {
    show("can not get google sheet file!");
    exit;
}


$allCampaigns = FacebookHelper::getAllCampaigns();
// convert key is "name", value is "id"
$myCampaigns = array_column($allCampaigns, 'id', 'name');


//
$fb = FacebookHelper::getFacebook();
$week = weekMap(date('w'));
$response = [];
$totalCount = 0;
$errorCount = 0;
$errorMessages = [];

foreach ($rows as $row) {

    set_time_limit(300);

    $totalCount++;
    echo $totalCount . ' ';

    validateRow($row);
    convertRow($row);

    $campaignId = '';
    $campaignName = $row['campaign'];
    if (isset($myCampaigns[$campaignName])) {
        $campaignId = $myCampaigns[$campaignName];
    }
    else {
        $errorCount++;
        $error = 'can not find campaign name: "'. $campaignName .'"';
        $errorMessages[] = $error;
        show($error);
        errorLog($error);
        continue;
    }

    $changeToStatus = $row[$week];
    $command = "/{$campaignId}?status={$changeToStatus}";

    try {
        $response[] = $fb->post($command);
    }
    catch(Facebook\Exceptions\FacebookResponseException $e) {
        $errorCount++;
        $error = 'Graph returned an error: ' . $e->getMessage();
        show($error);
        $errorMessages[] = $error;
    }
    catch(Facebook\Exceptions\FacebookSDKException $e) {
        $errorCount++;
        $error = 'Facebook SDK returned an error: ' . $e->getMessage();
        show($error);
        $errorMessages[] = $error;
    }

    if (0 == $totalCount % 10) {
        sleep(240);
    }

}

$content =<<<EOD
Total count: {$totalCount}
Error count: {$errorCount}

EOD;

show();
show($content);

if ($errorMessages) {
    $error = join("\n", $errorMessages);
    MailHelper::send($content . "\n" . $error, 'notice');
}
else {
    MailHelper::send($content, 'success');
}


exit;




/**
 *
 */
function validateRow($row)
{
    if (!isset($row['campaign'])) {
        show('google sheet campaign not found!');
        exit;
    }

    if (!isset($row['mon'])   ||
        !isset($row['tues'])  ||
        !isset($row['wed'])   ||
        !isset($row['thurs']) ||
        !isset($row['fri'])   ||
        !isset($row['sat'])   ||
        !isset($row['sun'])
    ) {
        show('google sheet wekky day not found!');
        exit;
    }

}

/**
 *
 */
function convertRow(&$row)
{
    $row['mon']     = strtolower($row['mon']  );
    $row['tues']    = strtolower($row['tues'] );
    $row['wed']     = strtolower($row['wed']  );
    $row['thurs']   = strtolower($row['thurs']);
    $row['fri']     = strtolower($row['fri']  );
    $row['sat']     = strtolower($row['sat']  );
    $row['sun']     = strtolower($row['sun']  );

    $changeMap = [
        'a' => 'ACTIVE',
        'p' => 'PAUSED',
    ];

    $row['mon']     = $changeMap[$row['mon']  ];
    $row['tues']    = $changeMap[$row['tues'] ];
    $row['wed']     = $changeMap[$row['wed']  ];
    $row['thurs']   = $changeMap[$row['thurs']];
    $row['fri']     = $changeMap[$row['fri']  ];
    $row['sat']     = $changeMap[$row['sat']  ];
    $row['sun']     = $changeMap[$row['sun']  ];
}

/**
 *
 */
function weekMap($weekNumber)
{
    $map = [
        '1' => 'mon',
        '2' => 'tues',
        '3' => 'wed',
        '4' => 'thurs',
        '5' => 'fri',
        '6' => 'sat',
        '0' => 'sun',
    ];
    return $map[$weekNumber];
}
