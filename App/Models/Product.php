<?php
namespace App\Models;

use App\Helpers\Env;
use PDO;
use PDOException;

class Product {
    private $db;

    public function __construct() {
        $this->db = new PDO("mysql:host=". Env::get('DB_HOST') .";dbname=" . Env::get('DB_NAME'), Env::get('DB_USER'), Env::get('DB_PASS'));
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getAllProducts() {
        $stmt = $this->db->query("SELECT * FROM products");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProduct($id) {
        try {
            $stmt = $this->db->query("SELECT * FROM products WHERE id = $id");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo "Error. " . $e->getMessage();
            exit("Error. " . $e->getMessage());
        }
    }

    function createProduct($product) {
        
        try {
            $stmt = $this->db->prepare("INSERT INTO products (brand, variant, price, pack_size) VALUES (:brand, :variant, :price, :pack_size)");
            $stmt->bindParam(':brand', $product->brand);
            $stmt->bindParam(':variant', $product->variant);
            $stmt->bindParam(':price', $product->price);
            $stmt->bindParam(':pack_size', $product->pack_size);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // Manejar el error de alguna manera, como registrar un mensaje de error
            error_log("Error al crear usuario: " . $e->getMessage());
            return false;
        }
    }

    function updateProduct($product, $id) {
        
        try {
            $stmt = $this->db->prepare("UPDATE products SET brand = :brand, variant = :variant, price = :price, pack_size = :pack_size WHERE id = :id");

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':brand', $product->brand);
            $stmt->bindParam(':variant', $product->variant);
            $stmt->bindParam(':price', $product->price);
            $stmt->bindParam(':pack_size', $product->pack_size);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            // Manejar el error de alguna manera, como registrar un mensaje de error
            error_log("Error al actualizar usuario: " . $e->getMessage());
            return false;
        }
    }

    function deleteProduct($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM products WHERE id = :id");
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