<?php
include 'db.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $med_category = $_POST['med_category'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    
    $sql = "INSERT INTO medicines (med_category, name, description, price) 
            VALUES ('$med_category', '$name', '$description', '$price')";
    
    if ($conn->query($sql)) {
        header('Location: pharmacist.php?section=medicines');
        exit();
    } else {
        $error = "Error adding medicine: " . $conn->error;
    }
}

// Fetch medicines with category counts
$medicines = $conn->query('
    SELECT m.*, 
           COUNT(s.med_ID) as total_sales,
           SUM(s.count) as total_quantity_sold
    FROM medicines m
    LEFT JOIN sales s ON m.med_ID = s.med_ID
    GROUP BY m.med_ID
    ORDER BY m.name
');

// Calculate statistics
$total_medicines = $conn->query('SELECT COUNT(*) as total FROM medicines')->fetch_assoc()['total'] ?? 0;
$total_value = $conn->query('SELECT SUM(price) as total FROM medicines')->fetch_assoc()['total'] ?? 0;

// Get unique categories for dropdown
$categories = $conn->query('SELECT DISTINCT med_category FROM medicines ORDER BY med_category');
?>
<div class="row mb-4">
    <div class="col-12">
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Medicines</h5>
                        <h3 class="mb-0"><?= $total_medicines ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Value</h5>
                        <h3 class="mb-0">$<?= number_format($total_value, 2) ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">Categories</h5>
                        <h3 class="mb-0"><?= $categories->num_rows ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="mb-3">Medicine Inventory</h2>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover bg-white">
                        <thead class="table-light" color="white">
                            <tr>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Total Sales</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php while($row = $medicines->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= htmlspecialchars($row['med_category']) ?></td>
                                <td><?= htmlspecialchars($row['description']) ?></td>
                                <td>$<?= number_format($row['price'], 2) ?></td>
                                <td><?= $row['total_quantity_sold'] ?? 0 ?></td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-3">Add New Medicine</h5>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                <form method="post">
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select class="form-select" name="med_category" required>
                            <option value="">Select Category</option>
                            <?php while($cat = $categories->fetch_assoc()): ?>
                                <option value="<?= htmlspecialchars($cat['med_category']) ?>">
                                    <?= htmlspecialchars($cat['med_category']) ?>
                                </option>
                            <?php endwhile; ?>
                            <option value="Other">Other (New Category)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input class="form-control" name="name" placeholder="Enter medicine name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" placeholder="Enter medicine description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price ($)</label>
                        <input class="form-control" name="price" type="number" step="0.01" min="0" placeholder="Enter price" required>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Add Medicine</button>
                </form>
            </div>
        </div>
    </div>
</div> 