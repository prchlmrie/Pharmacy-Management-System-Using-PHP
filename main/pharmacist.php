<?php
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'pharmacist') {
    header('Location: login.php');
    exit();
}
$section = $_GET['section'] ?? 'dashboard';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pharmacist Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body { 
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 50%, #90caf9 100%);
            min-height: 100vh;
        }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #1976d2, #1565c0);
            border-right: 3px solid #e3f2fd;
            padding-top: 1.5rem;
            box-shadow: 4px 0 20px rgba(25, 118, 210, 0.2);
        }
        .sidebar .nav-link {
            color: #e3f2fd;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            padding: 12px 15px;
        }
        .sidebar .nav-link.active, .sidebar .nav-link:hover {
            background: linear-gradient(45deg, #e3f2fd, #bbdefb);
            color: #1976d2;
            border-radius: 10px;
            transform: translateX(5px);
            box-shadow: 0 4px 15px rgba(227, 242, 253, 0.4);
        }
        .topbar {
            background: linear-gradient(45deg, #1976d2, #1565c0);
            color: #fff;
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 20px rgba(25, 118, 210, 0.2);
        }
        .topbar .app-title { 
            font-size: 1.5rem; 
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .main-content { 
            padding: 2rem;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }
        .sidebar-logo {
            text-align: center;
            margin-bottom: 2rem;
            padding: 20px;
            background: linear-gradient(45deg, #e3f2fd, #bbdefb);
            border-radius: 15px;
            margin: 0 10px 2rem 10px;
            border: 2px solid #fff;
        }
        .sidebar-logo img {
            width: 80px;
            margin-bottom: 0.5rem;
            filter: brightness(0) saturate(100%) invert(27%) sepia(51%) saturate(2878%) hue-rotate(346deg) brightness(104%) contrast(97%);
        }
        .sidebar-logo h5 { 
            font-size: 1.1rem; 
            margin-bottom: 0;
            color: #1976d2;
            font-weight: bold;
            text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.5);
        }
        .dashboard-chart-img {
            max-width: 100%;
            height: 350px;
            object-fit: contain;
            display: block;
            margin: 0 auto;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(25, 118, 210, 0.15);
            border: 3px solid #e3f2fd;
        }
        .card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border: 2px solid #e3f2fd;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(25, 118, 210, 0.15);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            border-color: #1976d2;
            box-shadow: 0 12px 40px rgba(25, 118, 210, 0.2);
        }
        .card-title {
            color: #000000;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="d-flex">
    <div class="sidebar p-3">
        <div class="sidebar-logo">
            <img src="https://img.icons8.com/fluency/96/000000/pharmacy-shop.png" alt="Pharmacy Logo">
            <h5>PHARMACY MANAGER</h5>
        </div>
        <nav class="nav flex-column">
            <a class="nav-link<?= $section=='dashboard'?' active':'' ?>" href="?section=dashboard"><i class="bi bi-house"></i> Dashboard</a>
            <a class="nav-link<?= $section=='medicines'?' active':'' ?>" href="?section=medicines"><i class="bi bi-capsule"></i> Medicines</a>
            <a class="nav-link<?= $section=='customers'?' active':'' ?>" href="?section=customers"><i class="bi bi-people"></i> Customers</a>
            <a class="nav-link<?= $section=='purchasing'?' active':'' ?>" href="?section=purchasing"><i class="bi bi-cart"></i> Purchasing</a>
            <a class="nav-link<?= $section=='sales'?' active':'' ?>" href="?section=sales"><i class="bi bi-cash"></i> Sales</a>
            <a class="nav-link<?= $section=='reports'?' active':'' ?>" href="?section=reports"><i class="bi bi-clipboard-data"></i> Reports</a>
        </nav>
    </div>
    <div class="flex-grow-1">
        <div class="topbar">
            <span class="app-title">Pharmacy Manager</span>
            <div>
                <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
                <span class="ms-3"><i class="bi bi-person-circle" style="font-size: 1.5rem;"></i></span>
            </div>
        </div>
        <div class="main-content">
            <?php
            if ($section === 'dashboard') {
                echo '<div class="row g-4">';
                echo '<div class="col-md-6"><div class="card"><div class="card-body"><h5 class="card-title"><i class="bi bi-cash"></i> Sales</h5><ul class="list-unstyled mb-0"><li>Today Sales: $ 350</li><li>This Month: $ 350</li><li>This Year: $ 350</li><li>Profit / Loss: $ -150</li></ul><button class="btn btn-success btn-sm mt-3">STOCK ALERT</button></div></div></div>';
                echo '<div class="col-md-6"><div class="card"><div class="card-body"><h5 class="card-title"><i class="bi bi-people"></i> Customers</h5><ul class="list-unstyled mb-0"><li>Total Customers: 2</li><li>Total Products: 6</li><li>Total Services: 1</li><li>Current Stock: $ 900</li></ul><button class="btn btn-warning btn-sm mt-3">EXPIRY ALERT</button></div></div></div>';
                echo '</div>';
                echo '<div class="card mt-4"><div class="card-body"><h5 class="card-title">Sales and Expenses for the Year</h5>';
                echo '<img src="./images/dashboard.png" alt="Sales Chart" class="dashboard-chart-img">';
                echo '</div></div>';
            } else {
                include $section . '.php';
            }
            ?>
        </div>
    </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 