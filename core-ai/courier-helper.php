<?php
function bookCourierOrder($gateway, $api_key, $order_payload) {
    if (empty($api_key)) return "Missing API Token Configuration.";

    // Conditional Mapping for Steadfast or Pathao Endpoint
    $url = ($gateway == 'steadfast') ? "https://portal.steadfast.com.bd/api/v1/create_order" : "https://api-hermes.pathaouat.com/aladdin/api/v1/orders";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($order_payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer " . $api_key
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}
?>