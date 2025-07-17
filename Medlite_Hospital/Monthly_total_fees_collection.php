<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "Medlite_Hospital") or die('Connection failed');

if (isset($_SESSION["user"])) {
    if ($_SESSION["user"] == "" || $_SESSION['usertype'] != 'ad') {
        header("location: login.php");
        exit();
    } else {
        $adminEmail = $_SESSION["user"];
        $adminName = "Admin";
    }
} else {
    header("location: login.php");
    exit();
}

$admin['email'] = $adminEmail;
$admin['name'] = $adminName;

// Get current year and month
$currentYear = date("Y");
$currentMonth = date("m");

$query = "SELECT * FROM payment WHERE YEAR(payment_date) = '$currentYear' AND MONTH(payment_date) = '$currentMonth' AND status = 'Success' ORDER BY payment_date DESC";
$result = mysqli_query($con, $query);

// Get total monthly amount
$sumQuery = "SELECT SUM(amount) AS total FROM payment WHERE YEAR(payment_date) = '$currentYear' AND MONTH(payment_date) = '$currentMonth' AND status = 'Success'";
$sumResult = mysqli_query($con, $sumQuery);
$sumRow = mysqli_fetch_assoc($sumResult);
$totalAmount = $sumRow['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Monthly Fees Collection</title>
    <link rel="stylesheet" href="style3.css" />
    <style>
        .collection-section {
            font-weight: 500;
        }

        .total-box {
            margin-top: 15px;
            font-weight: bold;
            font-size: 1.1rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background-color: #f5f5f5;
        }

        th, td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            font-weight: bold;
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
            <a href="admin_dashboard.php">🏠 Dashboard</a>
            <a href="add_doctor.php">➕ Add Doctor</a>
            <a href="view_doctors.php">👨‍⚕️ View Doctors</a>
            <a href="delete_doctor.php">🗑️ Delete Doctor</a>
            <a href="manage_appointments.php">📅 Manage Appointments</a>
            <a href="view_all_patients.php">👨‍⚕️ View All Patients</a>
            <a href="delete_patient.php">🗑️ Delete Patient</a>
            <a href="today's_total_fees_collection.php">💵 Today's Fees Collection</a>
            <a class="active" href="Monthly_total_fees_collection.php">💰Monthly Fees Collection</a>
        </nav>
    </aside>

    <main class="main-content">
        <header class="header">
            <div class="welcome">
                <h2>Monthly Fees Overview 💰</h2>
                <p>Displaying successful payments made this month.</p>
            </div>
            <div class="date">
                Current Month <br>
                <strong><?= date("F Y") ?></strong>
            </div>
        </header>

        <section class="collection-section">
            <h3>Monthly Payments</h3>
            <table>
                <thead>
                <tr>
                    <th>Patient Email</th>
                    <th>Doctor Name</th>
                    <th>Appointment Date</th>
                    <th>Appointment Time</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Payment Time</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['patient_email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['doctor_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['appointment_date']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['appointment_time']) . "</td>";
                        echo "<td>₹" . number_format($row['amount'], 2) . "</td>";
                        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['payment_date']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No payments found for this month.</td></tr>";
                }
                ?>
                </tbody>
            </table>

            <div class="total-box">
                Total Fees Collected This Month: <strong>₹<?= number_format($totalAmount, 2) ?></strong>
            </div>
        </section>
    </main>
</div>
</body>
</html>
