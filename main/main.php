<?php
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'customer') {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pharmacy - Medicines</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body { 
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 50%, #90caf9 100%);
            min-height: 100vh;
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
        .medicine-card {
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border: 2px solid #e3f2fd;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(25, 118, 210, 0.15);
        }
        .medicine-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(25, 118, 210, 0.2);
            border-color: #1976d2;
        }
        .card-title {
            color: #1976d2;
            font-weight: bold;
        }
        .btn-primary {
            background: linear-gradient(45deg, #1976d2, #1565c0);
            border: none;
            border-radius: 25px;
            padding: 10px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white;
        }
        .btn-primary:hover {
            background: linear-gradient(45deg, #1565c0, #0d47a1);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(25, 118, 210, 0.4);
            color: white;
        }
    </style>
</head>
<body>
    <div class="topbar">
        <span class="app-title">Pharmacy</span>
        <div>
            <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
            <span class="ms-3"><i class="bi bi-person-circle" style="font-size: 1.5rem;"></i></span>
        </div>
    </div>
    <div class="main-content">
        <h2 class="mb-4">Available Medicines</h2>
        <div class="row g-4">
            <?php
            // This is a simple example. In a real application, you should fetch from a database
            $medicines = [
                ['name' => 'Paracetamol', 'price' => '$1.25', 'description' => 'For pain relief and fever'],
                ['name' => 'Amoxicillin', 'price' => '$2.50', 'description' => 'Antibiotic for bacterial infections'],
                ['name' => 'Vitamin C', 'price' => '$3.75', 'description' => 'Immune system support'],
                ['name' => 'Ibuprofen', 'price' => '$4.00', 'description' => 'Anti-inflammatory and pain relief'],
            ];

            foreach ($medicines as $medicine) {
                echo '<div class="col-md-3">';
                echo '<div class="card medicine-card h-100">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . htmlspecialchars($medicine['name']) . '</h5>';
                echo '<p class="card-text">' . htmlspecialchars($medicine['description']) . '</p>';
                echo '<p class="card-text"><strong>Price: ' . htmlspecialchars($medicine['price']) . '</strong></p>';
                echo '<button class="btn btn-primary">Add to Cart</button>';
                echo '</div></div></div>';
            }
            ?>
        </div>
    </div>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 