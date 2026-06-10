<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $business_name = clean($_POST['business_name']);
    $email = clean($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check Duplicate
    $check = $conn->prepare("SELECT id FROM merchants WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    if ($check->get_result()->num_rows > 0) {
        $_SESSION['error'] = "Email is already registered!";
        header("Location: index.php");
        exit;
    }

    // Insert Merchant
    $stmt = $conn->prepare("INSERT INTO merchants (business_name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $business_name, $email, $password);
    
    if ($stmt->execute()) {
        $merchant_id = $stmt->insert_id;
        // Default Settings Seed
        $seed = $conn->prepare("INSERT INTO ai_settings (merchant_id) VALUES (?)");
        $seed->bind_param("i", $merchant_id);
        $seed->execute();

        $_SESSION['success'] = "Registration Successful! Please login.";
    } else {
        $_SESSION['error'] = "Something went wrong!";
    }
    header("Location: index.php");
}
?>