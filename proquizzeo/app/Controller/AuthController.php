<?php

namespace App\Controller;

use App\Auth\DBAuth;
use App\Database\Database;
use App\Models\Models;
use App\Models\Users;

class AuthController extends Controller
{

    private $userObj;

    public function __construct()
    {
        parent::__construct();
        $this->userObj = new Users();
    }

    public function login()
    {
        $login_errors = !empty( $_SESSION['login_errors']) ? $_SESSION['login_errors'] : null;
        $_SESSION['login_errors'] = null;


        if (isset($_POST['login'])) {

            extract($_POST);

            if (Models::not_empty(['email', 'password'])) {
                $connected = self::$authObj->login($email, $password);
                if (!$connected) {
                    $_SESSION['login_errors'] = "Nous n'avons pas pu vous identifier ! <br />";
                    header("Location: " . Controller::$host . "login");
                    return;
                } else {
                    header("Location: " . Controller::$host);
                    return;
                }
            } else {
                $_SESSION['login_errors'] = "Veuillez remplir tous les champs ! <br />";
                header("Location: " . Controller::$host . "login");
                return;
            }
        }

        $this->render([
            "title" => "Login Page",
            "vue" => "guest/login",
            "login_errors" => $login_errors
        ]);
    }

    public function register()
    {
        $register_errors = !empty( $_SESSION['register_errors'] ) ? $_SESSION['register_errors'] : null;
        $_SESSION['register_errors'] = null;

        if (isset($_POST['register'])) {

            extract($_POST);

            if (Models::not_empty(['pseudo', 'email', 'password', 'role'])) {

                $already_exist = $this->userObj->find($email, 'email');

                if (!!$already_exist) {
                    $_SESSION['register_errors'] .= "Adresse mail déjà utilisée ! <br />";
                    header("Location: " . Controller::$host . "register");
                    return;
                } else {
                    $this->userObj->add($pseudo, $password, $email, $role);
                    self::$authObj->login($email, $password);
                }

                header("Location: " . Controller::$host);
                return;
            } else {
                $_SESSION['register_errors'] = "Veuillez remplir tous les champs ! <br />";
                header("Location: " . Controller::$host . "register");
                return;
            }
        }

        $this->render([
            "title" => "register Page",
            "vue" => "guest/register",
            "register_errors" => $register_errors
        ]);
    }
}
