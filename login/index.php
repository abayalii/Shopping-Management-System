
<?php
   include("connect.php");

   if(isset($_POST["Login"])){
    
    $email=$_POST['email'];
    $password=$_POST['password'];
     
    $sql = "SELECT * FROM users WHERE email='$email'";
    
    
    $result = $conn->query($sql);

    $count=mysqli_num_rows($result);
  
    if ($count==0) {
          echo "User not found";
          exit();
    }else{
        $login=mysqli_fetch_assoc($result);
        $hashed_password =$login['password'];

        if(password_verify($password,$hashed_password)==TRUE){
            session_start();
            $_SESSION['email']=$login['email'];
            $_SESSION['password']=$login['password'];
            $_SESSION['user_name']=$login['user_name'];

            header("Location: ../home/home.php");

        }else{
            echo "password is not correct";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<title>Login</title>
</head>
<div class="jumbotron text-center">
    <h1 class="display-4">ELECTRONIC SHOP</h1>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h2 class="text-center mb-4">Login</h2>
            <form action="index.php" method="post">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block" name="Login">Login</button>
            </form>
            <p class="mt-3 text-center">If you don't have an account <a href="register.php">Register</a></p>
        </div>
    </div>
</div>


</html>