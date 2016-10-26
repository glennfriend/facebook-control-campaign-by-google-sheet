<?php
namespace App\Controllers\PublicPage;
use App\Controllers\PublicPageController;
use App\Business\Facebook\FacebookHelper;
use App\Business\System\SystemHelper;

/**
 *
 */
class AuthFacebook extends PublicPageController
{

    /**
     *
     */
    protected function login()
    {
        $fb = FacebookHelper::getFacebook();
        if (!$fb) {
            dd( FacebookHelper::getError() );
        }

        $this->render('publicPage.authFacebook.login', [
            'fb' => $fb,
        ]);
    }

    /**
     *
     */
    protected function facebookCallback()
    {
        $fb = FacebookHelper::getFacebook();
        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (isset($accessToken)) {
            SystemHelper::setFacebookToken( (string) $accessToken );
        }

        $this->render('publicPage.authFacebook.facebookCallback', [
            'fb'          => $fb,
            'helper'      => $helper,
            'accessToken' => $accessToken,
        ]);
    }

}
