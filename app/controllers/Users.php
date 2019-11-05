<?php

class Users extends Controller
{
    public function __construct()
    {
    }

    public function register()
    {
        // check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
        } else {
            // init data
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''

            ];

            //Load view

            $this->view('users/register.php', $data);
        }
    }

    public function login()
    {
        // check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
        } else {
            // init data
            $data = [

                'email' => '',
                'password' => '',
                'name_err' => '',
                'password_err' => '',


            ];

            //Load view

            $this->view('users/login.php', $data);
        }

    }

}