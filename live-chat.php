<?php 
require_once 'config.php'; 
if(!isset($_SESSION['merchant_id'])) header("Location: index.php");
$merchant_id = $_SESSION['merchant_id'];
?>
<?php include 'includes/header.php'; ?>
<div class="flex h-screen bg-gray-900 text-gray-100">
    <?php include 'includes/sidebar.php'; ?>
    <main class="flex-1 flex overflow-hidden">
        
        <!-- Active Chat Threads List -->
        <div class="w-1/3 bg-gray-800 border-r border-gray-700 flex flex-col">
            <div class="p-4 border-b border-gray-700 font-bold text-lg text-indigo-400">Omnichannel Inbox</div>
            <div class="flex-1 overflow-y-auto divide-y divide-gray-700">
                <?php
                $threads = $conn->query("SELECT sender_id, MAX(timestamp) as last_time FROM conversations WHERE merchant_id = $merchant_id GROUP BY sender_id ORDER BY last_time DESC");
                while($user = $threads->fetch_assoc()):
                ?>
                <a href="?chat_with=<?= $user['sender_id']; ?>" class="block p-4 hover:bg-gray-700 transition">
                    <div class="font-semibold text-white">Customer (<?= substr($user['sender_id'], 0, 8); ?>...)</div>
                    <div class="text-xs text-gray-400 mt-1"><?= $user['last_time']; ?></div>
                </a>
                <?php endwhile; ?>
            </div>
        </div>

        <!-- Chat Frame Context -->
        <div class="flex-1 bg-gray-800 flex flex-col justify-between">
            <?php if(isset($_GET['chat_with'])): 
                $chat_with = clean($_GET['chat_with']);
            ?>
            <div class="p-4 border-b border-gray-700 flex justify-between items-center bg-gray-750">
                <span class="font-bold text-white">Active Session: <?= $chat_with; ?></span>
                <button class="bg-red-600 hover:bg-red-700 text-xs text-white font-bold px-3 py-1.5 rounded uppercase tracking-wider">Pause AI Takeover</button>
            </div>
            
            <!-- Message Scroller -->
            <div class="flex-1 p-4 overflow-y-auto space-y-4 bg-gray-900">
                <?php
                $messages = $conn->query("SELECT * FROM conversations WHERE merchant_id = $merchant_id AND sender_id = '$chat_with' ORDER BY id ASC");
                while($msg = $messages->fetch_assoc()):
                    $is_customer = $msg['sender_type'] == 'customer';
                ?>
                <div class="flex <?= $is_customer ? 'justify-start' : 'justify-end'; ?>">
                    <div class="max-w-md p-3 rounded-lg text-sm <?= $is_customer ? 'bg-gray-700 text-white rounded-bl-none' : 'bg-indigo-600 text-white rounded-br-none'; ?>">
                        <p><?= htmlspecialchars($msg['message']); ?></p>
                        <span class="text-[10px] block mt-1 text-gray-300 text-right"><?= date('H:i', strtotime($msg['timestamp'])); ?></span>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>

            <!-- Manual Reply Input Bar -->
            <div class="p-4 border-t border-gray-700 bg-gray-750 flex gap-2">
                <input type="text" placeholder="Type a message to hijack stream..." class="flex-1 bg-gray-700 border border-gray-600 p-2 rounded focus:outline-none text-white text-sm">
                <button class="bg-indigo-600 text-white px-6 py-2 rounded text-sm font-semibold hover:bg-indigo-700">Send</button>
            </div>
            <?php else: ?>
            <div class="flex-1 flex flex-col items-center justify-center text-gray-500">
                <p class="text-lg">Select a conversation thread to manage omnichannel support</p>
            </div>
            <?php endif; ?>
        </div>
    </main>
</div>
<?php include 'includes/footer.php'; ?>