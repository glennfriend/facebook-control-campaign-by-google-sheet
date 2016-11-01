<?php
namespace App\Business\Facebook;
use Facebook\Facebook;
use App\Business\System\SystemHelper;
use Exception;

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

    /**
     *
     */
    public static function getAllCampaigns()
    {
        $actId = conf('facebook.act.id');

        try {

            $response = self::getFacebook()->get(
                '/' . $actId . '/campaigns?fields=id,name'
            );

        }
        catch (Facebook\Exceptions\FacebookResponseException $e) {
            $error = 'Graph returned an error: ' . $e->getMessage();
            errorLog($error);
            show($error);
            exit;
        }
        catch (Facebook\Exceptions\FacebookSDKException $e) {
            $error = 'Facebook SDK returned an error: ' . $e->getMessage();
            errorLog($error);
            show($error);
            exit;
        }
        catch (Exception $e) {
            $error = 'Facebook SDK returned an error: ' . $e->getMessage();
            errorLog($error);
            show($error);
            exit;
        }

        $maxPages = 99;
        $result = [];
        $campaignsEdge = $response->getGraphEdge();
        if (count($campaignsEdge) > 0) {
            $pageCount = 0;
            do {
                set_time_limit(300);
                foreach ($campaignsEdge as $campaignsArray) {
                    $result[] = $campaignsArray->asArray();
                }
                $pageCount++;
            }
            while ($pageCount < $maxPages && $campaignsEdge = self::getFacebook()->next($campaignsEdge));
        }

        return $result;
    }

}