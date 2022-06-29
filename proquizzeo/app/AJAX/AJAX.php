<?php

namespace App\AJAX;

use App\App;
use App\Auth\DBAuth;
use App\Models\AuthTokens;
use App\Models\Models;
use PDOException;

define('USER_ID', "user_id");


class AJAX
{
    /**
     * Data in request parameter
     */
    private $data;
    /**
     * string for user_id
     */
    private $string_user_id = 'user_id';
    /**
     * error of Forbidden
     */
    private $forbidden = "Forbidden action !";
    /**
     * error of Unknown user
     */
    private $unknown_user = "Forbidden action !";

    public static $root; // The root path of the project
    public static $host; // The domain name of the project
    public static $assetsPath; // The assets folder path

    /**
     * The principal constructor that we will use to make asynchronous request
     *
     * @param array $data
     */
    public function __construct($data = [])
    {
        self::$root = $_SERVER['DOCUMENT_ROOT'] . '/';
        self::$host = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . '/';
        self::$assetsPath = self::$host . "public/assets/";
        $this->data = $data;
    }

    public function submitQuizz()
    {
        extract($this->data);
        if (Models::not_empty(['user_id', 'quizz_datas'])) {
            $bdAuth = new DBAuth(App::getDb());

            // token is use to know if the it is the current user who is adding publication
            $tokens = AuthTokens::all($this->string_user_id . " = " . $user_id);
            // if the user has a token
            if ($tokens) {
                $token = $tokens[0]->user_tokens;

                // if the token is for the current user
                if ($token == $bdAuth->getUserToken()) {

                    $data = json_decode($quizz_datas);
                    $score_total = 0;
                    $best_total = 0;

                    foreach ($data as $question) {
                        $score = 0;
                        foreach ($question->choices as $choice) {
                            if (in_array($choice, $question->correct)) $score++;
                            else $score--;
                        }

                        foreach ($question->correct as $correct) {
                            $best_total++;
                        }

                        if ($score > 0) $score_total += $score;
                    }

                    $score_str = $score_total . " / " . $best_total;

                    try {
                        $q = App::getDb()->getPDO()->prepare("INSERT INTO usersquizz(quizz_id, user_id, score) VALUES(?,?,?)");
                        $q = $q->execute([intval($quizz_id), intval($user_id), $score_str]);
                    } catch (PDOException $e) {
                        die($e->getMessage());
                    }

                    $result = [
                        "success" => true,
                        "score" => $score_total,
                        "total" => $best_total
                    ];
                } else {
                    $result = ["success" => false, "error" => $this->forbidden];
                }
            } else {
                $result = ["success" => false, "error" => $this->unknown_user];
            }
        } else {
            $result = ["success" => false, "error" => "Can't post an empty test 🤦‍♂️🤦‍♂️"];
        }



        $this->render($result);
    }

    /**
     * Method which permit to render the Ajax result request. in JSON
     * 
     * @param array $data
     */
    public function render($data)
    {
        header("Content-Type: application/json");
        echo json_encode($data);
    }
}
