<?php
require_once 'config.php';
if(!isset($_SESSION['merchant_id'])) exit;

$merchant_id = $_SESSION['merchant_id'];

// DELETE ROUTE
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM products WHERE id = $id AND merchant_id = $merchant_id");
    header("Location: products.php");
    exit;
}

// POST ROUTE (CREATE / UPDATE)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $name = clean($_POST['name']);
    $price = (float)$_POST['price'];
    $stock = (int)$_POST['stock'];
    $id = (int)$_POST['id'];

    // Handle Image Upload Logic
    $target_dir = "uploads/products/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $image_path = "";
    if (!empty($_FILES["product_image"]["name"])) {
        $filename = time() . '_' . basename($_FILES["product_image"]["name"]);
        $target_file = $target_dir . $filename;
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
            $image_path = $target_file;
        }
    }

    if ($action == 'create') {
        $stmt = $conn->prepare("INSERT INTO products (merchant_id, name, price, stock, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isdis", $merchant_id, $name, $price, $stock, $image_path);
        $stmt->execute();
    } elseif ($action == 'update') {
        if (!empty($image_path)) {
            $stmt = $conn->prepare("UPDATE products SET name = ?, price = ?, stock = ?, image = ? WHERE id = ? AND merchant_id = ?");
            $stmt->bind_param("sdisii", $name, $price, $stock, $image_path, $id, $merchant_id);
        } else {
            $stmt = $conn->prepare("UPDATE products SET name = ?, price = ?, stock = ? WHERE id = ? AND merchant_id = ?");
            $stmt->bind_param("sdiii", $name, $price, $stock, $id, $merchant_id);
        }
        $stmt->execute();
    }
    header("Location: products.php");
}
?>