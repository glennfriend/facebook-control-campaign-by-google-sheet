<?php
/**
 * test get google sheet
 */
require_once dirname(__DIR__) . '/core/bootstrap.php';

// --------------------------------------------------------------------------------
//  start
// --------------------------------------------------------------------------------
use App\Utility\ThirdPartyService\GoogleSheet\Csv as GoogleSheetCsv;


$fileId = conf('google.sheet.file_id');
$headers = GoogleSheetCsv::getHeadersByFileId($fileId);
$rows = GoogleSheetCsv::getMapsByFileId($fileId);
if (!$rows) {
    echo 'Error: maybe is file id not found, or can not download';
    exit;
}

table($rows, $headers);
