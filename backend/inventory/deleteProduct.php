<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Content-Type');

    require_once '../utils/db_connection.php';

    if (!isset($_GET['id'])) {
        echo json_encode(['error' => 'Missing product ID']);
        exit;
    }

    $id = intval($_GET['id']);

    try {
        $stmt = $pdo->prepare("DELETE FROM tbl_products WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'No item found with that ID']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }