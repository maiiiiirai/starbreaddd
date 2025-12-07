<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Content-Type');

    require_once '../utils/db_connection.php';

    try {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['product_id']) || !isset($data['quantity_sold'])) {
            echo json_encode(['success' => false, 'message' => 'Missing fields']);
            exit;
        }

        $productId = (int)$data['product_id'];
        $quantitySold = (int)$data['quantity_sold'];

        // gwet all oprducts in the inventory (tbl_products)
        $query = $pdo->prepare("SELECT price, quantity FROM tbl_products WHERE id = ?");
        $query->execute([$productId]);
        $product = $query->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            echo json_encode(['success' => false, 'message' => 'Product not found']);
            exit;
        }

        if ($quantitySold > $product['quantity']) {
            echo json_encode(['success' => false, 'message' => 'Not enough stock']);
            exit;
        }

        $totalPrice = $quantitySold * $product['price'];

        // subtract the quantity purchased to the total quantity of the product
        $update = $pdo->prepare("UPDATE tbl_products SET quantity = quantity - ? WHERE id = ?");
        $update->execute([$quantitySold, $productId]);

        // record the sale to tbl_sales for total sales tracking
        $insert = $pdo->prepare("
            INSERT INTO tbl_sales (product_id, quantity_sold, total_price)
            VALUES (?, ?, ?)
        ");
        $insert->execute([$productId, $quantitySold, $totalPrice]);

        echo json_encode(['success' => true, 'message' => 'Sale processed successfully', 'totalPrice' => $totalPrice]);

    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }