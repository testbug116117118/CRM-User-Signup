<?php
require_once '../models/User.php';

class AuthController {
    public static function register() {
        if (empty($_POST['email']) || empty($_POST['password'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Email and password required']);
            return;
        }
        
        $hashedPassword = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $_POST['password'] = $hashedPassword;
        
        $userId = User::create($_POST);
        
        if ($userId) {
            echo json_encode(['success' => true, 'userId' => $userId]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Registration failed']);
        }
    }
    
    public static function login() {
        $user = User::findByEmail($_POST['email']);
        
        if ($user && password_verify($_POST['password'], $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['isAdmin'] = $user['isAdmin'];
            echo json_encode(['success' => true]);
        } else {
            http_response_code(401);
            echo json_encode(['error' => 'Invalid credentials']);
        }
    }
}
?>