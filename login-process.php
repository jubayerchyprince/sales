<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = clean($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM merchants WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['merchant_id'] = $user['id'];
        $_SESSION['business_name'] = $user['business_name'];
        header("Location: dashboard.php");
    } else {
        $_SESSION['error'] = "Invalid Email or Password!";
        header("Location: index.php");
    }
}
?>