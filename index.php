<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SalesAI Assistant - Login/Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-gray-100 flex items-center justify-center h-screen">
    <div class="bg-gray-800 p-8 rounded-lg shadow-xl w-full max-w-md">
        <h2 class="text-3xl font-bold text-center mb-6 text-indigo-400">SalesAI BD</h2>
        
        <?php if(isset($_SESSION['error'])): ?>
            <div class="bg-red-500 text-white p-3 rounded mb-4 text-sm text-center"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <?php if(isset($_SESSION['success'])): ?>
            <div class="bg-green-500 text-white p-3 rounded mb-4 text-sm text-center"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <!-- Login Form -->
        <div id="login-box">
            <form action="login-process.php" method="POST" class="space-y-4">
                <div>
                    <label class="block text-sm mb-1">Email Address</label>
                    <input type="email" name="email" required class="w-full bg-gray-700 border border-gray-600 p-2 rounded focus:outline-none focus:border-indigo-500 text-white">
                </div>
                <div>
                    <label class="block text-sm mb-1">Password</label>
                    <input type="password" name="password" required class="w-full bg-gray-700 border border-gray-600 p-2 rounded focus:outline-none focus:border-indigo-500 text-white">
                </div>
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 p-2 rounded font-semibold transition">Sign In</button>
            </form>
            <p class="text-sm mt-4 text-center text-gray-400">Don't have an account? <span onclick="toggleAuth()" class="text-indigo-400 cursor-pointer hover:underline">Register</span></p>
        </div>

        <!-- Register Form -->
        <div id="register-box" class="hidden">
            <form action="register-process.php" method="POST" class="space-y-4">
                <div>
                    <label class="block text-sm mb-1">Business Name</label>
                    <input type="text" name="business_name" required class="w-full bg-gray-700 border border-gray-600 p-2 rounded focus:outline-none focus:border-indigo-500 text-white">
                </div>
                <div>
                    <label class="block text-sm mb-1">Email Address</label>
                    <input type="email" name="email" required class="w-full bg-gray-700 border border-gray-600 p-2 rounded focus:outline-none focus:border-indigo-500 text-white">
                </div>
                <div>
                    <label class="block text-sm mb-1">Password</label>
                    <input type="password" name="password" required class="w-full bg-gray-700 border border-gray-600 p-2 rounded focus:outline-none focus:border-indigo-500 text-white">
                </div>
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 p-2 rounded font-semibold transition">Create Account</button>
            </form>
            <p class="text-sm mt-4 text-center text-gray-400">Already have an account? <span onclick="toggleAuth()" class="text-indigo-400 cursor-pointer hover:underline">Login</span></p>
        </div>
    </div>

    <script>
        function toggleAuth() {
            document.getElementById('login-box').classList.toggle('hidden');
            document.getElementById('register-box').classList.toggle('hidden');
        }
    </script>
</body>
</html>
