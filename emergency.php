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
    $name    = trim($_POST['name'] ?? '');
    $fname   = trim($_POST['fname'] ?? '');
    $age     = isset($_POST['age']) && is_numeric($_POST['age']) ? (int)$_POST['age'] : 0;
    $aname   = trim($_POST['aname'] ?? '');
    $number  = trim($_POST['number'] ?? '');
    $number2 = trim($_POST['number2'] ?? '');
    $email   = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $date    = trim($_POST['date'] ?? '');

    if (empty($name) || empty($fname) || $age <= 0 || empty($number) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Please fill in all required fields correctly.");
    }

    $stmt = $conn->prepare("INSERT INTO emergency (name, fname, age, aname, number, number2, email, date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("ssisssss", $name, $fname, $age, $aname, $number, $number2, $email, $date);

    if ($stmt->execute()) {
        echo "Emergency Appointment Booked Successfully.<br><br>";
        echo "Thank you for using the online appointment system.";
    } else {
        echo " Error executing query: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
