<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "Medlite_Hospital") or die('Connection Failed');

if (isset($_SESSION["user"])) {
    if ($_SESSION["user"] == "" || $_SESSION['usertype'] != 'ad') {
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

$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $doctor_id = trim($_POST['doctor_id']);
    $doctor_name = trim($_POST['doctor_name']);

    if ($doctor_id != "" && $doctor_name != "") {
        $check = "SELECT * FROM doctors WHERE id = '$doctor_id' AND name = '$doctor_name'";
        $result = mysqli_query($con, $check);

        if (mysqli_num_rows($result) > 0) {
            $delete = "DELETE FROM doctors WHERE id = '$doctor_id' AND name = '$doctor_name'";
            mysqli_query($con, $delete);
            $msg = "✅ Doctor deleted successfully!";
        } else {
            $msg = "❌ No doctor found with given ID and Name.";
        }
    } else {
        $msg = "⚠️ Please provide both Doctor ID and Name.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Delete Doctor</title>
    <link rel="stylesheet" href="style3.css" />
    <style>
        .form-container {
            background: #fff;
            padding: 30px;
            max-width: 500px;
            margin: 30px auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-weight: 500;
        }

        .form-container h2 {
            margin-bottom: 20px;
        }

        .form-container input[type="text"],
        .form-container button {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .form-container button {
            background: #d9534f;
            color: white;
            border: none;
            font-weight: bold;
            cursor: pointer;
        }

        .form-container button:hover {
            background: #c9302c;
        }

        .message {
            text-align: center;
            font-weight: bold;
            margin-top: 10px;
        }

        .message.success {
            color: green;
        }

        .message.error {
            color: red;
        }

        .message.warning {
            color: orange;
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
                <a class="active" href="delete_doctor.php">🗑️ Delete Doctor</a>
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
                    <h2>Delete Existing Doctor 🩺</h2>
                    <p>Fill in the details to delete a existing doctor from the system.</p>
                </div>
            </header>
            <div class="form-container">
                <h2>🗑️ Delete Doctor</h2>
                <form method="post">
                    <label>Doctor ID:</label>
                    <input type="text" name="doctor_id" placeholder="Enter Doctor ID" required>

                    <label>Doctor Name:</label>
                    <input type="text" name="doctor_name" placeholder="Enter Doctor Name" required>

                    <button type="submit">Delete Doctor</button>
                </form>
                <?php if ($msg != ""): ?>
                    <p class="message <?= strpos($msg, '✅') !== false ? 'success' : (strpos($msg, '❌') !== false ? 'error' : 'warning') ?>">
                        <?= $msg ?>
                    </p>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>

</html>
