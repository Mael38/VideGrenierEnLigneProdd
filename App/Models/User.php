<?php

namespace App\Models;

use App\Utility\Hash;
use Core\Model;
use App\Core;
use Exception;
use App\Utility;

/**
 * User Model:
 */
class User extends Model {

    /**
     * Crée un utilisateur
     */
    public static function createUser($data) {
        $db = static::getDB();

        $stmt = $db->prepare('INSERT INTO users(username, email, password, salt) VALUES (:username, :email, :password,:salt)');

        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->bindParam(':salt', $data['salt']);

        $stmt->execute();

        return $db->lastInsertId();
    }

    public static function getByLogin($login)
    {
        $db = static::getDB();

        $stmt = $db->prepare("
            SELECT * FROM users WHERE ( users.email = :email) LIMIT 1
        ");

        $stmt->bindParam(':email', $login);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }


    /**
     * ?
     * @access public
     * @return string|boolean
     * @throws Exception
     */
    public static function login() {
        $db = static::getDB();

        $stmt = $db->prepare('SELECT * FROM articles WHERE articles.id = ? LIMIT 1');

        $stmt->execute([$id]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Récupérer un utilisateur par son ID
     */
    public static function getById($id)
    {
        $db = static::getDB();

        $stmt = $db->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Sauvegarder un token "remember me"
     */
    public static function saveRememberToken($userId, $hashedToken, $expiry)
    {
        $db = static::getDB();

        // Créer la table remember_tokens si elle n'existe pas
        $createTable = "
            CREATE TABLE IF NOT EXISTS remember_tokens (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                token VARCHAR(255) NOT NULL,
                expiry INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                UNIQUE KEY unique_user_token (user_id)
            )
        ";
        $db->exec($createTable);

        // Supprimer les anciens tokens pour cet utilisateur
        $deleteStmt = $db->prepare("DELETE FROM remember_tokens WHERE user_id = :user_id");
        $deleteStmt->bindParam(':user_id', $userId);
        $deleteStmt->execute();

        // Insérer le nouveau token
        $stmt = $db->prepare("
            INSERT INTO remember_tokens (user_id, token, expiry) 
            VALUES (:user_id, :token, :expiry)
        ");
        
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':token', $hashedToken);
        $stmt->bindParam(':expiry', $expiry);

        return $stmt->execute();
    }

    /**
     * Récupérer un token "remember me"
     */
    public static function getRememberToken($userId)
    {
        $db = static::getDB();

        $stmt = $db->prepare("
            SELECT token, expiry FROM remember_tokens 
            WHERE user_id = :user_id AND expiry > :current_time 
            LIMIT 1
        ");
        
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':current_time', time());
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Supprimer les tokens expirés
     */
    public static function cleanExpiredTokens()
    {
        $db = static::getDB();

        $stmt = $db->prepare("DELETE FROM remember_tokens WHERE expiry < :current_time");
        $stmt->bindParam(':current_time', time());
        
        return $stmt->execute();
    }

    /**
     * Supprimer tous les tokens pour un utilisateur spécifique
     */
    public static function cleanRememberTokensForUser($userId)
    {
        $db = static::getDB();

        $stmt = $db->prepare("DELETE FROM remember_tokens WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId);
        
        return $stmt->execute();
    }

}
