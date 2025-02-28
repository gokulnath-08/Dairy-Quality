<?php
$servername = "localhost";
$username = "root";
$password = "gOkulnathalagesan08@";
$dbname = "dairy_qr";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>