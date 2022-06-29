<?php

namespace App\Controller;

use App\App;
use App\Auth\DBAuth;
use App\Models\Models;
use App\Models\Questions;
use App\Models\QuestionsChoices;
use App\Models\Quizz;
use App\Models\Users;
use App\Models\UsersQuizz;
use App\Models\QuizzQuestions;


class QuizzController extends Controller
{
    private $usersObj;
    private $quizzObj;
    private $questionsObj;
    private $questionsChoicesObj;
    private $usersQuizzObj;
    private $quizzQuestionsObj;


    public function __construct()
    {
        parent::__construct();

        $this->usersObj = new Users();
        $this->quizzObj = new Quizz();
        $this->questionsObj = new Questions();
        $this->questionsChoicesObj = new QuestionsChoices();
        $this->quizzQuestionsObj = new QuizzQuestions();
        $this->usersQuizzObj = new UsersQuizz();
    }


    public function home()
    {
        $user_id = self::$authObj->getUserId();
        $user = $this->usersObj->getUser($user_id);

        $quizzes = $this->quizzObj->all();
        $all_quizzes = [];

        try {
            foreach ($quizzes as $quizz) {
                $data = ["questions" => 0, "quizz" => $quizz];
                $questions  = Models::query('SELECT * FROM quizzquestions WHERE quizz_id = ? ', [$quizz->id]);
                $quizz->questions = count($questions);
                $all_quizzes[] = $data;
            }
        } catch (\Throwable $th) {
            die($th->getMessage());
        }

        $this->render([
            "title" => "Quizzs page",
            "vue" => "common/questions",
            "isLoggedIn" => self::$authObj->logged(),
            "user" => $user,
            "quizzes" => $quizzes,
        ]);
    }

    public function quizz($quizz_id)
    {

        $quizz = $this->quizzObj->find($quizz_id);

        $questions  = Models::query('SELECT * FROM quizzquestions WHERE quizz_id = ? ', [$quizz->id]);

        foreach ($questions as $question) {
            $question->choices  = Models::query('SELECT * FROM questionschoices WHERE question_id = ? ', [$question->question_id]);

            $question->question  = Models::query('SELECT * FROM questions WHERE id = ? ', [$question->question_id], true);
        }

        $quizz->questions = $questions;

        $user_id = self::$authObj->getUserId();
        $user = $this->usersObj->getUser($user_id);

        $this->render([
            "title" => "Quizz page",
            "vue" => "common/quizz",
            "quizz" => $quizz,
            "isLoggedIn" => self::$authObj->logged(),
            "user" => $user
        ]);
    }
}
