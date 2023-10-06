<?php

session_start();

require("include/globalFunction.php");

if($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];
    $pwdVer = $_POST["pwdVer"];

    $_SESSION["username"] = $username;
    $_SESSION["pwd"] = $pwd;
    $_SESSION["pwdVer"] = $pwdVer;

    if (empty($username) || empty($pwd) || empty($pwdVer)) {
        $_SESSION["err"] = "empty";
        header("Location: ../inscription.php");
        die();
    }

    if ($pwd != $pwdVer) {
        $_SESSION["err"] = "pwd";
        header("Location: ../inscription.php");
        die();
    }

    if (doesUserExist($username)) {
        $_SESSION["err"] = "usernameAlreadyTaken";
        header("Location: ../inscription.php");
        die();
    }

    createAccount($username, $pwd);

} else {
    header("Location: ../inscription.php");
    die();
}