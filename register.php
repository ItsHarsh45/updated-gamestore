<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Form</title>
  <link rel="stylesheet" href="styles.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <style>
    body{
      background-image: url("images/bg.png");
    }
    </style>
</head>
<body>
  <div class="wrapper">
    <form action="register.php" method="post">
      <h1>Register</h1>
      <div class="input-box">
        <input type="text" placeholder="Username" name="username" required>
        <i class='bx bxs-user'></i>
      </div>
      <div class="input-box">
        <input type="email" placeholder="Email" name="email" required>
        <i class='bx bxs-envelope'></i>
      </div>
      <div class="input-box">
        <input type="password" placeholder="Password" name="password" required>
        <i class='bx bxs-lock-alt'></i>
      </div>
      <div class="input-box">
        <input type="password" placeholder="Confirm Password" required>
        <i class='bx bxs-lock-alt'></i>
      </div>
      <button type="submit" class="btn">Register</button>
      <div class="register-link">
        <p>Already have an account? <a href="login.php">Login</a></p>
      </div>
    </form>
  </div>
</body>
</html>
<?php
$conn = mysqli_connect("localhost","root","");
if ($_SERVER["REQUEST_METHOD"]=="POST"){
  $username=htmlspecialchars($_POST["username"]);
  $email=htmlspecialchars($_POST["email"]);
  $password=htmlspecialchars($_POST["password"]);
  $query="INSERT INTO websitelogin.logindetails VALUES('','$username','$email','$password')";
  mysqli_query($conn,$query);
  echo "<script>alert('Account added succesfully');window.location.href='login.php';</script>";
}
?>