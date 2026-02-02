<?php
require_once '../models/User.php';
require_once '../models/Lead.php';

class DashboardController {
    public static function index() {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }
        
        $user = User::findById($_SESSION['user_id']);
        
        if ($user['isAdmin']) {
            $leads = Lead::getAll();
        } else {
            $leads = Lead::getByUserId($user['id']);
        }
        
        echo json_encode([
            'user' => $user['firstName'] . ' ' . $user['lastName'],
            'isAdmin' => $user['isAdmin'],
            'leads' => $leads
        ]);
    }
}
?>