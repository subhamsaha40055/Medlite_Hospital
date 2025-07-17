<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "Medlite_Hospital") or die('Connection failed');

if (!isset($_SESSION["user"]) || $_SESSION['usertype'] != 'p') {
    header("location: login.php");
    exit();
}

$useremail = $_SESSION["user"];
$username = $_SESSION["username"];
$success = "";
$error = "";

// Fetch current info
$sql = "SELECT * FROM patients WHERE email='$useremail'";
$result = mysqli_query($con, $sql);
$patient = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $age = intval($_POST['age']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $contact = mysqli_real_escape_string($con, $_POST['contact']);


    $update = "UPDATE patients SET name='$name', email='$email', age='$age', address='$address', contact='$contact' WHERE email='$useremail'";
    if (mysqli_query($con, $update)) {
        $_SESSION['user'] = $email;
        $_SESSION['username'] = $name;
        $useremail = $email;
        $username = $name;
        $success = "Profile updated successfully!";
    } else {
        $error = "Failed to update profile!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Edit Profile</title>
    <link rel="stylesheet" href="style3.css" />
    <style>
    
        .form-box {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: var(--shadow);
            display: flex;
            flex-direction: column;
            gap: 15px;
            width: 100%;
            margin: 40px auto;
            /* Center the form horizontally */
        }

        .form-box input,
        .form-box textarea {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            width: 100%;
            font-size: 16px;
        }

        .form-box button {
            background-color: #4caf50;
            color: white;
            padding: 10px;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .form-box button:hover {
            background-color: #45a049;
        }

        .status-section {
            display: flex;;
            /* Center the section */
            
            flex-direction: column;
            
        }

        @media (max-width: 768px) {
            
            .container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                height: auto;
                box-shadow: none;
                margin-bottom: 20px;
            }

            .main-content {
                padding: 20px;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
            }
            #address{
                font-size: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <aside class="sidebar">
            <div class="profile">
                <h3><?= htmlspecialchars($username) ?></h3>
                <p><?= htmlspecialchars($useremail) ?></p>
            </div>
            <form action="logout.php" method="post">
                <button class="logout-btn" type="submit">Log out</button>
            </form>
            <nav class="nav">
                <a href="patient_dashboard.php">🏠 Home</a>
                <a href="all_doctors.php">👨‍⚕️ All Doctors</a>
                <a href="appointment.php">📖 Get Appointment</a>
                <a class="active" href="edit_patient_info.php">✏️ Edit Profile</a>
            </nav>
        </aside>

        <main class="main-content">
            <header class="header">
                <div class="welcome">
                    <h2>Edit Your Profile <br><span><?= htmlspecialchars($username) ?></span></h2>
                    <p>You can update your personal information here.</p>
                </div>
                <div class="date">
                    Today's Date <br>
                    <?php date_default_timezone_set('Asia/Kolkata'); ?>
                    <strong><?= date("Y-m-d") ?></strong>
                </div>
            </header>

            <section class="status-section">
                <?php if ($success): ?>
                    <p style="color: green; font-weight: bold;"><?= $success ?></p>
                <?php endif; ?>
                <?php if ($error): ?>
                    <p style="color: red; font-weight: bold;"><?= $error ?></p>
                <?php endif; ?>

                <form action="edit_patient_info.php" method="POST" class="form-box">
                    <label for="name">Full Name:</label>
                    <input type="text" id="name" name="name" required
                        value="<?= htmlspecialchars($patient['name']) ?>" />

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required
                        value="<?= htmlspecialchars($patient['email']) ?>" />

                    <label for="age">Age:</label>
                    <input type="number" id="age" name="age" required
                        value="<?= htmlspecialchars($patient['age'] ?? '') ?>" />

                    <label for="address">Address:</label>
                    <textarea id="address" name="address"
                        required><?= htmlspecialchars($patient['address'] ?? '') ?></textarea>
                    <label for="contact">Contact Number:</label>
                    <input type="text" id="contact" name="contact" required
                        value="<?= htmlspecialchars($patient['contact'] ?? '') ?>" />
                    <button type="submit" class="submit-btn">Update Profile</button>
                </form>
            </section>
        </main>
    </div>
</body>

</html>