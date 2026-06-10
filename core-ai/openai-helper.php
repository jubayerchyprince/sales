<?php
function getAIResponse($user_message, $api_key, $model = 'gpt-4o', $merchant_id) {
    if (empty($api_key)) return "API configuration missing.";

    global $conn;
    
    // Fetch system context dynamic products to pass into LLM context
    $prod_query = $conn->query("SELECT name, price, stock FROM products WHERE merchant_id = $merchant_id AND stock > 0");
    $catalog = "";
    while($p = $prod_query->fetch_assoc()) {
        $catalog .= "- {$p['name']}: Price BDT {$p['price']} (In Stock: {$p['stock']})\n";
    }

    $system_prompt = "You are an automated Facebook Sales Assistant for a page. Be brief and sell in Bengali. Available items:\n$catalog\nIf customer provides Name, Phone and Delivery address, reply strictly ending with line format 'ORDER_CONFIRMED: Name|Phone|Address|Details'";

    $url = "https://api.openai.com/v1/chat/completions";
    $data = [
        "model" => $model,
        "messages" => [
            ["role" => "system", "content" => $system_prompt],
            ["role" => "user", "content" => $user_message]
        ],
        "temperature" => 0.5
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer " . $api_key
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $res_json = json_decode($response, true);
    return isset($res_json['choices'][0]['message']['content']) ? $res_json['choices'][0]['message']['content'] : "দুঃখিত, একটু কারিগরি সমস্যা হচ্ছে।";
}
?>