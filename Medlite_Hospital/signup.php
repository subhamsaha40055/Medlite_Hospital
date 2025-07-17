<?php
// Database credentials
$host = "localhost";
$user = "root";
$password = "";
$dbname = "Medlite_Hospital";

// Create connection
$conn = mysqli_connect($host, $user, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $email = $_POST["email"];
  $contact = $_POST["contact"];
  $gender = $_POST["gender"];
  $password = $_POST["password"];
  $cpassword = $_POST["cpassword"];

  // Check if password and confirm password match
  if ($password != $cpassword) {
    echo "<script>alert('Password and Confirm Password do not match');</script>";
  } else {
    // Check if email or contact already exists
    $checkQuery = "SELECT * FROM patients WHERE email='$email' OR contact='$contact'";
    $result = mysqli_query($conn, $checkQuery);
    if (mysqli_num_rows($result) > 0) {
      echo "<script>alert('Email or Contact Number already exists');</script>";
    } else {
      // Insert into database
      $sql = "INSERT INTO patients (name, email, contact, gender, password)
                       VALUES ('$name', '$email', '$contact', '$gender', '$password')";

      if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Patient registered successfully');</script>";
      }
    }
  }
}
?>


<!DOCTYPE html>
<!---Coding By CodingLab | www.codinglabweb.com--->
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <!--<title>Registration Form in HTML CSS</title>-->
  <!---Custom CSS File--->
  <link rel="stylesheet" href="style.css" />
</head>

<body>
  <section class="container">
    <div class="logo"><img src="Logo banner.jpg" alt="logo"></div>
    <header>Registration Form For Patient</header>
    <form method="post" action="" class="form">
      <div class="input-box">
        <label>Full Name</label>
        <input type="text" name="name" placeholder="Enter full name" required />
      </div>
      <div class="input-box">
        <label>Email Address</label>
        <input type="text" name="email" placeholder="Enter email address" required />
      </div>
      <div class="column">
        <div class="input-box">
          <label>Contact Number</label>
          <input type="number" name="contact" placeholder="Enter Contact Number" required />
        </div>


      </div>
      <div class="gender-box">
        <h3>Gender</h3>
        <div class="gender-option">
          <div class="gender">
            <input type="radio" id="check-male" name="gender" value="Male" checked />
            <label for="check-male">Male</label>

            <input type="radio" id="check-female" name="gender" value="Female" />
            <label for="check-female">Female</label>

            <input type="radio" id="check-other" name="gender" value="Other" />
            <label for="check-other">Others</label>
          </div>
        </div>

        <div class="input-box password">
          <label>Create New Password</label>
          <input type="password" name="password" placeholder="Create New Password" required />

        </div>
        <div class="input-box newpassword">
          <label>Re-Enter Password</label>
          <input type="password" name="cpassword" placeholder="Re-Enter New Password" required />
        </div>
        <input type="submit" value="Register" class="button" />
        <a href="index.php" class="home-button">Back</a>

    </form>
  </section>
</body>

</html>