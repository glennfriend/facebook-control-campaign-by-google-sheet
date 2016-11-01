<?php
namespace Bridge;
use Exception;

class Log
{

    protected static $_logPath = null;

    /**
     *  init
     */
    public static function init($logPath)
    {
        self::$_logPath = $logPath;
    }

    /* --------------------------------------------------------------------------------
        access
    -------------------------------------------------------------------------------- */

    /**
     *  error log
     */
    public static function getPath()
    {
        if (null === self::$_logPath) {
            throw new Exception('Error: Log path empty');
            exit;
        }

        return self::$_logPath;
    }

    /* --------------------------------------------------------------------------------
        write
    -------------------------------------------------------------------------------- */

    /**
     *  system log
     */
    /*
    public static function record($content)
    {
        $content = date("Y-m-d H:i:s") . ' - '. $content;
        self::save('system.log', $content );
    }
    */

    /**
     *  system error log
     */
    public static function errorLog($data)
    {

        if (is_object($data)) {

            // if (is_a($data, 'Whoops\Exception\ErrorException')) {
            //     // ....
            // }

            $className = get_class($data);
            $data = 'TheErrorContentIs '. $className;
        }
        elseif (is_array($data)) {
            $data = print_r($data, true);
        }

        $content = date("Y-m-d H:i:s") . ' - '. trim($data);
        self::save('error.log', $content);
    }

    /**
     *  sql log
     */
    public static function sql($content)
    {
        if (strlen($content)>2000) {
            $content  = substr($content, 0, 2000);
            $content .= ' .... (' . strlen($content) . ')';
        }
        $content = date("Y-m-d H:i:s") .' - '. $content;
        self::save('debug-sql.log', $content);
    }

    /**
     *  cron log
     */
    public static function cron($content)
    {
        $prefix =
            date("Y-m-d H:i:s")
            . ' - '
            . date_default_timezone_get()
            . ' - '
            . 'PHP ' . phpversion()
        ;

        self::save('cron.log', $prefix . ' - ' . $content);
    }

    /* --------------------------------------------------------------------------------
        report log
    -------------------------------------------------------------------------------- */
    /**
     *  寫入 error-report
     *  回傳 report id
     */
    public static function systemErrorReport($content)
    {
        $path = self::getPath() . '/error-report';

        $now = date('dhis');
        $filename = "{$path}/{$now}.txt";
        if (file_exists($filename)) {
            $id = uniqid();
            $filename = "{$path}/{$now}-{$id}.txt";
        }

        file_put_contents($filename, $content);

        $file = basename($filename);
        return substr($file, 0, (strlen($file)-4));
    }

    /* --------------------------------------------------------------------------------
        private
    -------------------------------------------------------------------------------- */

    /**
     *  write content to file
     */
    public static function save($name, $content)
    {
        if (!preg_match('/^[a-z0-9_\-\.]+$/i', $name)) {
            return;
        }

        $filename = self::getPath() .'/'. $name;
        file_put_contents($filename, $content."\n", FILE_APPEND);
    }

}
