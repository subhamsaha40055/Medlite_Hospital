<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "Medlite_Hospital") or die('connection failed');

if (isset($_SESSION["user"])) {
  if (($_SESSION["user"]) == "" || $_SESSION['usertype'] != 'd') {
    header("location: login.php");
  } else {
    $doctorEmail = $_SESSION["user"];
    $doctorName = $_SESSION['username'];
  }
} else {
  header("location:login.php");
}

// Store doctor details
$doctor['email'] = $doctorEmail;
$doctor['name'] = $doctorName;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Doctor Dashboard</title>
  <link rel="stylesheet" href="style3.css" />
</head>

<body>
  <div class="container">
    <aside class="sidebar">
      <div class="profile">
        <h3><?= htmlspecialchars($doctor['name'] ?? 'Doctor') ?></h3>
        <p><?= htmlspecialchars($doctor['email'] ?? 'unknown@medlite.com') ?></p>
      </div>
      <form action="logout.php" method="post">
        <button class="logout-btn" type="submit">Log out</button>
      </form>
      <nav class="nav">
        <a class="active" href="doctor_dashboard.php">🏠 Dashboard</a>
        <a href="view_appointments.php">📅 Upcoming &nbsp;Appointments</a>
      </nav>
    </aside>

    <main class="main-content">
      <header class="header">
        <div class="welcome">
          <h2>Welcome <?= htmlspecialchars($doctor['name']) ?> 👨‍⚕️</h2>
          <p>Here are your patients and appointments for today.</p>
        </div>
        <div class="date">
          Today's Date <br>
          <?php date_default_timezone_set('Asia/Kolkata'); ?>
          <strong><?= date("Y-m-d") ?></strong>
        </div>
      </header>

      <section class="booking-section">
        <h3>Your Today's Appointments</h3>
        <table>
          <thead>
            <tr>
              <th>Patient Name</th>
              <th>Patient Email</th>
              <th>Date</th>
              <th>Time</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $todayDate = date("Y-m-d");
            $query = "SELECT * FROM appointment WHERE doctor_name = '$doctorName' AND appointment_date = '$todayDate' ORDER BY appointment_time ASC";
            $result = mysqli_query($con, $query);

            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['patient_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['patient_email']) . "</td>";
                echo "<td>" . htmlspecialchars($row['appointment_date']) . "</td>";
                echo "<td>" . htmlspecialchars($row['appointment_time']) . "</td>";
                echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                echo "</tr>";
              }
            } else {
              echo "<tr><td colspan='5'>No appointment's today</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </section>
    </main>
  </div>
</body>

</html>