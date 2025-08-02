<?php 

namespace Model;

use  Model\Connection;

use PDO;
use PDOException;
use Exception;

class User {
    private $db;

    public function __construct() {
        $this->db = connection::getInstance();
    }

    public function registerUser($name, $email, $password){
        try {
            $sql = 'INSERT INTO usuarios (name, email, password) VALUES (:name, :email, :password)';
            
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $this->db-> prepare($sql);

            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $hashPassword, PDO::PARAM_STR);
        
            return $stmt->execute();

        } catch (PDOException $error) {
            echo "Erro ao executar o comando " . $error->getMessage();
            return false;
        }
    }

    public function getUserByEmail($email)
    {
        try {
            $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":email", $email, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
        }
    }

    public function getUserInfo($id, $user_fullname, $email)
    {
        try {
            $sql = "SELECT name, email FROM usuarios WHERE id = :id AND name = :name AND email = :email";

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":user_fullname", $user_fullname, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            echo "Erro ao buscar informações: " . $error->getMessage();
            return false;
        }
    }
}


?>