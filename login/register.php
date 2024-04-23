<?php
   include("connect.php");

   if(isset($_POST["Register"])){
      
     $name=$_POST['user_name'];
     $email=$_POST['email'];
     $password=$_POST['password'];
     $password_again=$_POST['password_again'];

     if ($password != $password_again) {
          echo "Error: Passwords do not match";
      }

      $sql = "SELECT * FROM users WHERE email='$email'";
      $result = $conn->query($sql);
  
      if ($result === false) {
          echo "Error: " . $conn->error;
          exit();
      }
  
      if ($result->num_rows > 0) {
          echo "Error: Email already exists";
          exit();
      }
  
      
      $hashed_password = password_hash($password, PASSWORD_DEFAULT); 
      $sql = "INSERT INTO users (user_name, email, password) VALUES ('$name', '$email', '$hashed_password')";
  
      if ($conn->query($sql) === TRUE) {
          echo "Registration successful";
      } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
      }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<title>Register</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">ELECTRONIC SHOP</a>
    </div>
</nav>

<div class="container">
    <h1 class="mt-5">Register</h1>
    <form action="register.php" method="post" class="mt-4">
        <div class="form-group">
            <label for="user_name">Name:</label>
            <input type="text" class="form-control" id="user_name" name="user_name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="password_again">Password Again:</label>
            <input type="password" class="form-control" id="password_again" name="password_again" required>
        </div>
        <button type="submit" class="btn btn-primary" name="Register">Register</button>
    </form>
    <p class="mt-3">If you already have an account <a href="index.php">Login</a></p>
</div>

</body>
</html>
