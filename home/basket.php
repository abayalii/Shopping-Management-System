<?php
session_start();
include("../login/connect.php");

$user_name = $_SESSION['user_name'];
$email = $_SESSION['email'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Basket</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">ELECTRONIC SHOP</a>
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php"><?php echo strtoupper($user_name); ?></p></a>
                    </li>
                </ul>
            </div>
        </nav>
        <?php

        echo "<h1>My Basket</h1> <br>";
        // Assuming you have a database connection established

        // Retrieve the product_id from the basket table for the current user
        $sql = "SELECT user_id FROM users WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $user_id = $row['user_id'];
        }
        
        $sql = "SELECT basket.product_id, products.name, products.price,products.currency, products.brand, products.description
            FROM basket
            INNER JOIN products ON basket.product_id = products.product_id
            WHERE basket.user_id = $user_id";

        $result = $conn->query($sql);

        if (mysqli_num_rows($result) > 0) {
            // Display the basket items
            $total_price=0;
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<p>". $row['name'] . "</p>";
                echo "<p>". $row['brand'] . "</p>";
                echo "<p>". $row['price'] . ' ' . $row['currency'] . "</p>";
                $total_price+=$row['price'];
                echo "<hr>";
            }
            echo "<p>Total Price: $total_price </p>";

            
            echo '<form action="order.php" method="post">';
            echo '<button type="submit" class="btn btn-primary">Purchase</button>';
            echo '</form>';

            


        } else {
            echo "Basket is empty.";
        }

        

        // Close the database connection
        $conn->close();
        ?>
        
        
    
         
        
    </div>
</body>
</html>