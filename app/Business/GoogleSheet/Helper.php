<?php
namespace App\Business\GoogleSheet;
use \App\Utility\ThirdPartyService\GoogleSheet\Csv as GoogleSheetCsv;

/**
 *
 */
class Helper
{
    /**
     *  如果超過 ? 秒鐘, 必須要重新下載檔案
     *  1800 秒 = 30 分鐘 = 30 * 60
     */
    const OVERTIME_SECOND = 1800;

    /**
     *  檢查下載的 google sheet 是否超過一定的時間
     *  如果超過就下載, 否則就略過
     */
    public static function checkOvertimeToDownloadFile()
    {
        $file = getProjectPath('/var/week.json');

        // 如果檔案不存在
        if (!file_exists($file)) {
            self::downloadGoogleSheetToFile();
            return;
        }

        // 檢查檔案儲存的時間
        $fileTime = filemtime($file);

        if ((time() - $fileTime) > self::OVERTIME_SECOND) {
            // 超時
            self::downloadGoogleSheetToFile();
        }
        else {
            // 未超時
        }

    }

    /**
     *  下載 google sheet 並存成檔案
     */
    public static function downloadGoogleSheetToFile()
    {
        $fileId = conf('google.sheet.file_id');
        $headers = GoogleSheetCsv::getHeadersByFileId($fileId);
        $rows = GoogleSheetCsv::getMapsByFileId($fileId);
        if (!$rows) {
            return false;
        }

        $jsonString = json_encode($rows, JSON_PRETTY_PRINT);
        $weekFilePath = getProjectPath('/var/week.json');

        $result = file_put_contents($weekFilePath, $jsonString);
        if (!$result) {
            return false;
        }
        return true;
    }

    /**
     *  取得 google sheet 下載之後的內容
     *
     *  @param boolean $ifNotExistsGoToDownload 如果檔案不存在就下載
     *  @return Array
     */
    public static function getGoogleSheetByFile($ifNotExistsGoToDownload=true)
    {
        $file = getProjectPath('/var/week.json');

        // 如果檔案不存在
        if (!file_exists($file)) {

            if ($ifNotExistsGoToDownload) {
                // 嘗試下載
                self::downloadGoogleSheetToFile();
                if (!file_exists($file)) {
                    return [];
                }
            }
            else {
                return [];
            }

        }

        // 如果檔案存在
        $jsonString = file_get_contents($file);
        return json_decode($jsonString, true);
    }

}