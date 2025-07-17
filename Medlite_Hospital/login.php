<?php
session_start();
$con = new mysqli("localhost", "root", "", "medlite_hospital");

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Determine user type: patient (p), doctor (d), or admin (ad)
if (isset($_POST['patsub']) or isset($_POST['usertype'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $usertype = $_POST['usertype'];

    // Choose table and query based on user type
    if ($usertype == 'p') {
        $stmt = $con->prepare("SELECT * FROM patients WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $password);
    } elseif ($usertype == 'd') {
        $stmt = $con->prepare("SELECT * FROM doctors WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $password);
    } elseif ($usertype == 'ad') {
        $stmt = $con->prepare("SELECT * FROM admin WHERE aemail = ? AND apassword = ?");
        $stmt->bind_param("ss", $email, $password);
    } else {
        die("Invalid user type.");
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if ($usertype == 'p') {
            $_SESSION['pid'] = $row['pid'];
            $_SESSION['username'] = $row['name'];
            $_SESSION['contact'] = $row['contact'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['gender'] = $row['gender'];
            $_SESSION['user'] = $email;
            $_SESSION['usertype'] = 'p';
            header("Location: patient_dashboard.php");
        } elseif ($usertype == 'd') {
            $_SESSION['id'] = $row['id']; // Make sure the doctors table uses 'did'
            $_SESSION['username'] = $row['name'];
            $_SESSION['email'] = $row['docemail'];
            $_SESSION['user'] = $email;
            $_SESSION['usertype'] = 'd';
            header("Location: doctor_dashboard.php");
        } elseif ($usertype == 'ad') {
            $_SESSION['user'] = $email;
            $_SESSION['usertype'] = 'ad';
            header("Location: admin_dashboard.php"); // Correct dashboard
        }
    } else {
        echo "<script>alert('Invalid email or password. Try again!');
              window.location.href = 'index.php';</script>";
    }

    $stmt->close();
}
$con->close();
?>