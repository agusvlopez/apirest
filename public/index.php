<?php

    date_default_timezone_set('America/Argentina/Buenos_Aires');

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');

    require_once __DIR__ . '/../vendor/autoload.php';

    use CoffeeCode\Router\Router;

    use App\Helpers\Env;
    use App\Controllers\ErrorController;
    use App\Controllers\UserController;
    

    try {

        $router = new Router(Env::get('APP_URL'));

        /**
         * Controllers
         */
        $router->namespace("App\Controllers")->group(null);

        /**
         * Create a new user:
         */
        $router->post("/users", "UserController:createUser");

        /**
         * Get user by ID:
         */
        $router->get("/users/{id}", "UserController:getUserById");

        /**
         * Get all users:
         */
        $router->get("/users", "UserController:getAllUsers");

        /**
         * Get all users using limit:
         */
        $router->get("/users/limit/{limit}", "UserController:readAll");

        /**
         * Update user:
         */
        $router->put("/users/{id}", "UserController:updateUser");

        /**
         * Delete user:
         */
         $router->delete("/users/{id}", "UserController:deleteUser");

        $router->dispatch();

        if ($router->error()) {
            throw new Exception($router->error());
        }
    
    } catch (Exception $e) {
        return ErrorController::getErrorMessage($e);
    }