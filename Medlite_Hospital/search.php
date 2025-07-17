<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "Medlite_Hospital") or die('Connection Failed');

if (!isset($_SESSION["user"]) || $_SESSION['usertype'] != 'p') {
    header("location: login.php");
    exit();
}

$searchResults = [];
$searchQuery = "";

if (isset($_GET['query']) && !empty(trim($_GET['query']))) {
    $searchQuery = mysqli_real_escape_string($con, trim($_GET['query']));

    $sql = "SELECT * FROM doctors 
            WHERE name LIKE '%$searchQuery%' 
            OR specialization LIKE '%$searchQuery%'";

    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $searchResults[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Search Doctors</title>
  <link rel="stylesheet" href="style3.css" />
</head>
<body>
  <div class="container">
    <main class="main-content">
      <header class="header">
        
        <h2>Search Results for "<span><?= htmlspecialchars($searchQuery) ?></span>"</h2>
      </header>

      <section class="booking-section">
        <table>
          <thead>
            <tr>
              <th>Doctor Name</th>
              <th>Specialization</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($searchResults)) : ?>
              <?php foreach ($searchResults as $doctor) : ?>
                <tr>
                  <td><?= htmlspecialchars($doctor['name']) ?></td>
                  <td><?= htmlspecialchars($doctor['specialization']) ?></td>
                  <td><a class="book-btn" href="Appointment.php?doctor_id=<?= $doctor['id'] ?>">Book Now</a></td>
                </tr>
              <?php endforeach; ?>
            <?php else : ?>
              <tr>
                <td colspan="4">No doctors found.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </section>
    </main>
  </div>
</body>
</html>
