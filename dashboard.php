<?php 
require_once 'config.php'; 
if(!isset($_SESSION['merchant_id'])) header("Location: index.php");
$merchant_id = $_SESSION['merchant_id'];

// Analytics Pulling
$total_orders = $conn->query("SELECT COUNT(*) as c FROM orders WHERE merchant_id = $merchant_id")->fetch_assoc()['c'];
$total_sales = $conn->query("SELECT SUM(total_price) as s FROM orders WHERE merchant_id = $merchant_id")->fetch_assoc()['s'] ?? 0;
$total_products = $conn->query("SELECT COUNT(*) as c FROM products WHERE merchant_id = $merchant_id")->fetch_assoc()['c'];
?>
<?php include 'includes/header.php'; ?>
<div class="flex h-screen bg-gray-900 text-gray-100">
    <?php include 'includes/sidebar.php'; ?>
    <main class="flex-1 p-8 overflow-y-auto">
        <h1 class="text-3xl font-bold mb-6">Welcome back, <?= $_SESSION['business_name']; ?> 🚀</h1>
        
        <!-- Metrics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-gray-800 p-6 rounded-lg border border-gray-700">
                <p class="text-gray-400 text-sm">Total Orders</p>
                <h3 class="text-3xl font-bold text-indigo-400 mt-2"><?= $total_orders; ?></h3>
            </div>
            <div class="bg-gray-800 p-6 rounded-lg border border-gray-700">
                <p class="text-gray-400 text-sm">Total Sales Revenue</p>
                <h3 class="text-3xl font-bold text-green-400 mt-2">৳ <?= number_format($total_sales, 2); ?></h3>
            </div>
            <div class="bg-gray-800 p-6 rounded-lg border border-gray-700">
                <p class="text-gray-400 text-sm">Active Products</p>
                <h3 class="text-3xl font-bold text-pink-400 mt-2"><?= $total_products; ?></h3>
            </div>
        </div>

        <!-- Recent Orders Table Context -->
        <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
            <h2 class="text-xl font-bold mb-4">Recent AI Generated Orders</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-400">
                    <thead class="bg-gray-700 text-gray-200 uppercase text-xs">
                        <tr>
                            <th class="p-3">Customer</th>
                            <th class="p-3">Phone</th>
                            <th class="p-3">Total</th>
                            <th class="p-3">Source</th>
                            <th class="p-3">Courier</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $orders = $conn->query("SELECT * FROM orders WHERE merchant_id = $merchant_id ORDER BY id DESC LIMIT 5");
                        while($row = $orders->fetch_assoc()):
                        ?>
                        <tr class="border-b border-gray-700">
                            <td class="p-3 text-white"><?= $row['customer_name']; ?></td>
                            <td class="p-3"><?= $row['customer_phone']; ?></td>
                            <td class="p-3 text-green-400">৳<?= $row['total_price']; ?></td>
                            <td class="p-3"><span class="bg-indigo-900 text-indigo-300 px-2 py-1 rounded text-xs"><?= $row['source']; ?></span></td>
                            <td class="p-3 text-yellow-400"><?= $row['courier_status']; ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
<?php include 'includes/footer.php'; ?>
