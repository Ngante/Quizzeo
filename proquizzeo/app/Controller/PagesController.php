<?php

namespace App\Controller;

use App\App;
use App\Auth\DBAuth;
use App\Models\Quizz;
use App\Models\Users;

class PagesController extends Controller
{
    private $usersObj;
    private $quizzObj;

    public function __construct()
    {
        parent::__construct();
        $this->quizzObj = new Quizz();
        $this->usersObj = new Users();
    }

    public function home()
    {


        $user_id = self::$authObj->getUserId();
        $user = $this->usersObj->getUser($user_id);

        $quizz = $this->quizzObj->all();

        try {
            $this->render([
                "template" => "guest",
                "title" => "Home Page",
                "vue" => "common/home",

                "isLoggedIn" => self::$authObj->logged(),

                "user" => $user,

                "quizzs" => $quizz,
            ]);
        } catch (\Throwable $th) {
            die($th->getMessage());
        }
    }
}
