<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    require_once('../utils/db_connection.php');

    function updateProduct($pdo, $id) {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['product'], $data['category'], $data['price'], $data['quantity'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Please fill all forms']);
            exit;
        }

        try {
            $query = $pdo->prepare("
                UPDATE tbl_products
                SET product = :product,
                    category = :category,
                    price = :price,
                    quantity = :quantity
                WHERE id = :id
            ");

            $query->execute([
                ':product' => $data['product'],
                ':category' => $data['category'],
                ':price' => $data['price'],
                ':quantity' => $data['quantity'],
                ':id' => $id
            ]);

            http_response_code(200);
            echo json_encode(['success' => true, 'message' => 'Product updated successfully!']);

        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_GET['id'])) {
        updateProduct($pdo, $_GET['id']);
    } else {
        echo json_encode(['success' => false, 'message' => 'No product ID or invalid request method']);
    }    