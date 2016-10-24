<?php
namespace App\Controllers;
use App\Utility\Project\SlimManager;
use App\Business\System\SystemHelper;

/**
 *
 */
class PublicPageController extends BaseController
{
    /**
     *  initBefore() 僅供 extend controller rewrite
     *  最終端 Controller 請使用 init()
     */
    protected function initBefore()
    {
        $this->diLoader();
        include 'publicPageHelper.php';

        di('view')->setLayout('_global.layout.public');
    }

    /**
     *
     */
    private function diLoader()
    {
    }

}
