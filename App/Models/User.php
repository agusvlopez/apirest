<?php
namespace App\Models;

use PDO;
use PDOException;

class User {
    private $db;

    public function __construct() {
        $this->db = new PDO("mysql:host=". 'localhost' .";dbname=" . 'api_php', 'root', '');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getAllUsers() {
        $stmt = $this->db->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUser($id) {
        try {
            $stmt = $this->db->query("SELECT * FROM users WHERE id = $id");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo "Error. " . $e->getMessage();
            exit("Error. " . $e->getMessage());
        }
    }

    function createUser($user) {
        $passHashed = password_hash($user->pass, PASSWORD_DEFAULT);
        try {
            $stmt = $this->db->prepare("INSERT INTO users (name, pass) VALUES (:name, :pass)");
            $stmt->bindParam(':name', $user->name);
            $stmt->bindParam(':pass', $passHashed);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // Manejar el error de alguna manera, como registrar un mensaje de error
            error_log("Error al crear usuario: " . $e->getMessage());
            return false;
        }
    }

    function updateUser($user, $id) {
        $passHashed = password_hash($user->pass, PASSWORD_DEFAULT);
        try {
            $stmt = $this->db->prepare("UPDATE users SET name = :name, pass = :pass WHERE id = :id");

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $user->name);
            $stmt->bindParam(':pass', $passHashed);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            // Manejar el error de alguna manera, como registrar un mensaje de error
            error_log("Error al actualizar usuario: " . $e->getMessage());
            return false;
        }
    }

    function deleteUser($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            return true;

        } catch(PDOException $e) {
            //throw new Exception("No se ha podido conectar con la base de datos", 1);
            error_log("Error al eliminar el usuario: " . $e->getMessage());
            return false;
        }
        
    }
    
    // Otros métodos CRUD según sea necesario
}