<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "Medlite_Hospital") or die('Connection Failed');

if (!isset($_SESSION["user"], $_SESSION['booking']) || $_SESSION['usertype'] != 'p') {
  header("location: login.php");
  exit();
}

$username = $_SESSION['username'];
$useremail = $_SESSION['user'];
$booking = $_SESSION['booking'];
$amount = $booking['amount'];
$doctor_name = mysqli_real_escape_string($con, $booking['doctor_name']);
$date = $booking['appointment_date'];
$time = $booking['appointment_time'];

// Simulated payment success
$payment_status = "Success";

$payment_query = "INSERT INTO payment (patient_email, doctor_name, appointment_date, appointment_time, amount, status)
                  VALUES ('$useremail', '$doctor_name', '$date', '$time', '$amount', '$payment_status')";

if (mysqli_query($con, $payment_query)) {
  $appointment_query = "INSERT INTO appointment (patient_name, patient_email, doctor_name, appointment_date, appointment_time, status)
                        VALUES ('$username', '$useremail', '$doctor_name', '$date', '$time', 'Pending')";
  if (mysqli_query($con, $appointment_query)) {
    // Email confirmation
    
    $subject = "Appointment & Payment Successful";
    $message = "Dear $username,\n\nYour payment of ₹$amount was successful. Your appointment with $doctor_name is pending approval.\n\nDate: $date\nTime: $time\n\nThank you!";
    $headers = "From: no-reply@medlitehospital.com";
    mail($useremail, $subject, $message, $headers);

    unset($_SESSION['booking']); // Clear session

    echo "<script>alert('Payment successful! Appointment booked.'); window.location.href='patient_dashboard.php';</script>";
  } else {
    echo "<script>alert('Error booking appointment');</script>";
  }
} else {
  echo "<script>alert('Payment failed. Try again.'); window.location.href='book_appointment.php';</script>";
}
?>
