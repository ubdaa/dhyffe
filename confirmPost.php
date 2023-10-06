<?php

session_start();

require("include/globalFunction.php");

if($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST["title"];
    $content = $_POST["content"];

    $_SESSION["title"] = $title;
    $_SESSION["content"] = $content;

    if (empty($title) || empty($content)) {
        $_SESSION["err"] = "empty";
        header("Location: ../createPost.php");
        die();
    }

    uploadPost($_SESSION["username"]);
    die();

} else {
    header("Location: ../connexion.php");
    die();
}