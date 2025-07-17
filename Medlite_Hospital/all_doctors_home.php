<?php
// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'Medlite_Hospital') or die('Connection failed');

// Fetch doctors from the database
$sql = "SELECT * FROM doctors";  // Replace 'doctors' with your actual table name if different
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="styles.css" />
    <title>All Doctors - Medlite Hospital</title>
    <style>
        /* Style the table */
        .doctors__table table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .doctors__table th,
        .doctors__table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .doctors__table th {
            background-color:rgba(30, 84, 115, 0.91);
            color: white;

        }

        .doctors__table td {
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <header>
        <nav class="section__container nav__container">
            <div class="nav__logo"><img src="logo2.png" id="nav_image"></div>
            <ul class="nav__links">
                <li class="link"><a href="index.php">Home</a></li>
                <li class="link"><a href="index.php#about">About Us</a></li>
                <li class="link"><a href="index.php#service">Services</a></li>
                <li class="link"><a href="index.php#Doctors">Doctors</a></li>
                <li class="link"><a href="index.php#information">Info</a></li>
            </ul>
            <button class="btn con"><a href="#footer__col">Contact Us</a></button>
        </nav>
    </header>

    <section class="section__container doctors__container" id="Doctors">
        <div class="doctors__header">
            <h2 class="section__header">Our Special Doctors</h2>
            <p>We take pride in our exceptional team of doctors, each a specialist in their respective fields.</p>
        </div>

        <div class="doctors__table">
            <table border="1">
                <thead>
                    <tr>
                        <th>Doctor Name</th>
                        <th>Specialization</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($doctor = mysqli_fetch_assoc($result)) {
                            // Fetch individual doctor data
                            $doctor_name = $doctor['name'];  // Adjust as per your DB column
                            $specialization = $doctor['specialization'];  // Adjust as per your DB column
                            $description = $doctor['description'];  // Adjust as per your DB column
                            ?>
                            <tr>
                                <td><?php echo $doctor_name; ?></td>
                                <td><?php echo $specialization; ?></td>
                                <td><?php echo $description; ?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='3'>No doctors available at the moment.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>

    <footer class="footer">
        <!-- Footer content here -->
    </footer>
</body>

</html>

<?php
// Close the database connection
mysqli_close($conn);
?>