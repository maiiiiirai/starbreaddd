<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *'); 

    require_once '../utils/db_connection.php';

    try {
        $query = $pdo->query("SELECT SUM(total_price) AS totalSales FROM tbl_sales");
        $result = $query->fetch(PDO::FETCH_ASSOC);

        echo json_encode(['totalSales' => $result['totalSales'] ?? 0]);
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }