<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "patient";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'] ?? '';
    $fname = $_POST['fname'] ?? '';
    $number = $_POST['number'] ?? '';
    $email = $_POST['email'] ?? '';
    $age = isset($_POST['age']) ? (int)$_POST['age'] : 0;
    $date = $_POST['date'] ?? '';

    $stmt = $conn->prepare("INSERT INTO appointment (name, fname, number, email, age, date) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssssis", $name, $fname, $number, $email, $age, $date);

    if ($stmt->execute()) {
        echo " OPD Appointment booked successfully !!!";
    } else {
        echo "Execute failed: " . $stmt->error;
    }

    $stmt->close();
} 

$conn->close();
?>