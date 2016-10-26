<?php
namespace App\Utility\ThirdPartyService\GoogleSheet;
use League\Csv\Reader;

/**
 *  用來下載、處理 google sheet 的程式
 *  不使用 google 的認證
 *  而是利用 共用 google sheet 的方式來達成下載
 *
 *  Example:
 *          $googleSheetFileId = 'xxxxxxxxxx-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
 *          $headers = GoogleSheetCsv::getHeadersByFileId($googleSheetFileId);
 *          $rows    = GoogleSheetCsv::getMapsByFileId($googleSheetFileId);
 *
 */
class Csv
{
    /**
     *
     */
    protected static $error = null;

    /**
     *
     */
    public static function getError()
    {
        return self::$error;
    }

    // --------------------------------------------------------------------------------
    // get
    // --------------------------------------------------------------------------------

    /**
     *  從 google sheet file id 取得處理過的 headers 內容
     */
    public static function getHeadersByFileId($fileId, $gid=0)
    {
        $items = self::_getOriginArrayByFileId($fileId, $gid);
        return self::_convertHeaders(array_shift($items));
    }

    /**
     *  從 google sheet file id 取得處理過的 array 內容
     */
    public static function getMapsByFileId($fileId, $gid=0)
    {
        $items = self::_getOriginArrayByFileId($fileId, $gid);
        $headers = self::_convertHeaders(array_shift($items));

        // items
        $rows = [];
        foreach ($items as $item) {

            // dd_dump($item);
            $item = self::_filterUnusedCode($item);

            // 略過空的陣列
            if (self::_checkIsEmptyArray($item)) {
                continue;
            }

            $rows[] = array_combine($headers, $item);

        }

        return ($rows);
    }

    // --------------------------------------------------------------------------------
    // private
    // --------------------------------------------------------------------------------

    /**
     *  從 google sheet file id 取得原始 CSV 內容
     */
    private static function _getOriginContent($fileId, $gid=0)
    {
        self::$error = null;

        try {
            $url = "https://docs.google.com/spreadsheets/u/0/d/{$fileId}/export?format=csv&gid={$gid}";
            return file_get_contents($url);
        }
        catch (\Exception $e) {
            self::$error = $e->getMessage();
            errorlog($e->getMessage());
            return null;
        }

    }

    /**
     *  從 google sheet file id 取得 array 內容
     */
    private static function _getOriginArrayByFileId($fileId, $gid=0)
    {
        $content = self::_getOriginContent($fileId, $gid);
        $reader = Reader::createFromString($content);
        return $reader->fetchAll();
    }

    /**
     *  轉換 headers
     *      - 標題名稱 做基本的過濾
     *      - 不讓標題名稱有重覆的機會
     */
    private static function _convertHeaders(Array $originHeaders)
    {
        $headers = [];
        foreach ($originHeaders as $index => $head) {
            $head = self::_normalNameCase($head);
            if (!$head) {
                $head = 'unknown';
            }
            if (in_array($head, $headers)) {
                $head .= '_' . uniqid();
            }
            $headers[$index] = $head;
        }
        return $headers;
    }

    /**
     *  將 header name 轉為乾淨的字串
     */
    private static function _normalNameCase($value)
    {
        $value = str_replace(['-',' ','&'], '_', $value);
        $value = preg_replace("/[^a-zA-Z0-9_]+/", "", $value );
        $value = strtolower(trim($value));
        return $value;
    }

    /**
     *  檢查該 二維陣列 是否 value 值全都是空的
     */
    private static function _checkIsEmptyArray($items)
    {
        foreach ($items as $value) {
            if ('' !== $value) {
                return false;
            }
        }
        return true;
    }

    /**
     *  Clean invisible control characters and unused code points
     *
     *  \p{C} or \p{Other}: invisible control characters and unused code points.
     *      \p{Cc} or \p{Control}: an ASCII 0x00–0x1F or Latin-1 0x80–0x9F control character.
     *      \p{Cf} or \p{Format}: invisible formatting indicator.
     *      \p{Co} or \p{Private_Use}: any code point reserved for private use.
     *      \p{Cs} or \p{Surrogate}: one half of a surrogate pair in UTF-16 encoding.
     *      \p{Cn} or \p{Unassigned}: any code point to which no character has been assigned.
     *
     *  該程式可以清除 RIGHT-TO-LEFT MARK (200F)
     *
     *  @see http://www.regular-expressions.info/unicode.html
     *
     */
    private static function _filterUnusedCode($row)
    {
        foreach ($row as $key => $value) {
            $row[$key] = preg_replace('/\p{C}+/u', "", $value );
        }
        return $row;
    }

}