<?php

$sql = "SELECT * FROM orders";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "" . $row["address_info"] . "<br>";
        echo "" . $row["order_date"] . "<br>";
        echo "" . $row["price"] . "<br>";
        echo "<br>";
    }
} else {
    echo "No orders found.";
}

$conn->close();
?>