<?php
$basePath = dirname(dirname(__DIR__));
require_once $basePath . '/core/bootstrap.php';


$app = ProjectHelper::buildApp();

// public
$app->get('/',                      'App\Controllers\PublicPage\Home:defaultPage');
$app->get('/facebook-login',        'App\Controllers\PublicPage\AuthFacebook:login');
$app->get('/facebook-callback',     'App\Controllers\PublicPage\AuthFacebook:facebookCallback');

$app->get('/404',                   'App\Controllers\PublicPage\Status:show404');


// facebook
$app->get('/ad-accounts',           'App\Controllers\FacebookPage\Ad:Adaccounts');




if (isTraining()) {
    $app->get('/help',          'App\Controllers\PublicPage\Help:help');
    $app->get('/help-info',     'App\Controllers\PublicPage\Help:info');
}

$app->run();

