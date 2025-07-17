<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "Medlite_Hospital") or die('connection failed');

if (isset($_SESSION["user"])) {
    if (($_SESSION["user"]) == "" || $_SESSION['usertype'] != 'ad') {
        header("location: login.php");
    } else {
        $adminEmail = $_SESSION["user"];
        $adminName = "Admin";
    }
} else {
    header("location:login.php");
}

$admin['email'] = $adminEmail;
$admin['name'] = $adminName;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style3.css" />
    <style> 
        .booking-section {
            font-weight: 500;
        }
    </style>
</head>

<body>
    <div class="container">
        <aside class="sidebar">
            <div class="profile">
                <h3><?= htmlspecialchars($admin['name']) ?></h3>
                <p><?= htmlspecialchars($admin['email']) ?></p>
            </div>
            <form action="logout.php" method="post">
                <button class="logout-btn" type="submit">Log out</button>
            </form>
            <nav class="nav">
                <a class="active" href="admin_dashboard.php">🏠 Dashboard</a>
                <a href="add_doctor.php">➕ Add Doctor</a>
                <a href="view_doctors.php"> 👨‍⚕️View Doctors</a>
                <a href="delete_doctor.php">🗑️ Delete Doctor</a>
                <a href="manage_appointments.php">📅 Manage Appointments</a>
                <a href="view_all_patients.php">👨‍⚕️view all Patients</a>
                <a href="delete_patient.php">🗑️ Delete Patient</a>
                <a href="today's_total_fees_collection.php">💵 Today's Fees Collection</a>
                <a href="Monthly_total_fees_collection.php">💰Monthly Fees Collection</a>
            </nav>
        </aside>

        <main class="main-content">
            <header class="header">
                <div class="welcome">
                    <h2>Welcome <?= htmlspecialchars($admin['name']) ?> 🧑‍💼</h2>
                    <p>You have full control over doctors, patients, and appointments.</p>
                </div>
                <div class="date">
                    Today's Date <br>
                    <?php date_default_timezone_set('Asia/Kolkata'); ?>
                    <strong><?= date("Y-m-d") ?></strong>
                </div>
            </header>

            <section class="booking-section">
                <h3>Today's Appointments Overview</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Patient Name</th>
                            <th>Doctor Name</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $todayDate = date("Y-m-d");
                        $query = "SELECT * FROM appointment WHERE appointment_date = '$todayDate' ORDER BY appointment_time ASC";
                        $result = mysqli_query($con, $query);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['patient_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['doctor_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['appointment_date']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['appointment_time']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No appointments scheduled today</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>

</html>