<?php
namespace App\Controllers\FacebookPage;
use Bridge;
use App\Controllers\FacebookPageController;
use App\Business\Facebook\FacebookHelper;

/**
 *
 */
class Ad extends FacebookPageController
{

    /**
     *
     */
    protected function Adaccounts()
    {
        $this->render('facebookPage.ad.adaccounts', [
            'fb'            => FacebookHelper::getFacebook(),
            'adAccountId'   => Bridge\Input::get('aId'),
            'adAccountName' => Bridge\Input::get('aName'),
        ]);
    }

}
