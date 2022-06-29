<?php

namespace App\Auth;

use App\Database\Database;
use App\Models\AuthTokens;
use App\Models\Users;

/**
 * This class manage the authentication of different users
 */
class DBAuth
{

    /**
     * Instance of the database to use
     *
     * @var Database
     */
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    /**
     * Method which permit to connect a user to the database and return a boolean 
     *      if the connection was making or not
     * 
     * @param string $email
     * @param string $password
     * @return boolean
     */
    public function login($email, $password)
    {
        $user = $this->db->prepare(
            "SELECT id, password FROM users
            WHERE (email = ? AND password = ?)",
            [$email, $password],
            null,
            true
        );

        // If the user is found, we registry the "Id" in session
        if ($user) {


            // when we connect the user, we registry his token.
            // To assure the oneness of token, we take the timestamp of user connection to database,
            // we concat with the random number between 0 and 9 and we ache it (sha1);
            $token = sha1(time() . rand(0, 9));

            // If the user had been already connect, we update the token
            if (AuthTokens::findByUserID($user->id)) {
                $q = $this->db->getPDO()->prepare("UPDATE authtokens SET user_tokens = ? WHERE user_id = ?");
                $q->execute([$token, $user->id]);
            } else { // we insert the token in database
                $q = $this->db->getPDO()->prepare("INSERT INTO authtokens (user_id, user_tokens) VALUES (?, ?)");
                $q->execute([$user->id, $token]);
            }

            $_SESSION['quizzeo_auth_token'] = $token; // We add the token of connected user in session
            $_SESSION['quizzeo_user_id'] = $user->id; // We add the id of connected user in session

            return true;
        }
        return false;
    }

    /**
     * Method which return the Id of connected user
     *
     * @return int (Id) if the user is connected
     * @return false otherwise
     */
    public static function getUserId()
    {
        if (isset($_SESSION['quizzeo_user_id'])) {
            return intval($_SESSION['quizzeo_user_id']);
        }

        return false;
    }

    /**
     * Method which return the token of connected user
     *
     * @return string (The token) if the user is connected
     * @return false otherwise
     */
    public static function getUserToken()
    {
        if (isset($_SESSION['quizzeo_auth_token'])) {
            return $_SESSION['quizzeo_auth_token'];
        }

        return false;
    }


    /**
     * Method which return all information about a user using his Id
     * 
     * @return Users
     */
    public static function getCurrentUser()
    {
        return Users::getUser(self::getUserId());
    }

    /**
     * Logout of an user! We destroy the current session
     */
    public function logout()
    {
        session_destroy();
    }

    /**
     * Method to verify if a user is connect 😎
     *
     * @return boolean
     */
    public function logged()
    {
        return (isset($_SESSION['quizzeo_user_id']));
    }
}
