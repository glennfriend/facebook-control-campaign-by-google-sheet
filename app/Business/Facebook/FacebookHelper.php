<?php
namespace App\Business\Facebook;
use Facebook\Facebook;
use App\Business\System\SystemHelper;

/**
 *
 */
class FacebookHelper
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

    /**
     *
     */
    public static function getFacebook()
    {
        self::$error = null;

        try {
            $facebook = new Facebook([
               'app_id'                 => conf('facebook.app.id'),
               'app_secret'             => conf('facebook.app.secret'),
               'default_graph_version'  => 'v2.8',
            ]);
        }
        catch(\Exception $e) {
            self::$error = $e->getMessage();
            return null;
        }

        // 如果有 token, 直接設定進去
        $token = SystemHelper::getFacebookToken();
        if ($token) {
            $facebook->setDefaultAccessToken($token);
        }

        return $facebook;
    }

    // --------------------------------------------------------------------------------
    //
    // --------------------------------------------------------------------------------

}