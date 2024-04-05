<?php

namespace App\Models;

class View {

    public static function renderJSON($content, int $statusCode = 200, string $title = "data")
    {
        http_response_code($statusCode);
        header("Content-Type: application/json");
        echo json_encode([$title => $content], JSON_PRETTY_PRINT);
    }
}