<?php
/**
 * test get google sheet
 */
require_once dirname(__DIR__) . '/core/bootstrap.php';

// --------------------------------------------------------------------------------
//  start
// --------------------------------------------------------------------------------

$controller = new App\Shell\GoogleSheet\Download();
$controller->downloadWeb1();
