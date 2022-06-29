<?php

namespace App\Controller;

use App\App;
use App\Auth\DBAuth;
use App\Models\Models;
use App\Models\Quizz;
use App\Models\Users;
use App\Models\UsersQuizz;

class UserDashboardController extends Controller
{
    private $usersObj;
    private $quizzObj;
    private $usersQuizzObj;

    public function __construct()
    {
        parent::__construct();
        $this->quizzObj = new Quizz();
        $this->usersObj = new Users();
        $this->usersQuizzObj = new UsersQuizz();
    }

    public function home()
    {

        $user_id = self::$authObj->getUserId();
        $user = $this->usersObj->getUser($user_id);

        try {
            $my_quizzes = Models::query('
                SELECT
                    usersquizz.quizz_id,
                    quizz.title,
                    quizz.level,
                    quizz.created_at,
                    usersquizz.user_id,
                    usersquizz.score,
                    users.pseudo AS quizzer
                FROM usersquizz
                LEFT JOIN quizz ON usersquizz.quizz_id = quizz.id
                LEFT JOIN users ON usersquizz.user_id = users.id
                WHERE usersquizz.user_id = ?
            ', [$user_id]);
        } catch (\Throwable $th) {
            die($th->getMessage());
        }


        try {
            $this->render([
                "template" => "guest",
                "title" => "Home Page",
                "vue" => "user/dashboard",

                "isLoggedIn" => self::$authObj->logged(),

                "user" => $user,

                "my_quizzes" => $my_quizzes,
            ]);
        } catch (\Throwable $th) {
            die($th->getMessage());
        }
    }
}
