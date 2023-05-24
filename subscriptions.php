<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "arbuzapi";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_POST['customer_id'];
    $product_ids = $_POST['product_ids'];
    $day_of_week = $_POST['day_of_week'];
    $delivery_period = $_POST['delivery_period'];
    $delivery_address = $_POST['delivery_address'];
    $delivery_phone_number = $_POST['delivery_phone_number'];

    $sql = "INSERT INTO Subscriptions (customer_id, product_ids, day_of_week, delivery_period, delivery_address, delivery_phone_number)
            VALUES ('$customer_id', '$product_ids', '$day_of_week', '$delivery_period', '$delivery_address', '$delivery_phone_number')";

    if ($conn->query($sql) === TRUE) {
        $response = array("message" => "Subscription created successfully");
        echo json_encode($response);
    } else {
        $response = array("error" => "Error creating subscription: " . $conn->error);
        echo json_encode($response);
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $putData);
    $subscription_id = $putData['subscription_id'];
    $customer_id = $putData['customer_id'];
    $product_ids = $putData['product_ids'];
    $day_of_week = $putData['day_of_week'];
    $delivery_period = $putData['delivery_period'];
    $delivery_address = $putData['delivery_address'];
    $delivery_phone_number = $putData['delivery_phone_number'];

    $sql = "UPDATE Subscriptions SET
                customer_id = '$customer_id',
                product_ids = '$product_ids',
                day_of_week = '$day_of_week',
                delivery_period = '$delivery_period',
                delivery_address = '$delivery_address',
                delivery_phone_number = '$delivery_phone_number'
            WHERE subscription_id = '$subscription_id'";

    if ($conn->query($sql) === TRUE) {
        $response = array("message" => "Subscription updated successfully");
        echo json_encode($response);
    } else {
        $response = array("error" => "Error updating subscription: " . $conn->error);
        echo json_encode($response);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $deleteData);
    $subscription_id = $deleteData['subscription_id'];

    $sql = "DELETE FROM Subscriptions WHERE subscription_id = '$subscription_id'";

    if ($conn->query($sql) === TRUE) {
        $response = array("message" => "Subscription deleted successfully");
        echo json_encode($response);
    } else {
        $response = array("error" => "Error deleting subscription: " . $conn->error);
        echo json_encode($response);
    }
}

$conn->close();
?>
