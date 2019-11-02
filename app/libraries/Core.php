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
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct()
    {
        //$this->getUrl();
        $url = $this->getUrl();

        // Loo in controllers for fist index or first value

        if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
            // if exists set as controller

            $this->currentController = ucwords($url[0]);
            // unset 0 index
            unset($url[0]);
        };

        // Require controller
        require_once '../app/controllers/' . $this->currentController . '.php';

        // Instantiate ontroller class
        $this->currentController = new $this->currentController;


        // check for second part of url

        if (isset($url[1])) {
            //check if method exists
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];

                //unset 1 index
                unset($url[1]);
            }
        }

        // get params
        $this->params = $url ? array_values($url) : [];

        // Call a callback with array params

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