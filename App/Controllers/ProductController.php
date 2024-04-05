<?php
namespace App\Controllers;

use App\Helpers\Validation;
use App\Models\Product;
use App\Models\User;
use App\Models\View;
use App\Schema\ProductSchema;
use App\Schema\UserSchema;

class ProductController {

    private $productModel;

    public function __construct() {
        $this->productModel = new Product;
    }

    public function getAllProducts() {
        $productModel = new Product();
        $products = $productModel->getAllProducts();

        return View::renderJSON([
            'status'  => 'success',
            'message' => 'Products found successfully',
            'products'  => $products
        ], 200);

    }

    function getProductById($params) {
        $productModel = new Product();

        if (isset($params["id"]) && $params["id"] > 0) {
            $product = $productModel->getProduct($params["id"]);

            if ($product) {
                return View::renderJSON([
                    'status'  => 'success',
                    'message' => 'Products found successfully',
                    'product'  => $product
                ], 200);

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
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        $validationResult = Validation::validateProductData($request);
        if ($validationResult !== null) {
            return View::renderJSON($validationResult, 400);
        }

        if (count($request) > 0) {
            $product = new ProductSchema(
                0,
                $request["brand"],
                $request["variant"],
                $request["price"],
                $request["pack_size"]
            );

            $result = $this->productModel->createProduct($product);

            if ($result) {
                return View::renderJSON([
                    'status'  => 'success',
                    'message' => 'Product created successfully',
                    'product'  => $product
                ], 201);
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
                        'status'  => 'success',
                        'message' => 'Product updated successfully',
                        'product'  => $result
                    ], 201);
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
                'status'  => 'success',
                'message' => 'Product deleted',
                'product'  => $result
            ], 200);
        } else {
            return View::renderJSON([
                'status'  => 400,
                'message' => "El producto no se ha podido eliminar. Posiblemente tenga datos relacionados.",
            ]);
        }
    }

}