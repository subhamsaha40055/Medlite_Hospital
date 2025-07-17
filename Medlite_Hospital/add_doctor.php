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

// Handle form submission
$successMsg = $errorMsg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $specialization = mysqli_real_escape_string($con, $_POST['specialization']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $password = mysqli_real_escape_string($con, $_POST['password']); // Plain text password
    $consultant_fees = mysqli_real_escape_string($con, $_POST['consultant_fees']);
    if ($name != "" && $specialization != "" && $email != "" && $phone != "" && $description != "" && $password != "") {
        $insertQuery = "INSERT INTO doctors (name, specialization, email, phone, description, password, consultant_fees) 
                        VALUES ('$name', '$specialization', '$email', '$phone', '$description', '$password', '$consultant_fees')";
        if (mysqli_query($con, $insertQuery)) {
            $successMsg = "Doctor added successfully!";
        } else {
            $errorMsg = "Error: " . mysqli_error($con);
        }
    } else {
        $errorMsg = "All fields are required!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        .form-section {
            background-color: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .form {
            display: flex;
            flex-direction: column;
        }

        .form label {
            margin-top: 10px;
            font-weight: bold;
        }

        .form input {
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #ccc;
            margin-top: 5px;
        }
        .form textarea {
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #ccc;
            margin-top: 5px;
        }
        .btn-submit {
            margin-top: 20px;
            background-color: #04ba3d;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .btn-submit:hover {
            background-color: rgb(2, 170, 55);
            ;
        }

        .success-msg {
            color: green;
            font-weight: bold;
        }

        .error-msg {
            color: red;
            font-weight: bold;
        }
    </style>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Doctor</title>
    <link rel="stylesheet" href="style3.css" />
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
                <a class="active" href="add_doctor.php">➕ Add Doctor</a>
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
                    <h2>Add New Doctor 🩺</h2>
                    <p>Fill in the details to add a new doctor to the system.</p>
                </div>
                <div class="date">
                    Today's Date <br>
                    <?php date_default_timezone_set('Asia/Kolkata'); ?>
                    <strong><?= date("Y-m-d") ?></strong>
                </div>
            </header>

            <section class="form-section">
                <?php if ($successMsg)
                    echo "<p class='success-msg'>$successMsg</p>"; ?>
                <?php if ($errorMsg)
                    echo "<p class='error-msg'>$errorMsg</p>"; ?>

                <form method="post" class="form">
                    <label for="name">Doctor Name:</label>
                    <input type="text" id="name" name="name" required>

                    <label for="specialization">Specialization:</label>
                    <input type="text" id="specialization" name="specialization" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="phone">Phone:</label>
                    <input type="text" id="phone" name="phone" required>

                    <label for="description">Description:</label>
                    <textarea id="description" name="description" rows="4" required></textarea>

                    <label for="password">Password:</label>
                    <input type="text" id="password" name="password" required>

                    <label for="consultant_fees">Consultant Fees:</label>
                    <input type="text" id="consultant_fees" name="consultant_fees" required>

                    <button type="submit" class="btn-submit">Add Doctor</button>
                </form>
            </section>
        </main>
    </div>
</body>

</html>