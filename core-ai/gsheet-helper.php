<?php
function pushToGoogleSheet($webhook_url, $row_data) {
    if (empty($webhook_url)) return false;

    // Send payload context to Apps Script Webhook endpoint
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $webhook_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($row_data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
    
    curl_exec($ch);
    curl_close($ch);
    return true;
}
?>