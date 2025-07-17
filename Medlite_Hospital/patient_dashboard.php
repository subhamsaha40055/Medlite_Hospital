<?php

session_start();
$con = mysqli_connect("localhost", "root", "", "Medlite_Hospital") or die('connection failed');

if (isset($_SESSION["user"])) {
  if (($_SESSION["user"]) == "" or $_SESSION['usertype'] != 'p') {

    header("location: login.php");
  } else {
    $useremail = $_SESSION["user"];
    $username = $_SESSION['username'];
  }

} else {
  header("location:login.php");
}

// $user = $_SESSION['user'];
$user['email'] = $useremail;
$user['name'] = $username;

// Example
// $bookings = getBookings($user['id']); // You’ll define this function later
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Patient Dashboard</title>
  <link rel="stylesheet" href="style3.css" />
</head>

<body>
  <div class="container">
    <aside class="sidebar">
      <div class="profile">
        <h3><?= htmlspecialchars($user['name'] ?? 'Unknown User') ?></h3>
        <p><?= htmlspecialchars($user['email'] ?? 'Unknown123@gmail.com') ?></p>

      </div>
      <form action="logout.php" method="post">
        <button class="logout-btn" type="submit">Log out</button>
      </form>
      <nav class="nav">
        <a class="active" href="patient_dashboard.php">🏠 Home</a>
        <a href="all_doctors.php">👨‍⚕️ All Doctors</a>
        <a href="appointment.php">📖 Get Appointment</a>
        <a href="edit_patient_info.php">✏️ Edit Profile</a>
      </nav>
    </aside>

    <main class="main-content">
      <header class="header">
        <div class="welcome">
          <h2>Welcome to Medlite Hospital! <br><span><?= htmlspecialchars($user['name'] ?? 'Unknown User') ?>.</span>
          </h2>
          <p>We are here to help you.</p>
          <p>
            Haven’t any idea about doctors? No problem. Let’s jump to
            <strong>"All Doctors".</strong>
          </p>

          <div class="search-box">
            <form action="search.php" method="get">
              <input type="text" name="query" placeholder="Search doctor and book appointment." />
              <button type="submit">Search</button>
            </form>
          </div>
        </div>
        <div class="date">
          Today's Date <br>
          <?php date_default_timezone_set('Asia/Kolkata'); ?>
          <strong><?= date("Y-m-d") ?></strong>
        </div>
      </header>

      <section class="status-section">
        <?php
        // Count total doctors
        $sql = "SELECT COUNT(*) AS total FROM doctors";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        $totalDoctors = $row['total'];
        ?>

        <div class="status-box">
          <h3><?= $totalDoctors ?? 0 ?></h3>
          <p>All Doctors</p>
        </div>
        <?php
        // Count total doctors
        $sql = "SELECT COUNT(*) AS total FROM patients";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        $totalPatients = $row['total'];
        ?>
        <div class="status-box">
          <h3><?= $totalPatients ?? 0 ?></h3>
          <p>All Patients</p>
        </div>
        <?php
        // Count today's appointments for the patient
        $today = date("Y-m-d");
        $sql = "SELECT COUNT(*) AS total FROM appointment WHERE patient_email = '$useremail' AND appointment_date = '$today'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        $todayAppointments = $row['total'];
        ?>
        <div class="status-box">
          <h3><?= $todayAppointments ?? 0 ?></h3>
          <p>Today's Appointments</p>
        </div>

      </section>

      <section class="booking-section">
        <h3>Your Upcoming Booking</h3>
        <table>
          <thead>
            <tr>
              <th>Appoint. Number</th>
              <th>Doctor</th>
              <th>Scheduled Date & Time</th>
              <th>Status</th>
            </tr>
          </thead>
          <?php
          // Get this patient's bookings
          $bookings = [];
          $bookingQuery = "SELECT * FROM appointment WHERE patient_email = '$useremail' ORDER BY appointment_date DESC";
          $bookingResult = mysqli_query($con, $bookingQuery);
          if (mysqli_num_rows($bookingResult) > 0) {
            while ($row = mysqli_fetch_assoc($bookingResult)) {
              $bookings[] = $row;
            }
          }
          ?>
          <tbody>
            <?php if (!empty($bookings)): ?>
              <?php foreach ($bookings as $booking): ?>
                <tr>
                  <td><?= htmlspecialchars($booking['id']) ?></td>
                  <td><?= htmlspecialchars($booking['doctor_name']) ?></td>
                  <td><?= htmlspecialchars($booking['appointment_date'] . ' at ' . $booking['appointment_time']) ?></td>
                  <td><?= htmlspecialchars($booking['status']) ?></td> <!-- ✅ Added status here -->
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="4">
                  <img src="empty.png" alt="No bookings" class="empty-img" />
                </td>
              </tr>
            <?php endif; ?>
          </tbody>

      </section>
    </main>
  </div>
</body>
</html>