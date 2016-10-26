<?php
/**
 * test get google sheet
 */
require_once dirname(__DIR__) . '/core/bootstrap.php';

// --------------------------------------------------------------------------------
//  start
// --------------------------------------------------------------------------------
use App\Business\GoogleSheet\Helper;


$rows = Helper::getGoogleSheetByFile();
if (!$rows) {
    show("can not get google sheet file!");
    exit;
}

table($rows);
