<!DOCTYPE html>
<html>
<head>
    <title>Pharmacy Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body { 
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 50%, #90caf9 100%);
            min-height: 100vh;
        }
        .navbar-brand { 
            font-weight: bold;
            color: #fff !important;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .main-content { 
            margin-top: 2rem;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 8px 32px rgba(25, 118, 210, 0.15);
            border: 2px solid #e3f2fd;
        }
        .navbar {
            background: linear-gradient(45deg, #1976d2, #1565c0) !important;
            box-shadow: 0 4px 20px rgba(25, 118, 210, 0.2);
        }
        .nav-link {
            color: #fff !important;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .nav-link:hover {
            color: #e3f2fd !important;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="index.php">Pharmacy System</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="?section=customers">Customers</a></li>
        <li class="nav-item"><a class="nav-link" href="?section=pharmacists">Pharmacists</a></li>
        <li class="nav-item"><a class="nav-link" href="?section=medicines">Medicines</a></li>
        <li class="nav-item"><a class="nav-link" href="?section=purchasing">Purchasing</a></li>
        <li class="nav-item"><a class="nav-link" href="?section=sales">Sales</a></li>
        <li class="nav-item"><a class="nav-link" href="?section=reports">Reports</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container main-content">
    <?php
    $section = $_GET['section'] ?? 'customers';
    include $section . '.php';
    ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
