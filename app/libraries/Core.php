<?php

/**
 * App core class
 * Create urls
 * loads core controllers
 * URL FORMAT  - /controller/method/params
 */

class Core
{
    protected $currentController = 'Pages';
    protected $currentMethod;
    protected $params = [];

    public function __construct()
    {
        $url = $this->getUrl();
        if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
            $this->currentController = ucwords($url[0]);
            unset($url[0]);
        };


        require_once '../app/controllers/' . $this->currentController . '.php';
        $this->currentController = new $this->currentController;


        if ($url[1]) {
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        } else {
            $this->currentMethod = 'index';
        }
        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }


    public function getUrl()
    {

        if (isset($_GET['url'])) {

            $url = rtrim($_GET['url'], '/'); //usuwanie wskazanego ostatniego znaku
            $url = filter_var($url, FILTER_SANITIZE_URL); //sprawdza czy nie posiada znakow jakich nie powinno byc w url
            $url = explode('/', $url);

            return $url;
        }

    }
}