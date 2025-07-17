<?php
session_start();
// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="refresh" content="3;url=index.php"> <!-- Redirect after 3 seconds -->
  <title>Logging Out...</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background: #f8f9fa;
    }

    .message-box {
      text-align: center;
      padding: 40px;
      background-color: #ffffff;
      border: 1px solid #dee2e6;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
    }

    .message-box h2 {
      color: #28a745;
    }

    .message-box p {
      margin-top: 10px;
      font-size: 16px;
      color: #333;
    }
  </style>
</head>
<body>
  <div class="message-box">
    <h2>✅ Logged out successfully!</h2>
    <p>Redirecting to the homepage in 3 seconds...</p>
  </div>
</body>
</html>
