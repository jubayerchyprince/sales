<?php 
require_once 'config.php'; 
if(!isset($_SESSION['merchant_id'])) header("Location: index.php");

$edit_mode = false;
$name = $price = $stock = ""; $id = 0;
if (isset($_GET['edit'])) {
    $edit_mode = true;
    $id = (int)$_GET['edit'];
    $merchant_id = $_SESSION['merchant_id'];
    $product = $conn->query("SELECT * FROM products WHERE id = $id AND merchant_id = $merchant_id")->fetch_assoc();
    if($product) {
        $name = $product['name'];
        $price = $product['price'];
        $stock = $product['stock'];
    }
}
?>
<?php include 'includes/header.php'; ?>
<div class="flex h-screen bg-gray-900 text-gray-100">
    <?php include 'includes/sidebar.php'; ?>
    <main class="flex-1 p-8 overflow-y-auto">
        <h1 class="text-3xl font-bold mb-6"><?= $edit_mode ? 'Modify Product' : 'Add Strategic Product'; ?></h1>

        <form action="product-process.php" method="POST" enctype="multipart/form-data" class="bg-gray-800 p-6 rounded-lg border border-gray-700 max-w-xl space-y-4">
            <input type="hidden" name="id" value="<?= $id; ?>">
            <input type="hidden" name="action" value="<?= $edit_mode ? 'update' : 'create'; ?>">

            <div>
                <label class="block text-sm mb-1">Product Title / Name</label>
                <input type="text" name="name" value="<?= $name; ?>" required class="w-full bg-gray-700 border border-gray-600 p-2 rounded focus:outline-none text-white">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm mb-1">Sale Price (BDT)</label>
                    <input type="number" step="0.01" name="price" value="<?= $price; ?>" required class="w-full bg-gray-700 border border-gray-600 p-2 rounded focus:outline-none text-white">
                </div>
                <div>
                    <label class="block text-sm mb-1">Available Inventory Stock</label>
                    <input type="number" name="stock" value="<?= $stock; ?>" required class="w-full bg-gray-700 border border-gray-600 p-2 rounded focus:outline-none text-white">
                </div>
            </div>
            <div>
                <label class="block text-sm mb-1">Product Display Photo</label>
                <input type="file" name="product_image" class="w-full bg-gray-700 border border-gray-600 p-2 rounded file:bg-gray-600 file:text-white file:border-none file:px-2 file:py-1 file:rounded file:mr-2">
            </div>
            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 p-2 rounded font-semibold transition"><?= $edit_mode ? 'Update Item' : 'Publish Product'; ?></button>
        </form>
    </main>
</div>
<?php include 'includes/footer.php'; ?>