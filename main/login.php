<?php
session_start();
if (isset($_SESSION['user_type'])) {
    if ($_SESSION['user_type'] === 'pharmacist') {
        header('Location: pharmacist.php');
    } else {
        header('Location: main.php');
    }
    exit();
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];
    
    // This is a simple example. In a real application, you should use a database
    if ($user_type === 'pharmacist' && $username === 'admin' && $password === 'admin') {
        $_SESSION['user_type'] = 'pharmacist';
        $_SESSION['username'] = $username;
        header('Location: pharmacist.php');
        exit();
    } elseif ($user_type === 'customer' && $username === 'customer' && $password === 'customer') {
        $_SESSION['user_type'] = 'customer';
        $_SESSION['username'] = $username;
        header('Location: main.php');
        exit();
    } else {
        $error = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pharmacy Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .login-card { max-width: 400px; margin: 80px auto; }
    </style>
</head>
<body>
<div class="container">
    <div class="card login-card shadow-sm">
        <div class="card-body">
            <h3 class="card-title mb-4 text-center">Pharmacy Login</h3>
            <?php if ($error): ?>
                <div class="alert alert-danger"> <?= $error ?> </div>
            <?php endif; ?>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">User Type</label>
                    <select name="user_type" class="form-select" required>
                        <option value="customer">Customer</option>
                        <option value="pharmacist">Pharmacist</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>
</div>
</body>
</html> 