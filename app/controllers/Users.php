<?php

class Users extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model('User');
    }


    public function register()
    {
        // check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Sanitiaze host data

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);


            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'email_err' => '',
                'name_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''

            ];


            //validation

            if (empty($data['email'])) {
                //validate email
                $data['email_err'] = 'Please enter email';

            } else {
                //check email
                if ($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'Email is already taken';
                }
            }
            if (empty($data['name'])) {
                //validate email
                $data['name_err'] = 'Please enter name';

            }

            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';

            } elseif (strlen($data['password']) < 6) {
                $data['password_err'] = 'Password must be at least 6 characters';
            }

            if (empty($data['confirm_password'])) {
                //validate email
                $data['password_err'] = 'Please confirm password';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Password doesnt match';
                }
            }

            if (empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                // Validate

                //hash password

                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                if ($this->userModel->register($data)) {
                    flash('register_success', 'You are register and can login');
                   redirect('users/login');
                } else {
                    die('Something goes wrong');
                }
            } else {
                // load view with errors

                $this->view('users/register', $data);
            }


        } else {
            // init data
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'email_err' => '',
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
            // check for post
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                //Sanitiaze host data

                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);


                $data = [

                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'email_err' => '',
                    'password_err' => '',
                ];
                if (empty($data['email'])) {
                    //validate email
                    $data['email_err'] = 'Please enter email';

                }

                if (empty($data['password'])) {
                    //validate email
                    $data['password_err'] = 'Please enter password';

                }

                if (empty($data['email_err']) && empty($data['password_err'])) {
                    // Validate
                    //hash password
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                    // Register User

                } else {
                    // load view with errors

                    $this->view('users/register', $data);
                }


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
}