<?php 

namespace Controller;

use Model\User;
use Exception;

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function createUser($name, $email, $password) {
        if (empty($name) or empty($email) or empty($password)) {
            return false;
        }

        return $this->userModel->registerUser($name, $email, $password);
    }

    public function checkUserByEmail($email) {
        return $this->userModel->getUserByEmail($email);
    }

    public function login($email, $password) {
        $user = $this->userModel->getUserByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            return $user; // Retorne o array do usuário
        }
        return false;
    }

    public function isLoggedIn(){
        return isset($_SESSION['usuario_id']);
    }

    public function getUserData($id, $name, $email) {
        return $this->userModel->getUserInfo($id, $name, $email);
    }
}

?>