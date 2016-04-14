<?php

namespace Modules\Core\Composers;

use Dingo\Api\Routing\Router;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use JavaScript;
use Modules\Core\Contracts\Authentication;
use Modules\Core\Utilities\AssetManager\JavascriptPipeline\JavascriptPipeline;

class MasterViewComposer
{
    /**
     * @var JavascriptPipeline
     */
    private $javascriptPipeline;

    /**
     * @var Authentication
     */
    private $auth;

    /**
     * MasterViewComposer constructor.
     *
     * @param JavascriptPipeline $javascriptPipeline
     * @param Authentication     $auth
     */
    public function __construct(JavascriptPipeline $javascriptPipeline, Authentication $auth)
    {
        $this->javascriptPipeline = $javascriptPipeline;
        $this->auth = $auth;
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('jsPipeline', $this->composeJsPipeline());
    }

    /**
     * @return string
     */
    protected function composeJsPipeline()
    {
        $output = '';
        $jwtoken = $this->getJWT();

        $this->setJWT($jwtoken);

        $this->provideAPIRoutes();

        $output .= $this->setVueResourceHeader($jwtoken);

        foreach ($this->javascriptPipeline->allJs() as $js) {
            $output .= $js;
        }

        return $output;
    }

    /**
     * Get the JWT for the current user.
     */
    protected function getJWT()
    {
        if ($user = $this->auth->check()) {
            return \JWTAuth::fromUser($user);
        }
    }

    /**
     * Send the jwt to the JavaScript Pipeline.
     *
     * @param $jwtoken
     */
    protected function setJWT($jwtoken)
    {
        JavaScript::put(['jwtoken' => $jwtoken]);
    }

    /**
     * @param $jwtoken
     *
     * @return string
     */
    protected function setVueResourceHeader($jwtoken)
    {
        return "Vue.http.headers.common['Authorization'] = 'Bearer {$jwtoken}';";
    }

    /**
     * Provide all api routes as javascript variables.
     */
    protected function provideAPIRoutes()
    {
        $routes = Cache::rememberForever('provideAPIRoutes', function () {
            $router = app(Router::class);
            $routes = [];
            foreach ($router->getRoutes() as $collection) {
                foreach ($collection->getRoutes() as $route) {
                    $temp = &$routes;
                    if ($routeName = $route->getName()) {
                        foreach (explode('.', $routeName) as $key) {
                            $temp = &$temp[$key];
                        }
                        $temp = preg_replace('/{(\w+)}/', ':$1', $route->uri());
                    }
                }
            }

            return $routes['api'];
        });

        JavaScript::put(['api' => $routes]);
    }
}
