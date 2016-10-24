<?php
namespace App\Business\System;

/**
 *
 */
class SystemHelper
{

    /**
     *
     */
    public static function getToken()
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
     *
     */
    public static function setToken($content)
    {
        $tokenFile = getProjectPath('/var/token.key');
        return file_put_contents($tokenFile, $content);
    }

}