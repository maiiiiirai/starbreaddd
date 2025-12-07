<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *'); 

    require_once '../utils/db_connection.php';

    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    // Get filters
    $fromDate = isset($_GET['from_date']) ? $_GET['from_date'] : null;
    $toDate = isset($_GET['to_date']) ? $_GET['to_date'] : null;
    $search = isset($_GET['search']) ? trim($_GET['search']) : null;

    try {
        $whereClause = '';
        $params = [];
        
        if ($fromDate) {
            $whereClause .= ' AND created_at >= :from_date';
            $params[':from_date'] = $fromDate . ' 00:00:00';
        }
        if ($toDate) {
            $whereClause .= ' AND created_at <= :to_date';
            $params[':to_date'] = $toDate . ' 23:59:59';
        }
        if ($search) {
            $whereClause .= ' AND (product LIKE :search OR category LIKE :search)';
            $params[':search'] = '%' . $search . '%';
        }
        
        // Fetch products
        $stmt = $pdo->prepare("SELECT * FROM tbl_products WHERE 1=1 $whereClause LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Count total with filters
        $countStmt = $pdo->prepare("SELECT COUNT(*) as total FROM tbl_products WHERE 1=1 $whereClause");
        foreach ($params as $key => $value) {
            $countStmt->bindValue($key, $value);
        }
        $countStmt->execute();
        $total = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
        $totalPages = ceil($total / $limit);

        echo json_encode([
            'products' => $products,
            'totalPages' => $totalPages,
            'currentPage' => $page
        ]);
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
?>