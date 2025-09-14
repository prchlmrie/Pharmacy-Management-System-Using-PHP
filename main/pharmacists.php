<?php
include 'db.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $contact_add = $_POST['contact_add'];
    $phar_email = $_POST['phar_email'];
    $phar_pass = $_POST['phar_pass'];
    $sql = "INSERT INTO pharmacist (fname, lname, gender, age, contact_add, phar_email, phar_pass) VALUES ('$fname', '$lname', '$gender', $age, $contact_add, '$phar_email', '$phar_pass')";
    $conn->query($sql);
    header('Location: index.php?section=pharmacists');
    exit();
}

// Fetch pharmacists
$result = $conn->query('SELECT * FROM pharmacist');
?>
<div class="row mb-4">
  <div class="col-md-8">
    <h2 class="mb-3">Pharmacists</h2>
    <div class="table-responsive">
      <table class="table table-bordered table-hover bg-white">
        <thead class="table-light">
          <tr>
            <th>ID</th><th>First Name</th><th>Last Name</th><th>Gender</th><th>Age</th><th>Contact</th><th>Email</th>
          </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $row['phar_ID'] ?></td>
            <td><?= $row['fname'] ?></td>
            <td><?= $row['lname'] ?></td>
            <td><?= $row['gender'] ?></td>
            <td><?= $row['age'] ?></td>
            <td><?= $row['contact_add'] ?></td>
            <td><?= $row['phar_email'] ?></td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <h5 class="card-title mb-3">Add Pharmacist</h5>
        <form method="post">
          <div class="mb-2"><input class="form-control" name="fname" placeholder="First Name" required></div>
          <div class="mb-2"><input class="form-control" name="lname" placeholder="Last Name" required></div>
          <div class="mb-2"><input class="form-control" name="gender" placeholder="Gender" required></div>
          <div class="mb-2"><input class="form-control" name="age" type="number" placeholder="Age" required></div>
          <div class="mb-2"><input class="form-control" name="contact_add" type="number" placeholder="Contact Address" required></div>
          <div class="mb-2"><input class="form-control" name="phar_email" type="email" placeholder="Email" required></div>
          <div class="mb-2"><input class="form-control" name="phar_pass" type="password" placeholder="Password" required></div>
          <button class="btn btn-primary w-100" type="submit">Add Pharmacist</button>
        </form>
      </div>
    </div>
  </div>
</div> 