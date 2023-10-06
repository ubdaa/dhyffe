<?php

session_start();

require("include/globalFunction.php");

if($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];

    $_SESSION["username"] = $username;
    $_SESSION["pwd"] = $pwd;

    if (empty($username) || empty($pwd)) {
        $_SESSION["err"] = "empty";
        header("Location: ../connexion.php");
        die();
    }

    if (!doesUserExist($username)) {
        $_SESSION["err"] = "usernameDoesNotExist";
        header("Location: ../connexion.php");
        die();
    }

    verifyAccount($username, $pwd);

} else {
    header("Location: ../connexion.php");
    die();
}