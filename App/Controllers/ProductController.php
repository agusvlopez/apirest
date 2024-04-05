<?php
namespace App\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\View;
use App\Schema\ProductSchema;
use App\Schema\UserSchema;

class ProductController {

    public function getAllProducts() {
        $productModel = new Product();
        $products = $productModel->getAllProducts();

        return View::renderJSON([
            'status'  => "success",
            'message' => "Productos encontrados con éxito!",
            'users'  => $products
        ]);
        //echo json_encode($users);
    }

    function getProductById($params) {
        $productModel = new Product();

        if (isset($params["id"]) && $params["id"] > 0) {
            $product = $productModel->getProduct($params["id"]);

            if ($product) {
                return View::renderJSON([
                    'status'  => 200,
                    'message' => "Producto encontrado con éxito!",
                    'user'  => $product
                ]);

            } else {
                return View::renderJSON([
                    'status'  => 404,
                    'message' => "Usuario no encontrado.",
                ]);
            }
        } else {
            return View::renderJSON([
                'status'  => 400,
                'message' => "Falta ingresar el Id del usuario.",
            ]);
        }
    }

    function createProduct() {
        $productModel = new Product();
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        if (count($request) > 0) {
            $product = new ProductSchema(
                0,
                $request["brand"],
                $request["variant"],
                $request["price"],
                $request["pack_size"]
            );

            //echo json_encode($request);

            $result = $productModel->createProduct($product);
            if ($result) {
                return View::renderJSON([
                    'status'  => 201,
                    'message' => "Usuario creado con éxito.",
                ]);
            } else {
                return View::renderJSON([
                    'status'  => 500,
                    'message' => "Se produjo un error en el servidor.",
                ]);
            }
        } else {
            return View::renderJSON([
                'status'  => 400,
                'message' => "No se recibieron los datos correspondientes para crear el usuario.",
            ]);
        }  
    }

    function updateProduct($params) {
        $productModel = new Product();
        if (isset($params["id"]) && $params["id"] > 0) {
            $postdata = file_get_contents("php://input");
            
            $request = json_decode($postdata, true);                       

            if (count($request) >= 0) {
                $product = $productModel->getProduct($params["id"]);
                
                $product = new ProductSchema(
                    $params["id"],
                    $request["brand"],
                    $request["variant"],
                    $request["price"],
                    $request["pack_size"]
                );
                $result = $productModel->updateProduct($product, $params["id"]);
                
                if ($result) {
                    return View::renderJSON([
                        'status'  => 200,
                        'message' => "Usuario actualizado.",
                    ]);
                } else {
                    return View::renderJSON([
                        'status'  => 500,
                        'message' => "Ocurrió un error al crear el usuario.",
                    ]);
                }
            } else {
                return View::renderJSON([
                    'status'  => 400,
                    'message' => "No se recibieron los datos correspondientes para actualizar el usuario.",
                ]);
            }
        } else {
            return View::renderJSON([
                'status'  => 400,
                'message' => "Falta ingresar el id del usuario.",
            ]);
        }
    }

    function deleteProduct($params) {
        $productModel = new Product();
        $result = $productModel->deleteProduct($params["id"]);
        if ($result) {
            return View::renderJSON([
                'status'  => 200,
                'message' => "Producto eliminado.",
            ]);
        } else {
            return View::renderJSON([
                'status'  => 400,
                'message' => "El producto no se ha podido eliminar. Posiblemente tenga datos relacionados.",
            ]);
        }
    }

    // Otros métodos para manejar otras operaciones CRUD
}