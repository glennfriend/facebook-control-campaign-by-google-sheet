<?php
/**
 * test get google sheet
 */
require_once dirname(__DIR__) . '/core/bootstrap.php';

/**
 *
 */
use App\Business\GoogleSheet\Helper;


// --------------------------------------------------------------------------------
//  start
// --------------------------------------------------------------------------------
Helper::checkOvertimeToDownloadFile();
$rows = Helper::getGoogleSheetByFile();

if (!$rows) {
    show("can not get google sheet file!");
    exit;
}

table($rows);
show('Total Count: ' . count($rows));
