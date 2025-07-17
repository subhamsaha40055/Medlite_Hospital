<?php
  session_start();
  $con = mysqli_connect("localhost", "root", "", "Medlite_Hospital") or die("Connection failed");

  if (!isset($_SESSION["user"]) || $_SESSION["user"] == "" || $_SESSION["usertype"] != 'p') {
      header("location: login.php");
      exit();
  }

  $useremail = $_SESSION["user"];
  $username = $_SESSION['username'];

  $user['email'] = $useremail;
  $user['name'] = $username;

  // Fetch all doctors from the database
  $doctors = [];
  $query = "SELECT * FROM doctors";
  $result = mysqli_query($con, $query);

  if ($result && mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
          $doctors[] = $row;
      }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>All Doctors - Medlite Hospital</title>
  <link rel="stylesheet" href="style4.css"/>
</head>
<body>
  <div class="container">
    <aside class="sidebar">
      <div class="profile">
        <h3><?= htmlspecialchars($user['name']) ?></h3>
        <p><?= htmlspecialchars($user['email']) ?></p>
      </div>
      <form action="logout.php" method="post">
        <button class="logout-btn" type="submit">Log out</button>
      </form>
      <nav class="nav">
        <a href="patient_dashboard.php">🏠 Home</a>
        <a class="active" href="all_doctors.php">👨‍⚕️ All Doctors</a>
        <a href="Appointment.php">📖 Get Appointment</a>
        <a href="edit_patient_info.php">✏️ Edit Profile</a>
      </nav>
    </aside>

    <main class="main-content">
      <header class="header">
        <h2>All Available Doctors</h2>
        <p>Find your preferred doctor and book an appointment.</p>
      </header>

      <section class="doctor-list">
    <div class="table-container">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Doctor Name</th>
          <th>Specialization</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Description</th>
          <th>Consultant Fees</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($doctors as $doc): ?>
          <tr>
            <td data-label="ID"><?= htmlspecialchars($doc['id']) ?></td>
            <td data-label="Doctor Name"><?= htmlspecialchars($doc['name']) ?></td>
            <td data-label="Specialization"><?= htmlspecialchars($doc['specialization']) ?></td>
            <td data-label="Email"><?= htmlspecialchars($doc['email']) ?></td>
            <td data-label="Phone"><?= htmlspecialchars($doc['phone']) ?></td>
            <td data-label="Description"><?= htmlspecialchars($doc['description']) ?></td>
            <td data-label="Consultant Fees">₹<?= htmlspecialchars($doc['consultant_fees']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</section>
    </main>
  </div>
</body>
</html>
