<?php
namespace App\Controllers\PublicPage;
use App\Controllers\PublicPageController;
use App\Business\Facebook\FacebookHelper;

/**
 *
 */
class Home extends PublicPageController
{

    /**
     *
     */
    protected function defaultPage()
    {

        $facebook = FacebookHelper::getFacebook();
        if (!$facebook) {
            dd(FacebookHelper::getError());
        }

        $this->render('publicPage.home.defaultPage', [
            'fb' => $facebook,
        ]);
    }

}
