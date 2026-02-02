<?php
require_once '../config/database.php';
require_once '../controllers/AuthController.php';
require_once '../controllers/DashboardController.php';

session_start();

$request = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

switch ($request) {
    case '/register':
        if ($method === 'POST') {
            AuthController::register();
        }
        break;
    case '/login':
        if ($method === 'POST') {
            AuthController::login();
        }
        break;
    case '/dashboard':
        DashboardController::index();
        break;
    default:
        http_response_code(404);
        echo 'Not Found';
}
?>
