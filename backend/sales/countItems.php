<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *'); 

    require_once '../utils/db_connection.php';

    try {
        $query = $pdo->query("SELECT COUNT(*) AS totalItems FROM tbl_products");
        $result = $query->fetch(PDO::FETCH_ASSOC);
    
        echo json_encode(['totalItems' => $result['totalItems'] ?? 0]);
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }