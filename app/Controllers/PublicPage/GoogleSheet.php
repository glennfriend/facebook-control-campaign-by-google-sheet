<?php
namespace App\Controllers\PublicPage;
use App\Controllers\PublicPageController;
use App\Business\GoogleSheet\Helper;

/**
 *
 */
class GoogleSheet extends PublicPageController
{

    /**
     *
     */
    protected function listContent()
    {
        Helper::checkOvertimeToDownloadFile();
        $rows = Helper::getGoogleSheetByFile();
        if (!$rows) {
            echo 'Error: maybe is file id not found, or can not download';
            exit;
        }

        $headers = array_keys($rows[0]);
        table($rows, $headers);
    }

}
