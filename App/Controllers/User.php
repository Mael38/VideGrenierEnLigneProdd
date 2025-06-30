<?php

namespace App\Controllers;

use App\Config;
use App\Model\UserRegister;
use App\Models\Articles;
use App\Utility\Hash;
use App\Utility\Session;
use \Core\View;
use Exception;
use http\Env\Request;
use http\Exception\InvalidArgumentException;

/**
 * User controller
 */
class User extends \Core\Controller
{

    /**
     * Affiche la page de login
     */
    public function loginAction()
    {
        if(isset($_POST['submit'])){
            $f = $_POST;

            // TODO: Validation

            $this->login($f);

            // Si login OK, redirige vers le compte
            header('Location: /account');
        }

        View::renderTemplate('User/login.html');
    }

    /**
     * Page de création de compte
     */
    public function registerAction()
    {
        if(isset($_POST['submit'])){
            $f = $_POST;

            if($f['password'] !== $f['password-check']){
                // TODO: Gestion d'erreur côté utilisateur
                View::renderTemplate('User/register.html', [
                    'error' => 'Les mots de passe ne correspondent pas'
                ]);
                return;
            }

            // validation

            $userID = $this->register($f);
            
            if ($userID) {
                // Connecter automatiquement l'utilisateur après inscription
                $loginSuccess = $this->login($f);
                
                if ($loginSuccess) {
                    // Rediriger vers le compte utilisateur
                    header('Location: /account');
                    return;
                }
            }
            
            // En cas d'erreur, afficher le formulaire avec un message d'erreur
            View::renderTemplate('User/register.html', [
                'error' => 'Erreur lors de l\'inscription. Veuillez réessayer.'
            ]);
            return;
        }

        View::renderTemplate('User/register.html');
    }

    /**
     * Affiche la page du compte
     */
    public function accountAction()
    {
        $articles = Articles::getByUser($_SESSION['user']['id']);

        View::renderTemplate('User/account.html', [
            'articles' => $articles
        ]);
    }

    /*
     * Fonction privée pour enregister un utilisateur
     */
    private function register($data)
    {
        try {
            // Generate a salt, which will be applied to the during the password
            // hashing process.
            $salt = Hash::generateSalt(32);

            $userID = \App\Models\User::createUser([
                "email" => $data['email'],
                "username" => $data['username'],
                "password" => Hash::generate($data['password'], $salt),
                "salt" => $salt
            ]);

            return $userID;

        } catch (Exception $ex) {
            // TODO : Set flash if error : utiliser la fonction en dessous
            /* Utility\Flash::danger($ex->getMessage());*/
        }
    }

    private function login($data){
        try {
            if(!isset($data['email'])){
                throw new Exception('Email manquant');
            }

            $user = \App\Models\User::getByLogin($data['email']);
            
            if (!$user) {
                return false;
            }

            if (Hash::generate($data['password'], $user['salt']) !== $user['password']) {
                return false;
            }

            // Créer la session utilisateur
            $_SESSION['user'] = array(
                'id' => $user['id'],
                'username' => $user['username'],
            );

            // Créer un cookie "se souvenir de moi" si l'option est cochée
            if (isset($data['remember_me']) && $data['remember_me'] == '1') {
                $this->createRememberMeCookie($user['id']);
            }

            return true;

        } catch (Exception $ex) {
            // TODO : Set flash if error
            /* Utility\Flash::danger($ex->getMessage());*/
            error_log("Erreur de login: " . $ex->getMessage());
            return false;
        }
    }

    /**
     * Créer un cookie "se souvenir de moi" sécurisé
     */
    private function createRememberMeCookie($userId) {
        // Générer un token aléatoire sécurisé
        $token = bin2hex(random_bytes(32));
        
        // Hasher le token pour le stocker en base
        $hashedToken = hash('sha256', $token);
        
        // Durée de vie du cookie (30 jours)
        $expiry = time() + (30 * 24 * 60 * 60);
        
        // Stocker le token hashé en base de données avec l'ID utilisateur et l'expiration
        \App\Models\User::saveRememberToken($userId, $hashedToken, $expiry);
        
        // Créer le cookie sécurisé
        setcookie(
            'remember_me', 
            $userId . ':' . $token, 
            $expiry, 
            '/', 
            '', 
            isset($_SERVER['HTTPS']), // Secure flag si HTTPS
            true // HttpOnly flag
        );
    }

    /**
     * Vérifier et traiter un cookie "se souvenir de moi"
     */
    public function checkRememberMeCookie() {
        if (!isset($_COOKIE['remember_me'])) {
            return false;
        }

        $cookieParts = explode(':', $_COOKIE['remember_me'], 2);
        if (count($cookieParts) !== 2) {
            $this->clearRememberMeCookie();
            return false;
        }

        $userId = $cookieParts[0];
        $token = $cookieParts[1];
        $hashedToken = hash('sha256', $token);

        // Vérifier le token en base
        $storedToken = \App\Models\User::getRememberToken($userId);
        
        if (!$storedToken || $storedToken['token'] !== $hashedToken || $storedToken['expiry'] < time()) {
            $this->clearRememberMeCookie();
            return false;
        }

        // Token valide, connecter l'utilisateur
        $user = \App\Models\User::getById($userId);
        if ($user) {
            $_SESSION['user'] = array(
                'id' => $user['id'],
                'username' => $user['username'],
            );
            return true;
        }

        return false;
    }

    /**
     * Supprimer le cookie "se souvenir de moi"
     */
    private function clearRememberMeCookie() {
        setcookie('remember_me', '', time() - 3600, '/');
        unset($_COOKIE['remember_me']);
    }


    /**
     * Logout: Delete cookie and session. Returns true if everything is okay,
     * otherwise turns false.
     * @access public
     * @return boolean
     * @since 1.0.2
     */
    public function logoutAction() {

        // Supprimer le token "remember me" de la base de données si l'utilisateur est connecté
        if (isset($_SESSION['user']['id'])) {
            \App\Models\User::cleanRememberTokensForUser($_SESSION['user']['id']);
        }

        // Supprimer le cookie "remember me"
        $this->clearRememberMeCookie();

        // Destroy all data registered to the session.
        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();

        header ("Location: /");

        return true;
    }

}
