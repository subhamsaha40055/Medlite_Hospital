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
    <title>Today's Total Fees Collection</title>
    <link rel="stylesheet" href="style3.css" />
    <style>
        .fees-summary {
            font-weight: 500;
            margin-top: 20px;
        }

        .fees-summary table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .fees-summary th, .fees-summary td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        .total-amount {
            font-size: 1.2rem;
            margin-top: 20px;
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
                <a href="view_doctors.php"> 👨‍⚕️View Doctors</a>
                <a href="delete_doctor.php">🗑️ Delete Doctor</a>
                <a href="manage_appointments.php">📅 Manage Appointments</a>
                <a href="view_all_patients.php">👨‍⚕️view all Patients</a>
                <a href="delete_patient.php">🗑️ Delete Patient</a>
                <a class="active" href="today's_total_fees_collection.php">💵 Today's Fees Collection</a>
                <a href="Monthly_total_fees_collection.php">💰 Monthly Fees Collection</a>
            </nav>
        </aside>

        <main class="main-content">
            <header class="header">
                <div class="welcome">
                    <h2>Today's Fees Collection 💵</h2>
                    <p>Overview of all payments collected today.</p>
                </div>
                <div class="date">
                    Today's Date <br>
                    <?php date_default_timezone_set('Asia/Kolkata'); ?>
                    <strong><?= date("Y-m-d") ?></strong>
                </div>
            </header>

            <section class="fees-summary">
                <h3>Payment Records</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Payment ID</th>
                            <th>Patient Email</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $todayDate = date("Y-m-d");
                        $query = "SELECT * FROM payment WHERE DATE(payment_date) = '$todayDate'";
                        $result = mysqli_query($con, $query);

                        $total = 0;
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['patient_email']) . "</td>";
                                echo "<td>₹" . htmlspecialchars($row['amount']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['payment_date']) . "</td>";
                                echo "</tr>";
                                $total += $row['amount'];
                            }
                        } else {
                            echo "<tr><td colspan='4'>No payments collected today</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <div class="total-amount">
                    Total Fees Collected Today: ₹<?= $total ?>
                </div>
            </section>
        </main>
    </div>
</body>

</html>
