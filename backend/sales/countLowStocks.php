<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *'); 

    require_once '../utils/db_connection.php';

    try {
        $query = $pdo->query("SELECT product, quantity FROM tbl_products WHERE quantity <= 5");
        $lowStock = $query->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(['lowStock' => $lowStock, 'count' => count($lowStock)]);
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }