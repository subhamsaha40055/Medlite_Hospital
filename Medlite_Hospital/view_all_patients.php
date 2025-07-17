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
    <title>View All Patients</title>
    <link rel="stylesheet" href="style3.css" />
    <style>
        .patient-section {
            font-weight: 500;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        table thead {
            background-color:rgb(10, 72, 110);
            color: white;
        }

        table th,
        table td {
            padding: 12px 15px;
            text-align: center;
        }

        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tbody tr:hover {
            background-color: #e6f0ff;
            transition: background-color 0.3s;
        }

        table td {
            font-size: 15px;
            color: #333;
        }

        table th {
            font-size: 16px;
            font-weight: 600;
        }

        h3 {
            color: #333;
            margin-bottom: 10px;
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
                <a class="active" href="view_all_patients.php">👨‍⚕️ View All Patients</a>
                <a href="delete_patient.php">🗑️ Delete Patient</a>
                <a href="today's_total_fees_collection.php">💵 Today's Fees Collection</a>
                <a href="Monthly_total_fees_collection.php">💰Monthly Fees Collection</a>
            </nav>
        </aside>

        <main class="main-content">
            <header class="header">
                <div class="welcome">
                    <h2>All Patients 👨‍⚕️</h2>
                    <p>List of all registered patients in the system.</p>
                </div>
                <div class="date">
                    Today's Date <br>
                    <?php date_default_timezone_set('Asia/Kolkata'); ?>
                    <strong><?= date("Y-m-d") ?></strong>
                </div>
            </header>

            <section class="patient-section">
                <h3>All Registered Patients</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Patient ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Gender</th>
                            <th>Age</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM patients ORDER BY id DESC";
                        $result = mysqli_query($con, $query);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['contact']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['age']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No patients found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>

</html>