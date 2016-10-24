<?php
namespace App\Shell\GoogleSheet;
use App\Shell\MainController;
use App\Business\GoogleSheet\Tool;
use App\Business\GoogleSheet\Service;

/**
 *
 */
class Basic extends MainController
{

    /**
     * 用來測試以下部份
     *      - 與 google 認証是否正確
     *      - 第一組 "web1" 的設定是否可以取得到 google spreadsheets
     */
    protected function TestOnly()
    {
        $showTotalCount = 2;
        $configKey = 'web1';

        $sheetManager = Service::factorySheetManagerByKey($configKey);
        $googleWorkSheet = $sheetManager->getOriginWorksheet();

        // $header = $sheetManager->getHeader();
        $count = $sheetManager->getCount();
        for ($i=0; $i<$count; $i++) {

            if (($i+1) > $showTotalCount) {
                break;
            }

            $row = $sheetManager->getRow($i);
            $row = Tool::filterUnusedCode($row);
            dd($row);

        }

        echo "total rows count = {$count}\n";
        echo "last update = " . $googleWorkSheet->getUpdated()->getTimestamp();
        echo " (" . $googleWorkSheet->getUpdated()->format('Y-m-d H:i:s') . ")";
        echo "\n";
    }

}
