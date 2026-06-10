<?php 
require_once 'config.php'; 
if(!isset($_SESSION['merchant_id'])) header("Location: index.php");
$merchant_id = $_SESSION['merchant_id'];
?>
<?php include 'includes/header.php'; ?>
<div class="flex h-screen bg-gray-900 text-gray-100">
    <?php include 'includes/sidebar.php'; ?>
    <main class="flex-1 p-8 overflow-y-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Product Inventory</h1>
            <a href="product-add.php" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded text-sm font-semibold transition">+ Add New Product</a>
        </div>

        <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <?php
                $products = $conn->query("SELECT * FROM products WHERE merchant_id = $merchant_id ORDER BY id DESC");
                if($products->num_rows == 0) echo "<p class='text-gray-400 col-span-4 text-center'>No products found. Add your first product.</p>";
                while($item = $products->fetch_assoc()):
                ?>
                <div class="bg-gray-700 rounded-lg overflow-hidden border border-gray-600 shadow-md">
                    <img src="<?= !empty($item['image']) ? $item['image'] : 'https://via.placeholder.com/300' ?>" class="w-full h-48 object-cover">
                    <div class="p-4 space-y-2">
                        <h3 class="font-bold text-lg text-white truncate"><?= $item['name']; ?></h3>
                        <div class="flex justify-between text-sm">
                            <span class="text-green-400 font-semibold">৳ <?= $item['price']; ?></span>
                            <span class="text-gray-300">Stock: <?= $item['stock']; ?></span>
                        </div>
                        <hr class="border-gray-600 my-2">
                        <div class="flex justify-between text-xs">
                            <a href="product-add.php?edit=<?= $item['id']; ?>" class="text-blue-400 hover:underline">Edit Product</a>
                            <a href="product-process.php?delete=<?= $item['id']; ?>" onclick="return confirm('Are you sure?')" class="text-red-400 hover:underline">Remove</a>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </main>
</div>
<?php include 'includes/footer.php'; ?>