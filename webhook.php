<?php
require_once 'config.php';
require_once 'core-ai/openai-helper.php';
require_once 'core-ai/gsheet-helper.php';

// Meta Webhook Verification
$verify_token = "MY_SECURE_VERIFY_TOKEN"; 
if (isset($_GET['hub_mode']) && $_GET['hub_mode'] == 'subscribe' && isset($_GET['hub_verify_token']) && $_GET['hub_verify_token'] == $verify_token) {
    echo $_GET['hub_challenge'];
    exit;
}

// Handle Incoming Messages
$input = json_decode(file_get_contents('php://input'), true);

if (!empty($input['entry'][0]['messaging'][0])) {
    $messaging = $input['entry'][0]['messaging'][0];
    $sender_id = $messaging['sender']['id'];
    $message_text = isset($messaging['message']['text']) ? $messaging['message']['text'] : '';
    
    // Static Merchant Assignment for Webhook Sandbox (Change dynamic for production)
    $merchant_id = 1; 

    if (!empty($message_text)) {
        // 1. Save Customer Message
        $stmt = $conn->prepare("INSERT INTO conversations (merchant_id, sender_id, message, sender_type) VALUES (?, ?, ?, 'customer')");
        $stmt->bind_param("iss", $merchant_id, $sender_id, $message_text);
        $stmt->execute();

        // 2. Fetch Merchant AI Settings
        $ai_query = $conn->prepare("SELECT * FROM ai_settings WHERE merchant_id = ?");
        $ai_query->bind_param("i", $merchant_id);
        $ai_query->execute();
        $settings = $ai_query->get_result()->fetch_assoc();

        if ($settings && $settings['ai_status'] == 1) {
            // Get Response from OpenAI Script
            $ai_response = getAIResponse($message_text, $settings['api_key'], $settings['ai_model'], $merchant_id);
            
            // 3. Save AI Reply
            $stmt = $conn->prepare("INSERT INTO conversations (merchant_id, sender_id, message, sender_type) VALUES (?, ?, ?, 'ai')");
            $stmt->bind_param("iss", $merchant_id, $sender_id, $ai_response);
            $stmt->execute();
            
            // 4. Check if Order Detected and push to Sheet
            if (strpos($ai_response, 'ORDER_CONFIRMED') !== false && $settings['gsheet_status'] == 1) {
                // Dummy Data parsing logic - dynamic parsing can be done based on AI format
                pushToGoogleSheet($settings['gsheet_url'], ['Customer', 'Phone', 'Address', 'Product details']);
            }
            
            // Send Message Back to Meta API Code goes here...
        }
    }
}
?>