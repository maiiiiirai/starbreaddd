<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');

    require_once '../utils/db_connection.php';

    try {
        $query = $pdo->query("SELECT id, product FROM tbl_products ORDER BY product ASC");
        $products = $query->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($products);
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }