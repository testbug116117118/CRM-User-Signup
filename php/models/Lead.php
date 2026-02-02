<?php
require_once '../config/database.php';

class Lead {
    public static function getAll() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT * FROM leads ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function getByUserId($userId) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM leads WHERE assigned_to = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function create($data) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare(
            "INSERT INTO leads (company_name, contact_email, status, assigned_to) 
             VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([
            $data['company_name'],
            $data['contact_email'],
            $data['status'] ?? 'new',
            $data['assigned_to']
        ]);
        return $db->lastInsertId();
    }
}
?>