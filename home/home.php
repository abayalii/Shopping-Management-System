<?php
session_start();

$user_name = $_SESSION['user_name'];
$email = $_SESSION['email'];
$password = $_SESSION['password'];



include("../login/connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id']) && isset($_POST['action'])) {
    $sql = "SELECT user_id FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];
    }

    if ($_POST['action'] == 'add_to_basket') {
        $product_id = $_POST['product_id'];
        $quantity = 1;

        // Insert data into basket table
        $sql = "INSERT INTO basket (user_id, product_id, quantity) VALUES ('$user_id', '$product_id', '$quantity')";
        if ($conn->query($sql) === TRUE) {
            echo "Product added to basket successfully.";
        } else {
            echo "Error adding product to basket: " . $conn->error;
        }
    } elseif ($_POST['action'] == 'remove_from_basket') {
        $product_id = $_POST['product_id'];

        // Delete data from basket table
        $sql = "DELETE FROM basket WHERE user_id = '$user_id' AND product_id = '$product_id'";
        if ($conn->query($sql) === TRUE) {
            echo "Product removed from basket successfully.";
        } else {
            echo "Error removing product from basket: " . $conn->error;
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
    <title>Home</title>
</head>
<body>
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">ELECTRONIC SHOP</a>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="basket.php">Shopping Basket</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php"><?php echo strtoupper($user_name); ?></a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <h1>Products</h1>
        <div class="row">
            <?php
            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['name']; ?></h5>
                                <p class="card-text"><strong>Brand:</strong> <?php echo $row['brand']; ?></p>
                                <p class="card-text"><strong>Description:</strong> <?php echo $row['description']; ?></p>
                                <p class="card-text"><strong>Features:</strong> <?php echo $row['features']; ?></p>
                                <p class="card-text"><strong>Stock:</strong> <?php echo $row['stock']; ?></p>
                                <p class="card-text"><strong>Price:</strong> <?php echo $row['price'] . ' ' . $row['currency']; ?></p>

                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                                    <input type="hidden" name="action" value="add_to_basket">
                                    <button type="submit" class="btn btn-primary">Add to Basket</button>
                                </form>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                                    <input type="hidden" name="action" value="remove_from_basket">
                                    <button type="submit" class="btn btn-danger" name="remove_from_basket">Remove from Basket</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "No products found.";
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>

