<<<<<<< HEAD
<?php
$host = 'localhost';
$dbname = 'websys';
$username = 'root';
$password = 'admin';
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
=======
<?php
$host = 'localhost';
$dbname = 'websys';
$username = 'root';
$password = 'admin';
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
>>>>>>> 9af54f3f564a4b70b04f1491995f5037957eac8b
?>