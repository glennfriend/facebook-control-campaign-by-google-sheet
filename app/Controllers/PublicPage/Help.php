<?php
namespace App\Controllers\PublicPage;
use App\Controllers\PublicPageController;
use App\Utility\Project\SlimManager;

/**
 *
 */
class Help extends PublicPageController
{

    // --------------------------------------------------------------------------------
    //  help
    // --------------------------------------------------------------------------------
    protected function help()
    {
        $routes = SlimManager::getRouter()->getRoutes();
        $urlPrefix = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'];
        $show = [];
        $index = 0;

        foreach ($routes as $route) {

            if (!$this->isAllowPattern($route->getPattern())) {
                continue;
            }

            $show[$index] = [
                'pattern' => $route->getPattern(),
                'methods' => join(',' , $route->getMethods()),
                'url'     => $urlPrefix . conf('home.base.url') . $route->getPattern(),
            ];

            $description = $this->getArgumentsTip($route->getPattern());
            if ($description) {
                $show[$index]['arguments_tip'] = $description;
            }

            $index++;
        }

        echo json_encode($show);
    }

    /**
     *  對特定 pattern 做說明
     */
    private function getArgumentsTip($pattern)
    {
        switch ($pattern) {
            case '/status/{type}':
                return [1 => 'active', 0 => 'pause'];
                break;
        }
        return null;
    }

    /**
     *  不需要顯示的 pattern 可以隱藏
     */
    private function isAllowPattern($pattern)
    {
        switch ($pattern) {
            case '/fb-callback':
            case '/help':
            return false;
        }
        return true;
    }

    // --------------------------------------------------------------------------------
    //  info
    // --------------------------------------------------------------------------------
    protected function info()
    {
        echo 'Session:';

        echo '<pre>';
        print_r(
            di('session')->getAll()
        );
        echo '</pre>';

        table([
            ['Current:'        , date('Y-m-d H:i:s')],
            ['Session_Expire:' , date('Y-m-d H:i:s', di('session')->get('session_expire'))],
        ]);
    }

}
