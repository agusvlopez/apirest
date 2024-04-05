<?php
namespace App\Helpers;

class Validation {
    public static function validateUserData($data) {
        // Validación de datos de usuario...
        $expectedSchema = [
            'name' => 'string',
            'pass' => 'string',
        ];

        $errors = [];
        foreach ($expectedSchema as $key => $type) {
            if (!isset($data[$key])) {
                $errors[] = "The $key field is missing from the request body";
            } elseif (gettype($data[$key]) !== $type) {
                $errors[] = "The $key field must be of type $type";
            }
        }

        if (!empty($errors)) {
            http_response_code(400);
            return [
                'status'  => 400,
                'message' => "The request body doesn't match with the schema:",
                'errors' => $errors
            ];
        }

        return null;
    }

    public static function validateProductData($data) {

        $expectedSchema = [
            'brand_id' => 'integer',
            'variant' => 'string',
            'price' => 'integer',
            'pack_size' => 'integer'
        ];

        $errors = [];
        foreach ($expectedSchema as $key => $type) {
            if (!isset($data[$key])) {
                $errors[] = "The $key field is missing from the request body";
            } elseif (gettype($data[$key]) !== $type) {
                $errors[] = "The $key field must be of type $type";
            }
        }

        if (!empty($errors)) {
            http_response_code(400);
            return [
                'status'  => 400,
                'message' => "The request body doesn't match with the schema:",
                'errors' => $errors
            ];

        }

        return null;
    }
}
