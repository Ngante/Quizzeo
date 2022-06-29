<?php

namespace App\Controller;

use App\App;
use App\Auth\DBAuth;
use App\Models\Models;
use App\Models\Questions;
use App\Models\Quizz;
use App\Models\Users;
use App\Models\UsersQuizz;

class QuizzerDashboardController extends Controller
{
    private $usersObj;
    private $quizzObj;
    private $questionsObj;

    public function __construct()
    {
        parent::__construct();
        $this->questionsObj = new Questions();
        $this->usersObj = new Users();
        $this->usersQuizzObj = new UsersQuizz();
        $this->quizzObj = new Quizz();
    }

    public function home()
    {

        try {
            $user_id = self::$authObj->getUserId();
            $user = $this->usersObj->getUser($user_id);

            $quizzes = $this->quizzObj->all("user_id=" . $user_id);
            $all_quizzes = [];


            foreach ($quizzes as $quizz) {
                $data = $quizz;

                $questions  = Models::query('SELECT * FROM quizzquestions WHERE quizz_id = ? ', [$quizz->id]);
                $users  = Models::query('SELECT * FROM usersquizz WHERE quizz_id = ? ', [$quizz->id]);

                $data->questions = count($questions);
                $data->users = count($users);

                $all_quizzes[] = $data;
            }
        } catch (\Throwable $th) {
            die($th->getMessage());
        }

        $this->render([
            "template" => "guest",
            "title" => "Home Page",
            "vue" => "quizzer/my-quizzes",

            "isLoggedIn" => self::$authObj->logged(),

            "user" => $user,

            "my_quizzes" => $all_quizzes,
        ]);
    }

    public function questions()
    {

        $user_id = self::$authObj->getUserId();
        $user = $this->usersObj->getUser($user_id);

        $questions = $this->questionsObj->all("user_id=" . $user_id);
        $all_questions = [];

        try {

            foreach ($questions as $question) {
                $data = $question;

                $choices  = Models::query('SELECT * FROM questionschoices WHERE question_id = ? ', [$question->id]);

                $data->choices = count($choices);

                $all_questions[] = $data;
            }
        } catch (\Throwable $th) {
            die($th->getMessage());
        }

        $this->render([
            "template" => "guest",
            "title" => "Home Page",
            "vue" => "quizzer/my-questions",

            "isLoggedIn" => self::$authObj->logged(),

            "user" => $user,

            "my_questions" => $all_questions,
        ]);
    }

    public function create_question()
    {

        $user_id = self::$authObj->getUserId();
        $user = $this->usersObj->getUser($user_id);

        if (isset($_POST['create-question'])) {
            extract($_POST);

            // Création de la question
            $q = App::getDb()->getPDO()->prepare("INSERT INTO questions(description, level, user_id) VALUES(?, ?, ?)");
            $q->execute([$description, $level, $user_id]);

            $question_id = App::getDb()->getPDO()->lastInsertId();

            $choices = json_decode($choices_data);

            // Création des choix
            foreach ($choices as $choice) {
                $q = App::getDb()->getPDO()->prepare("INSERT INTO questionschoices(description, answer, question_id) VALUES(?, ?, ?)");
                $q->execute([$choice->description, $choice->answer, $question_id]);
            }

            header("Location: " . Controller::$host . "my-questions");
            return;
        }

        $this->render([
            "template" => "guest",
            "title" => "Home Page",
            "vue" => "quizzer/create-question",

            "isLoggedIn" => self::$authObj->logged(),

            "user" => $user,

        ]);
    }

    public function update_question($question_id)
    {

        $user_id = self::$authObj->getUserId();
        $user = $this->usersObj->getUser($user_id);

        $question = $this->questionsObj->find($question_id);

        $choices  = Models::query('SELECT description, answer FROM questionschoices WHERE question_id = ? ', [$question_id]);

        $question->choices = $choices;

        if (isset($_POST['update-question'])) {
            extract($_POST);

            // Mise à jour de la question
            $q = App::getDb()->getPDO()->prepare("UPDATE questions SET description = ?, level=? WHERE id=?");
            $q->execute([$description, $level, $question_id]);

            // Formatage de la liste des choix
            $choices = json_decode($choices_data);

            // On vide la liste des choix en vue de la remplir avec de nouvelles données
            $q = App::getDb()->getPDO()->prepare("DELETE FROM questionschoices WHERE question_id=?");
            $q->execute([$question_id]);

            // Création des choix
            foreach ($choices as $choice) {
                $q = App::getDb()->getPDO()->prepare("INSERT INTO questionschoices(description, answer, question_id) VALUES(?, ?, ?)");
                $q->execute([$choice->description, $choice->answer, $question_id]);
            }

            header("Location: " . Controller::$host . "my-questions");
            return;
        }

        $this->render([
            "template" => "guest",
            "title" => "Home Page",
            "vue" => "quizzer/update-question",

            "isLoggedIn" => self::$authObj->logged(),

            "user" => $user,

            "question" => $question,

        ]);
    }

    public function create_quizz()
    {

        $user_id = self::$authObj->getUserId();
        $user = $this->usersObj->getUser($user_id);

        $questions = $this->questionsObj->all('user_id=' . $user_id);
        $all_questions = [];

        try {

            foreach ($questions as $question) {
                $data = $question;

                $choices  = Models::query('SELECT * FROM questionschoices WHERE question_id = ? ', [$question->id]);

                $data->choices = count($choices);

                $all_questions[] = $data;
            }


            if (isset($_POST['create-quizz'])) {
                extract($_POST);

                // Création du quizz
                $q = App::getDb()->getPDO()->prepare("INSERT INTO quizz(title, level, user_id) VALUES(?, ?, ?)");
                $q->execute([$title, $level, $user_id]);

                $quizz_id = App::getDb()->getPDO()->lastInsertId();

                $questions = json_decode($questions_data);

                // Affectations des questions
                foreach ($questions as $question_id) {
                    $q = App::getDb()->getPDO()->prepare("INSERT INTO quizzquestions(question_id, quizz_id) VALUES(?, ?)");
                    $q->execute([$question_id, $quizz_id]);
                }

                header("Location: " . Controller::$host . "my-quizzes");
                return;
            }
        } catch (\Throwable $th) {
            die($th->getMessage());
        }

        $this->render([
            "template" => "guest",
            "title" => "Home Page",
            "vue" => "quizzer/create-quizz",

            "isLoggedIn" => self::$authObj->logged(),

            "user" => $user,
            "questions" => $questions,

        ]);
    }
}
