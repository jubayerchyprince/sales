<?php 
require_once 'config.php'; 
if(!isset($_SESSION['merchant_id'])) header("Location: index.php");
$merchant_id = $_SESSION['merchant_id'];
?>
<?php include 'includes/header.php'; ?>
<div class="flex h-screen bg-gray-900 text-gray-100">
    <?php include 'includes/sidebar.php'; ?>
    <main class="flex-1 p-8 overflow-y-auto">
        <h1 class="text-3xl font-bold mb-6">Master Orders Directory</h1>

        <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-400">
                    <thead class="bg-gray-700 text-gray-200 uppercase text-xs">
                        <tr>
                            <th class="p-3">Order ID</th>
                            <th class="p-3">Customer Information</th>
                            <th class="p-3">Ordered Items Context</th>
                            <th class="p-3">Total Value</th>
                            <th class="p-3">Source Channel</th>
                            <th class="p-3">Courier Logistics Sync</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $orders = $conn->query("SELECT * FROM orders WHERE merchant_id = $merchant_id ORDER BY id DESC");
                        if($orders->num_rows == 0) echo "<tr><td colspan='6' class='p-3 text-center'>No automated orders logged yet.</td></tr>";
                        while($row = $orders->fetch_assoc()):
                        ?>
                        <tr class="border-b border-gray-700 hover:bg-gray-750">
                            <td class="p-3 text-white font-mono">#<?= $row['id']; ?></td>
                            <td class="p-3">
                                <div class="text-white font-semibold"><?= $row['customer_name']; ?></div>
                                <div class="text-xs text-gray-400"><?= $row['customer_phone']; ?></div>
                                <div class="text-xs text-gray-500 max-w-xs truncate"><?= $row['customer_address']; ?></div>
                            </td>
                            <td class="p-3 text-gray-200"><?= $row['product_details']; ?></td>
                            <td class="p-3 text-green-400 font-bold">৳<?= $row['total_price']; ?></td>
                            <td class="p-3">
                                <span class="bg-blue-900 text-blue-300 text-xs px-2 py-1 rounded font-medium"><?= $row['source']; ?></span>
                            </td>
                            <td class="p-3">
                                <span class="text-yellow-500 font-semibold text-sm"><?= $row['courier_status']; ?></span>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
<?php include 'includes/footer.php'; ?>