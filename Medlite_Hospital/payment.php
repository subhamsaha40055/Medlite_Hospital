<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "Medlite_Hospital") or die('Connection Failed');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['doctor_name'])) {
    $doctor_name = mysqli_real_escape_string($con, $_POST['doctor_name']);
    $date = $_POST['appointment_date'];
    $time = $_POST['appointment_time'];

    // Fetch consultant_fees from doctors table
    $query = "SELECT consultant_fees FROM doctors WHERE name = '$doctor_name' LIMIT 1";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $doctor = mysqli_fetch_assoc($result);
        $amount = $doctor['consultant_fees'];

        $_SESSION['booking'] = [
            'doctor_name' => $doctor_name,
            'appointment_date' => $date,
            'appointment_time' => $time,
            'amount' => $amount
        ];
    } else {
        echo "<script>alert('Doctor not found. Please try again.'); window.location.href='Appointment.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Secure Payment | Medlite Hospital</title>
    <link rel="stylesheet" href="style5.css" />
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f8fb;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .payment-form {
            background: white;
            padding: 30px;
            border-radius: 15px;
            max-width: 450px;
            width: 100%;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .payment-form h3 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        .card-logos {
            text-align: center;
            margin-bottom: 20px;
        }

        .card-logos img {
            width: 50px;
            margin: 0 10px;
        }

        .payment-form label {
            display: block;
            margin: 10px 0 5px;
            font-weight: 600;
        }

        .payment-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }

        .payment-form button {
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            color: white;
            border: none;
            font-size: 16px;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .payment-form button:hover {
            background-color: #218838;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cardNumberInput = document.getElementById('card_number');
            cardNumberInput.addEventListener('input', function (e) {
                let value = e.target.value.replace(/\D/g, '');
                value = value.substring(0, 16);
                let formatted = value.match(/.{1,4}/g);
                e.target.value = formatted ? formatted.join(' ') : '';
            });
        });

    </script>

</head>

<body>

    <div class="payment-form">
        <h3>Card Payment</h3>

        <div class="card-logos">
            <img src="https://img.icons8.com/color/48/visa.png" alt="Visa">
            <img src="https://img.icons8.com/color/48/mastercard.png" alt="MasterCard">
            <img src="rupay_logo.png" alt="RuPay" class="card-logo" style="width: 80px; ">
        </div>

        <form method="post" action="process_payment.php">
            <label for="card_name">Card Holder Name</label>
            <input type="text" name="card_name" id="card_name" required placeholder="Name on Card">

            <label>Card Number</label><br>
            <input type="text" name="card_number" id="card_number" maxlength="19" required
                placeholder="1234 5678 9012 3456">

            <label for="expiry">Expiry Date</label>
            <input type="month" name="expiry" id="expiry" required>

            <label for="cvv">CVV</label>
            <input type="password" name="cvv" id="cvv" pattern="\d{3}" required placeholder="e.g. 123">

            <button type="submit">Pay ₹<?= htmlspecialchars($_SESSION['booking']['amount']) ?></button>
        </form>
    </div>
</body>

</html>