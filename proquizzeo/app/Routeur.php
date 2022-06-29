<?php

namespace App;

use App\AJAX\AJAX;
use App\Auth\DBAuth;
use App\Controller\AuthController;
use App\Controller\Controller;
use App\Controller\PagesController;
use App\Controller\QuizzController;
use App\Controller\QuizzerDashboardController;
use App\Controller\UserDashboardController;
use App\Models\Questions;
use App\Models\Quizz;

/**
 * Class for url path management and views choosing
 * The configuration is make in file .htaccess for 
 * URL Rewriting
 */
class Routeur
{

    /**
     * Content the name of the current page (the value of $_GET['page'])
     *
     * @var string
     */
    private $page;

    /**
     * Table which content the different possibles road that the user can access
     *
     * @var array
     */
    private $road = [
        "login" => "login",
        "register" => "register",

        "home" => "home",
        "questions" => "questions",
        "quizz" => "quizz",

        "dashboard" => "dashboard",

        "my-quizzes" => "my-quizzes",
        "create-quizz" => "create-quizz",
        "update-quizz" => "update-quizz",

        "my-questions" => "my-questions",
        "create-question" => "create-question",
        "update-question" => "update-question",

        "ajax" => ["submitQuizz"],

        "logout" => "logout",
    ];

    public function __construct($page)
    {
        $this->page = $page;
    }

    public function renderController()
    {
        $pages = explode('/', $this->page);
        $app = new App();
        $authObj = new DBAuth(App::getDb());

        // If the road exist in our road table
        if (key_exists($pages[0], $this->road)) {

            if ($pages[0] == "home") {
                $pagesController = new PagesController();
                $pagesController->home();
                return;
            }

            if (!$authObj->logged()) {
                if ($pages[0] === "login" || $pages[0] === 'register') {
                    $authController = new AuthController();
                    $authController->{$pages[0]}();
                    return;
                }

                header('Location: ' . Controller::$host . 'login');
                exit();
            } elseif ($authObj->logged()) { // there is a user online
                if ($pages[0] == "logout") {
                    $authObj->logout();
                    header("Location: " . Controller::$host . "home");
                    exit(1);
                } elseif ($pages[0] == "quizz") {
                    if (!empty($pages[1])) {
                        $quizzObj = new Quizz();
                        if ($quizzObj->find($pages[1])) {
                            $quizzController = new QuizzController();
                            $quizzController->quizz($pages[1]);
                            return;
                        } else {
                            $app->notFound();
                        }
                        return;
                    } else {
                        $quizzController = new QuizzController();
                        $quizzController->home();
                        return;
                    }
                } elseif ($pages[0] == "questions") {
                    $quizzController = new QuizzController();
                    $quizzController->home();
                    return;
                } elseif ($pages[0] == "dashboard") {
                    $userDashboardController = new UserDashboardController();
                    $userDashboardController->home();
                    return;
                } elseif ($authObj->getCurrentUser()->role === 'QUIZZER') {
                    if ($pages[0] == "my-quizzes") {
                        $quizzDashboardController = new QuizzerDashboardController();
                        $quizzDashboardController->home();
                        return;
                    } elseif ($pages[0] == "my-questions") {
                        $quizzDashboardController = new QuizzerDashboardController();
                        $quizzDashboardController->questions();
                        return;
                    } elseif ($pages[0] == "create-question") {
                        $quizzDashboardController = new QuizzerDashboardController();
                        $quizzDashboardController->create_question();
                        return;
                    } elseif ($pages[0] == "update-question") {
                        $quizzDashboardController = new QuizzerDashboardController();
                        if (!empty($pages[1])) {
                            $questionsObj = new Questions();
                            if ($questionsObj->find($pages[1])) {
                                $quizzDashboardController->update_question($pages[1]);
                                return;
                            }
                        }
                        $app->notFound();
                    } elseif ($pages[0] == "create-quizz") {
                        $quizzDashboardController = new QuizzerDashboardController();
                        $quizzDashboardController->create_quizz();
                        return;
                    } elseif ($pages[0] == "update-quizz") {
                        $quizzDashboardController = new QuizzerDashboardController();
                        if (!empty($pages[1])) {
                            $quizzObj = new Quizz();
                            if ($quizzObj->find($pages[1])) {
                                $quizzDashboardController->update_question($pages[1]);
                                return;
                            }
                        }
                        $app->notFound();
                    }
                } elseif ($pages[0] == "ajax") {
                    $ajax = new AJAX($_POST);
                    if (method_exists($ajax, $pages[1])) {
                        try {
                            $ajax->{$pages[1]}();
                        } catch (\Throwable $th) {
                            die($th->getMessage());
                        }
                    } else {
                        $app->notFound();
                    }
                } else {
                    $app->notFound();
                }
            }
        } else {
            $app->notFound();
        }
    }
}
