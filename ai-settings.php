<?php 
require_once 'config.php'; 
if(!isset($_SESSION['merchant_id'])) header("Location: index.php");
$merchant_id = $_SESSION['merchant_id'];

$settings = $conn->query("SELECT * FROM ai_settings WHERE merchant_id = $merchant_id")->fetch_assoc();
?>
<?php include 'includes/header.php'; ?>
<div class="flex h-screen bg-gray-900 text-gray-100">
    <?php include 'includes/sidebar.php'; ?>
    <main class="flex-1 p-8 overflow-y-auto">
        <h1 class="text-3xl font-bold mb-6">AI Control & Core Integrations</h1>
        
        <?php if(isset($_SESSION['success'])): ?>
            <div class="bg-green-500 text-white p-3 rounded mb-4 max-w-2xl"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <form action="save-settings.php" method="POST" class="bg-gray-800 p-6 rounded-lg border border-gray-700 max-w-2xl space-y-6">
            <!-- AI Enable/Disable Toggle -->
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-semibold text-lg">AI Sales Automation</h3>
                    <p class="text-gray-400 text-sm">Allow model to respond to messaging flows</p>
                </div>
                <input type="checkbox" name="ai_status" value="1" <?= ($settings['ai_status'] ?? 0) == 1 ? 'checked' : ''; ?> class="w-6 h-6 accent-indigo-500">
            </div>
            <hr class="border-gray-700">

            <!-- Model Settings Grid -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm mb-1">Select LLM Engine</label>
                    <select name="ai_model" class="w-full bg-gray-700 border border-gray-600 p-2 rounded focus:outline-none text-white">
                        <option value="gpt-4o" <?= ($settings['ai_model'] ?? '') == 'gpt-4o' ? 'selected' : ''; ?>>OpenAI GPT-4o</option>
                        <option value="gpt-3.5-turbo" <?= ($settings['ai_model'] ?? '') == 'gpt-3.5-turbo' ? 'selected' : ''; ?>>OpenAI GPT-3.5 Turbo</option>
                        <option value="claude-3-haiku" <?= ($settings['ai_model'] ?? '') == 'claude-3-haiku' ? 'selected' : ''; ?>>Claude 3 Haiku</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm mb-1">Own API Secret Key</label>
                    <input type="password" name="api_key" value="<?= $settings['api_key'] ?? ''; ?>" class="w-full bg-gray-700 border border-gray-600 p-2 rounded focus:outline-none text-white">
                </div>
            </div>

            <!-- Spreadsheet Settings Sync -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-sm">Google Sheets Automation Link</label>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-gray-400">Sync Status</span>
                        <input type="checkbox" name="gsheet_status" value="1" <?= ($settings['gsheet_status'] ?? 0) == 1 ? 'checked' : ''; ?> class="accent-indigo-500">
                    </div>
                </div>
                <input type="url" name="gsheet_url" value="<?= $settings['gsheet_url'] ?? ''; ?>" placeholder="https://docs.google.com/spreadsheets/d/..." class="w-full bg-gray-700 border border-gray-600 p-2 rounded focus:outline-none text-white">
            </div>

            <!-- Courier Logistics API Settings -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm mb-1">Active Courier API Gateway</label>
                    <select name="courier_api" class="w-full bg-gray-700 border border-gray-600 p-2 rounded focus:outline-none text-white">
                        <option value="steadfast" <?= ($settings['courier_api'] ?? '') == 'steadfast' ? 'selected' : ''; ?>>Steadfast Courier</option>
                        <option value="pathao" <?= ($settings['courier_api'] ?? '') == 'pathao' ? 'selected' : ''; ?>>Pathao Logistics</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm mb-1">Courier Secret Token</label>
                    <input type="password" name="courier_secret" value="<?= $settings['courier_secret'] ?? ''; ?>" class="w-full bg-gray-700 border border-gray-600 p-2 rounded focus:outline-none text-white">
                </div>
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 p-2 rounded font-semibold transition">Save Configurations</button>
        </form>
    </main>
</div>
<?php include 'includes/footer.php'; ?>