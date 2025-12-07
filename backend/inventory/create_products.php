<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *'); 
    require_once('../utils/db_connection.php');

    function createProduct($pdo) {
        $data = json_decode(file_get_contents('php://input'), true);
        try {
            if (!isset($data['product']) || !isset($data['category']) || !isset($data['price']) || !isset($data['quantity'])) {
                http_response_code(400);
                echo json_encode([ 'success' => false, 'message' => 'Please fill all forms']);
                exit;
            }
        
            $query = $pdo->prepare("INSERT INTO tbl_products(product,  category, price, quantity) VALUES (:product, :category, :price, :quantity)");
            $query->execute([
                ':product' => $data['product'],
                ':category' => $data['category'],
                ':price' => $data['price'],
                ':quantity' => $data['quantity'],
            ]);

            http_response_code(201);
            echo json_encode([
                'success' => true, 
                'message' => 'Products added successfully!'
            ]);

        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false, 
                'error' => $e->getMessage(), 
                'message' => 'Internal Server Error'
            ]);
        }
    }
    createProduct($pdo);