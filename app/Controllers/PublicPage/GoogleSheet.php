<?php
namespace App\Controllers\PublicPage;
use App\Controllers\PublicPageController;
use \App\Utility\ThirdPartyService\GoogleSheet\Csv as GoogleSheetCsv;

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
        $fileId = conf('google.sheet.file_id');
        $headers = GoogleSheetCsv::getHeadersByFileId($fileId);
        $rows = GoogleSheetCsv::getMapsByFileId($fileId);
        if (!$rows) {
            echo 'Error: maybe is file id not found, or can not download';
            exit;
        }

        table($rows, $headers);
    }


}
