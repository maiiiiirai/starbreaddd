<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    require_once('../utils/db_connection.php');

    function getProduct($pdo, $id) {
        try {
            $query = $pdo->prepare("SELECT * FROM tbl_products WHERE id = :id");
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();

            $product = $query->fetch(PDO::FETCH_ASSOC);
            if ($product) {
                echo json_encode($product);
            } else {
                echo json_encode(['success' => false, 'message' => 'Product not found']);
            }
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    if (isset($_GET['id'])) {
        getProduct($pdo, $_GET['id']);
    } else {
        echo json_encode(['success' => false, 'message' => 'No product ID provided']);
    }