<?php
namespace App\Controllers;
use App\Utility\Project\SlimManager;
use App\Business\System\SystemHelper;

/**
 *
 */
class FacebookPageController extends BaseController
{
    /**
     *  initBefore() 僅供 extend controller rewrite
     *  最終端 Controller 請使用 init()
     */
    protected function initBefore()
    {
        $this->diLoader();
        include 'facebookPageHelper.php';

        // 還沒登入之前將無法進入
        $token = SystemHelper::getFacebookToken();
        if (!$token) {
            $route = SlimManager::getCurrentRoute();
            return redirect('/facebook-login');
        }

        di('view')->setLayout('_global.layout.public');
    }


    /**
     *
     */
    private function diLoader()
    {
    }

}
