<?php
namespace App\Business\System;

/**
 *
 */
class SystemHelper
{

    /**
     *  取得一個 facebook 使用的 token string
     */
    public static function getFacebookToken()
    {
        $tokenFile = getProjectPath('/var/token.key');
        if (!file_exists($tokenFile)) {
            return null;
        }

        $content = file_get_contents($tokenFile);
        if (!$content) {
            return null;
        }

        return $content;
    }

    /**
     *  儲存一個 facebook 使用的 token string
     */
    public static function setFacebookToken($content)
    {
        $tokenFile = getProjectPath('/var/token.key');
        return file_put_contents($tokenFile, $content);
    }

}