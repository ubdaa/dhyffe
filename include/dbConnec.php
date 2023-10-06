<?php 

$db = "mysql:host=localhost;dbname=dhyffe";
$user = "root";
$pass = "";

try {
    $pdo = new PDO($db, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // attempt to retry the connection after some timeout for example
    echo $e->getMessage();
}
