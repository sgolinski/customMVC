<?php
/**
 * Base Controller
 * Loads the models and views
 */

class Controller
{
    // Load model
    public function model($model)
    {
        // require model file
        require_once '../app/models/' . $model . '.php';

        // Instatiante model
        return new $model();
    }

    //load view

    public function view($view, $data = [])
    {
        // Check for the view file

        if (file_exists('../app/views/' . $view . '.php')) {

            require_once '../app/views/' . $view . '.php';

        } else {
            die('View does not exist');
        }
    }
}