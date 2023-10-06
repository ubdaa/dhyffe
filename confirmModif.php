<?php

session_start();

require("include/globalFunction.php");

if($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $username = $_POST["username"];
    $bio = $_POST["bio"];

    $_SESSION["usernameMod"] = $username;
    $_SESSION["nameMod"] = $name;
    $_SESSION["bioMod"] = $bio;

    if (empty($username) || empty($bio) || empty($name)) {
        $_SESSION["err"] = "empty";
        header("Location: ../modifyAccount.php");
        die();
    }

    if ($username != $_SESSION["username"]) {
        if (doesUserExist($username)) {
            $_SESSION["err"] = "usernameAlreadyTaken";
            header("Location: ../modifyAccount.php");
            die();
        }
    }

    modifyAccount($_SESSION["username"]);
    die();

} else {
    header("Location: ../modifyAccount.php");
    die();
}