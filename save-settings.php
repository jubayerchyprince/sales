<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $merchant_id = $_SESSION['merchant_id'];
    $ai_status = isset($_POST['ai_status']) ? 1 : 0;
    $ai_model = clean($_POST['ai_model']);
    $api_key = clean($_POST['api_key']);
    $gsheet_status = isset($_POST['gsheet_status']) ? 1 : 0;
    $gsheet_url = clean($_POST['gsheet_url']);
    $courier_api = clean($_POST['courier_api']);
    $courier_secret = clean($_POST['courier_secret']);

    $stmt = $conn->prepare("UPDATE ai_settings SET ai_status = ?, ai_model = ?, api_key = ?, gsheet_status = ?, gsheet_url = ?, courier_api = ?, courier_secret = ? WHERE merchant_id = ?");
    $stmt->bind_param("ississsi", $ai_status, $ai_model, $api_key, $gsheet_status, $gsheet_url, $courier_api, $courier_secret, $merchant_id);
    $stmt->execute();

    $_SESSION['success'] = "Integration settings updated successfully!";
    header("Location: ai-settings.php");
}
?>