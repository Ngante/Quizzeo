<?php

namespace App\Models;

use App\App;

/**
 * Class using to manage the users
 */
class Users extends Models
{

    /**
     * Method used to get a user using his id
     *
     * @param int $id - id of user
     */
    public static function getUser($id)
    {
        return self::query("SELECT id, pseudo, role, email FROM users WHERE id=?", [$id], true);
    }

    /**
     * Static method used to add a new user in database
     *
     * @param string $full_name - user name
     * @param string $password - password of user
     * @param string $email - email of user
     * @return 
     */
    public static function add($pseudo, $password, $email, $role)
    {
        $q = App::getDb()->getPDO()->prepare("INSERT INTO users (pseudo, password, email, role) VALUES (?, ?, ?, ?)");
        $q->execute([$pseudo, $password, $email, $role]);

        return App::getDb()->getPDO()->lastInsertId();
    }
}
