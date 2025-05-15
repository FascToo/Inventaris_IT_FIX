<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Inventory System</title>
    <!-- Link to Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Optional: Custom CSS -->
    <style>
        .hero-image {
            background-image: url('assets/img/bg.jpg'); /* Ganti dengan gambar yang diinginkan */
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-btn {
            background-color: #007bff;
            color: white;
            padding: 15px 30px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .login-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <!-- Hero Section with Full Image -->
    <div class="hero-image">
        <div class="text-center">
            <h1 class="text-white display-4">Welcome to IT Inventory System</h1>
            <p class="text-white fs-3">Manage your IT inventory, requests, and more</p>
            <!-- Login Button -->
            <a href="auth/login.php" class="login-btn">Login</a>
        </div>
    </div>

    <!-- Optional: Bootstrap JS (If needed for interactive elements) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
