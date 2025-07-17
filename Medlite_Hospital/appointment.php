<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "Medlite_Hospital") or die('Connection Failed');

if (!isset($_SESSION["user"]) || $_SESSION['usertype'] != 'p') {
  header("location: login.php");
  exit();
}

$useremail = $_SESSION["user"];
$username = $_SESSION['username'];
$doctors = mysqli_query($con, "SELECT name FROM doctors");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Book Appointment</title>
  <link rel="stylesheet" href="style5.css"/>
</head>
<body>
  <div class="container">
    <div class="logo"><img src="Logo banner.jpg" alt="logo"></div>
    <h2>Book an Appointment</h2>
    <form method="post" action="payment.php">
      <label>Select Doctor</label><br>
      <select name="doctor_name" required>
        <option value="">-- Choose Doctor --</option>
        <?php while($doc = mysqli_fetch_assoc($doctors)): ?>
          <option value="<?= htmlspecialchars($doc['name']) ?>"><?= htmlspecialchars($doc['name']) ?></option>
        <?php endwhile; ?>
      </select><br>

      <label>Appointment Date</label><br>
      <input type="date" name="appointment_date" required><br>
      
      <label>Appointment Time</label><br>
      <select name="appointment_time" required>
        <option value="">-- Select Time --</option>
        <?php
          $start = strtotime("08:00 AM");
          $end = strtotime("08:00 PM");
          for ($time = $start; $time <= $end; $time += 30 * 60) {
            $formatted = date("h:i A", $time);
            echo "<option value=\"$formatted\">$formatted</option>";
          }
        ?>
      </select><br>

      <input type="hidden" name="amount" value="300.00">

      <button type="submit">Proceed to Payment</button>
      <a href="patient_dashboard.php" class="home-button">Go to Patient Dashboard</a>
    </form>
  </div>
</body>
</html>
