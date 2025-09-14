<?php
include 'db.php';

// Fetch transaction reports by joining sales and purchasing data
$reports = $conn->query('
    SELECT 
        s.date,
        c.fname as customer_fname, 
        c.lname as customer_lname,
        m.name as medicine_name,
        p.amount as purchase_amount,
        s.total_amount as sales_amount
    FROM sales s
    JOIN customer c ON s.cust_ID = c.cust_ID
    JOIN medicines m ON s.med_ID = m.med_ID
    LEFT JOIN purchasing p ON s.purchase_ID = p.purchase_ID
    ORDER BY s.date DESC
');

// Calculate summary statistics
$total_sales = $conn->query('SELECT SUM(total_amount) as total FROM sales')->fetch_assoc()['total'] ?? 0;
$total_purchases = $conn->query('SELECT SUM(amount) as total FROM purchasing')->fetch_assoc()['total'] ?? 0;
$total_customers = $conn->query('SELECT COUNT(*) as total FROM customer')->fetch_assoc()['total'] ?? 0;
$total_medicines = $conn->query('SELECT COUNT(*) as total FROM medicines')->fetch_assoc()['total'] ?? 0;

// Calculate total profit
$total_profit = $total_sales - $total_purchases;
?>
<div class="row mb-4">
    <div class="col-12">
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Sales</h5>
                        <h3 class="mb-0">$<?= number_format($total_sales, 2) ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Purchases</h5>
                        <h3 class="mb-0">$<?= number_format($total_purchases, 2) ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Profit</h5>
                        <h3 class="mb-0">$<?= number_format($total_profit, 2) ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Customers</h5>
                        <h3 class="mb-0"><?= $total_customers ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="mb-3">Transaction Reports</h2>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover bg-white">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Medicine</th>
                                <th>Purchase Amount</th>
                                <th>Sales Amount</th>
                                <th>Profit/Loss</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php while($row = $reports->fetch_assoc()): ?>
                            <tr>
                                <td><?= date('M d, Y', strtotime($row['date'])) ?></td>
                                <td><?= htmlspecialchars($row['customer_fname'] . ' ' . $row['customer_lname']) ?></td>
                                <td><?= htmlspecialchars($row['medicine_name']) ?></td>
                                <td>$<?= number_format($row['purchase_amount'] ?? 0, 2) ?></td>
                                <td>$<?= number_format($row['sales_amount'], 2) ?></td>
                                <td class="<?= ($row['sales_amount'] - ($row['purchase_amount'] ?? 0)) >= 0 ? 'text-success' : 'text-danger' ?>">
                                    $<?= number_format($row['sales_amount'] - ($row['purchase_amount'] ?? 0), 2) ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> 