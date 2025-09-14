<?php
include 'db.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $contact_add = $_POST['contact_add'];
    $cust_email = $_POST['cust_email'];
    $cust_pass = $_POST['cust_pass'];
    $sql = "INSERT INTO customer (fname, lname, gender, age, contact_add, cust_email, cust_pass) VALUES ('$fname', '$lname', '$gender', $age, '$contact_add', '$cust_email', '$cust_pass')";
    $conn->query($sql);
    header('Location: pharmacist.php?section=customers');
    exit();
}

// Fetch customers with their purchase count
$customers = $conn->query('
    SELECT c.*, 
           COUNT(p.purchase_ID) as total_purchases,
           SUM(p.amount) as total_spent
    FROM customer c
    LEFT JOIN purchasing p ON c.cust_ID = p.cust_ID
    GROUP BY c.cust_ID
    ORDER BY c.fname, c.lname
');

// Calculate total customers
$total_customers = $conn->query('SELECT COUNT(*) as total FROM customer')->fetch_assoc()['total'] ?? 0;
?>
<div class="row mb-4">
    <div class="col-md-8">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title">Total Customers</h5>
                <h3 class="text-primary"><?= $total_customers ?></h3>
            </div>
        </div>
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="mb-3">Customer List</h2>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover bg-white">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Age</th>
                                <th>Contact</th>
                                <th>Email</th>
                                <th>Total Purchases</th>
                                <th>Total Spent</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php while($row = $customers->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['fname'] . ' ' . $row['lname']) ?></td>
                                <td><?= htmlspecialchars($row['gender']) ?></td>
                                <td><?= htmlspecialchars($row['age']) ?></td>
                                <td><?= htmlspecialchars($row['contact_add']) ?></td>
                                <td><?= htmlspecialchars($row['cust_email']) ?></td>
                                <td><?= $row['total_purchases'] ?></td>
                                <td>$<?= number_format($row['total_spent'] ?? 0, 2) ?></td>
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
                <h5 class="card-title mb-3">Add New Customer</h5>
                <form method="post">
                    <div class="mb-3">
                        <label class="form-label">First Name</label>
                        <input class="form-control" name="fname" placeholder="Enter first name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Last Name</label>
                        <input class="form-control" name="lname" placeholder="Enter last name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gender</label>
                        <select class="form-select" name="gender" required>
                            <option value="">Select gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Age</label>
                        <input class="form-control" name="age" type="number" min="1" max="120" placeholder="Enter age" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contact Number</label>
                        <input class="form-control" name="contact_add" type="tel" placeholder="Enter contact number" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input class="form-control" name="cust_email" type="email" placeholder="Enter email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input class="form-control" name="cust_pass" type="password" placeholder="Enter password" required>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Add Customer</button>
                </form>
            </div>
        </div>
    </div>
</div> 