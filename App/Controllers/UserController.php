<?php
namespace App\Controllers;

use App\Helpers\Validation;
use App\Models\User;
use App\Models\View;
use App\Schema\UserSchema;

class UserController {

    private $userModel;

    public function __construct() {
        $this->userModel = new User;
    }

    public function getAllUsers() {
        $userModel = new User();
        $users = $userModel->getAllUsers();

        return View::renderJSON([
            'status'  => 'success',
            'message' => 'Users found successfully',
            'users'  => $users
        ], 200);
    }

    function getUserById($params) {
        $userModel = new User();
        //var_dump($params);
        if (isset($params["id"]) && $params["id"] > 0) {
            $user = $userModel->getUser($params["id"]);
            // var_dump($disco);
            if ($user) {
                return View::renderJSON([
                    'status'  => 'success',
                    'message' => 'User found successfully',
                    'user'  => $user
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

    function createUser() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        $validationResult = Validation::validateUserData($request);
        if ($validationResult !== null) {
            return View::renderJSON($validationResult, 400);
        }

        if (count($request) > 0) {
            $user = new UserSchema(
                0,
                $request["name"],
                $request["pass"]

            );

            $result = $this->userModel->createUser($user);

            if ($result) {
                return View::renderJSON([
                    'status'  => 'success',
                    'message' => 'User created successfully',
                    'user'  => $result
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

    function updateUser($params) {
        $userModel = new User();
        if (isset($params["id"]) && $params["id"] > 0) {
            $postdata = file_get_contents("php://input");
            //var_dump($postdata);
            $request = json_decode($postdata, true);
            // var_dump($request);                        

            if (count($request) >= 0) {
                $user = $userModel->getUser($params["id"]);
                
                $user = new UserSchema(
                    $params["id"],
                    $request["name"],
                    $request["pass"],
                );
                $result = $userModel->updateUser($user, $params["id"]);
                
                if ($result) {
                    return View::renderJSON([
                        'status'  => 'success',
                        'message' => 'User updated successfully',
                        'user'  => $result
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

    function deleteUser($params) {
        $userModel = new User();
        $result = $userModel->deleteUser($params["id"]);
        if ($result) {
            return View::renderJSON([
                'status'  => 'success',
                'message' => 'User deleted',
                'user'  => $result
            ], 200);
        } else {
            return View::renderJSON([
                'status'  => 400,
                'message' => "El disco no se ha podido eliminar. Posiblemente tenga datos relacionados.",
            ]);
        }
    }

    // Otros métodos para manejar otras operaciones CRUD
}