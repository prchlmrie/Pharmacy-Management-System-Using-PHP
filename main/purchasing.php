<?php
include 'db.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cust_ID = $_POST['cust_ID'];
    $med_ID = $_POST['med_ID'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $sql = "INSERT INTO purchasing (cust_ID, med_ID, amount, date) VALUES ($cust_ID, $med_ID, '$amount', '$date')";
    $conn->query($sql);
    header('Location: pharmacist.php?section=purchasing');
    exit();
}

// Fetch purchases with joined data
$purchases = $conn->query('
    SELECT p.*, 
           c.fname as customer_fname, c.lname as customer_lname,
           m.name as medicine_name, m.description as medicine_description
    FROM purchasing p
    JOIN customer c ON p.cust_ID = c.cust_ID
    JOIN medicines m ON p.med_ID = m.med_ID
    ORDER BY p.date DESC
');

// Fetch customers and medicines for dropdowns
$customers = $conn->query('SELECT cust_ID, fname, lname FROM customer ORDER BY fname, lname');
$medicines = $conn->query('SELECT med_ID, name, description FROM medicines ORDER BY name');

// Calculate total purchases
$total_purchases = $conn->query('SELECT SUM(amount) as total FROM purchasing')->fetch_assoc()['total'] ?? 0;
?>
<div class="row mb-4">
    <div class="col-md-8">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title">Total Purchases</h5>
                <h3 class="text-primary">$<?= number_format($total_purchases, 2) ?></h3>
            </div>
        </div>
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="mb-3">Purchase History</h2>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover bg-white">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Medicine</th>
                                <th>Description</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php while($row = $purchases->fetch_assoc()): ?>
                            <tr>
                                <td><?= date('M d, Y', strtotime($row['date'])) ?></td>
                                <td><?= htmlspecialchars($row['customer_fname'] . ' ' . $row['customer_lname']) ?></td>
                                <td><?= htmlspecialchars($row['medicine_name']) ?></td>
                                <td><?= htmlspecialchars($row['medicine_description']) ?></td>
                                <td>$<?= number_format($row['amount'], 2) ?></td>
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
                <h5 class="card-title mb-3">Add New Purchase</h5>
                <form method="post">
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
                        <label class="form-label">Amount ($)</label>
                        <input class="form-control" name="amount" type="number" step="0.01" placeholder="Enter amount" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input class="form-control" name="date" type="date" required>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Add Purchase</button>
                </form>
            </div>
        </div>
    </div>
</div> 