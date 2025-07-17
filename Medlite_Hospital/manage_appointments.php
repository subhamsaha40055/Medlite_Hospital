<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "Medlite_Hospital") or die('Connection failed');

if (!isset($_SESSION["user"]) || $_SESSION["usertype"] != 'ad') {
    header("location: ../login.php");
    exit();
}

// Handle approval/cancellation
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $actionType = $_GET['action'];

    // Get patient details
    $query = "SELECT patient_name, patient_email, doctor_name, appointment_date, appointment_time FROM appointment WHERE id = $id";
    $result = mysqli_query($con, $query);
    $appointment = mysqli_fetch_assoc($result);

    if ($appointment) {
        $patientName = $appointment['patient_name'];
        $patientEmail = $appointment['patient_email'];
        $doctorName = $appointment['doctor_name'];
        $appDate = $appointment['appointment_date'];
        $appTime = $appointment['appointment_time'];

        $status = $actionType == 'approve' ? 'Approved' : 'rejected';
        $update = "UPDATE appointment SET status = '$status' WHERE id = $id";
        mysqli_query($con, $update);

        if ($actionType == 'approve') {
            // Send email
            $subject = "Appointment Approved - Medlite Hospital";
            $message = "Dear $patientName,\n\nYour appointment with  $doctorName on $appDate at $appTime has been approved.\n\nThank you,\nMedlite Hospital";
            $headers = "From: medlitehospital@example.com"; // Replace with your hospital email

            mail($patientEmail, $subject, $message, $headers);
        }
    }

    header("Location: manage_appointments.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manage Appointments</title>
    <link rel="stylesheet" href="style3.css" />
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <div class="profile">
                <h3>Admin</h3>
                <p><?= htmlspecialchars($_SESSION["user"]) ?></p>
            </div>
            <form action="logout.php" method="post">
                <button class="logout-btn" type="submit">Log out</button>
            </form>
            <nav class="nav">
                <a href="admin_dashboard.php">🏠 Dashboard</a>
                <a href="add_doctor.php">➕ Add Doctor</a>
                <a href="view_doctors.php"> 👨‍⚕️ View Doctors</a>
                <a href="delete_doctor.php">🗑️ Delete Doctor</a>
                <a class="active" href="manage_appointments.php">📅 Manage Appointments</a>
                <a href="view_all_patients.php">👨‍⚕️ View All Patients</a>
                <a href="delete_patient.php">🗑️ Delete Patient</a>
                <a href="today's_total_fees_collection.php">💵 Today's Fees Collection</a>
                <a href="Monthly_total_fees_collection.php">💰 Monthly Fees Collection</a>
            </nav>
        </aside>

        <main class="main-content">
            <header class="header">
                <div class="welcome">
                    <h2>All Appointments</h2>
                    <p>Approve or cancel appointments below.</p>
                </div>
                <div class="date">
                    Today's Date <br>
                    <?php date_default_timezone_set('Asia/Kolkata'); ?>
                    <strong><?= date("Y-m-d") ?></strong>
                </div>
            </header>

            <section class="booking-section">
                <h3>Appointments List</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Patient Name</th>
                            <th>Doctor Name</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = mysqli_query($con, "SELECT * FROM appointment ORDER BY appointment_date DESC, appointment_time ASC");

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . htmlspecialchars($row['patient_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['doctor_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['appointment_date']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['appointment_time']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                                echo "<td>";

                                if ($row['status'] === 'Pending') {
                                    echo "<a href='manage_appointments.php?action=approve&id=" . $row['id'] . "' class='btn-approve'>Approve</a> ";
                                    echo "<a href='manage_appointments.php?action=cancel&id=" . $row['id'] . "' class='btn-cancel'>Cancel</a>";
                                } else {
                                    echo "No Action Needed";
                                }

                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No appointments found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>
