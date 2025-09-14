<?php
include 'db.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phar_ID = $_POST['phar_ID'];
    $cust_ID = $_POST['cust_ID'];
    $med_ID = $_POST['med_ID'];
    $purchase_ID = $_POST['purchase_ID'];
    $count = $_POST['count'];
    $date = $_POST['date'];
    $total_amount = $_POST['total_amount'];
    
    // Modified INSERT query to let MySQL handle the sales_ID auto-increment
    $sql = "INSERT INTO sales (phar_ID, cust_ID, med_ID, purchase_ID, count, date, total_amount) 
            VALUES ('$phar_ID', '$cust_ID', '$med_ID', '$purchase_ID', '$count', '$date', '$total_amount')";
    
    if ($conn->query($sql)) {
        header('Location: pharmacist.php?section=sales');
        exit();
    } else {
        $error = "Error adding sale: " . $conn->error;
    }
}

// Fetch sales with joined data
$sales = $conn->query('
    SELECT s.*, 
           p.fname as phar_fname, p.lname as phar_lname,
           c.fname as cust_fname, c.lname as cust_lname,
           m.name as medicine_name, m.description as medicine_description
    FROM sales s
    JOIN pharmacist p ON s.phar_ID = p.phar_ID
    JOIN customer c ON s.cust_ID = c.cust_ID
    JOIN medicines m ON s.med_ID = m.med_ID
    ORDER BY s.date DESC
');

// Fetch dropdown data
$pharmacists = $conn->query('SELECT phar_ID, fname, lname FROM pharmacist ORDER BY fname, lname');
$customers = $conn->query('SELECT cust_ID, fname, lname FROM customer ORDER BY fname, lname');
$medicines = $conn->query('SELECT med_ID, name, description FROM medicines ORDER BY name');
$purchases = $conn->query('
    SELECT p.purchase_ID, c.fname as cust_fname, c.lname as cust_lname, m.name as medicine_name
    FROM purchasing p
    JOIN customer c ON p.cust_ID = c.cust_ID
    JOIN medicines m ON p.med_ID = m.med_ID
    ORDER BY p.date DESC
');

// Calculate total sales
$total_sales = $conn->query('SELECT SUM(total_amount) as total FROM sales')->fetch_assoc()['total'] ?? 0;
?>
<div class="row mb-4">
    <div class="col-md-8">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title">Total Sales</h5>
                <h3 class="text-primary">$<?= number_format($total_sales, 2) ?></h3>
            </div>
        </div>
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="mb-3">Sales History</h2>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover bg-white">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Pharmacist</th>
                                <th>Customer</th>
                                <th>Medicine</th>
                                <th>Quantity</th>
                                <th>Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php while($row = $sales->fetch_assoc()): ?>
                            <tr>
                                <td><?= date('M d, Y', strtotime($row['date'])) ?></td>
                                <td><?= htmlspecialchars($row['phar_fname'] . ' ' . $row['phar_lname']) ?></td>
                                <td><?= htmlspecialchars($row['cust_fname'] . ' ' . $row['cust_lname']) ?></td>
                                <td><?= htmlspecialchars($row['medicine_name']) ?></td>
                                <td><?= $row['count'] ?></td>
                                <td>$<?= number_format($row['total_amount'], 2) ?></td>
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
                <h5 class="card-title mb-3">Add New Sale</h5>
                <form method="post">
                    <div class="mb-3">
                        <label class="form-label">Pharmacist</label>
                        <select class="form-select" name="phar_ID" required>
                            <option value="">Select Pharmacist</option>
                            <?php $pharmacists->data_seek(0); while($p = $pharmacists->fetch_assoc()): ?>
                                <option value="<?= $p['phar_ID'] ?>"><?= htmlspecialchars($p['fname'] . ' ' . $p['lname']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Customer</label>
                        <select class="form-select" name="cust_ID" required>
                            <option value="">Select Customer</option>
                            <?php $customers->data_seek(0); while($c = $customers->fetch_assoc()): ?>
                                <option value="<?= $c['cust_ID'] ?>"><?= htmlspecialchars($c['fname'] . ' ' . $c['lname']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Medicine</label>
                        <select class="form-select" name="med_ID" required>
                            <option value="">Select Medicine</option>
                            <?php $medicines->data_seek(0); while($m = $medicines->fetch_assoc()): ?>
                                <option value="<?= $m['med_ID'] ?>"><?= htmlspecialchars($m['name']) ?> - <?= htmlspecialchars($m['description']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Purchase Reference</label>
                        <select class="form-select" name="purchase_ID" required>
                            <option value="">Select Purchase</option>
                            <?php $purchases->data_seek(0); while($pu = $purchases->fetch_assoc()): ?>
                                <option value="<?= $pu['purchase_ID'] ?>">
                                    Purchase #<?= $pu['purchase_ID'] ?> - 
                                    <?= htmlspecialchars($pu['cust_fname'] . ' ' . $pu['cust_lname']) ?> - 
                                    <?= htmlspecialchars($pu['medicine_name']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Quantity</label>
                        <input class="form-control" name="count" type="number" min="1" placeholder="Enter quantity" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input class="form-control" name="date" type="date" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Total Amount ($)</label>
                        <input class="form-control" name="total_amount" type="number" step="0.01" placeholder="Enter total amount" required>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Add Sale</button>
                </form>
            </div>
        </div>
    </div>
</div> 