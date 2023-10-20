<?php
session_start();

require("include/globalFunction.php");

if($_SERVER["REQUEST_METHOD"] === "POST") {

    $postId = $_GET["p"];
    $userInfo = getInfoFromUser($_SESSION["username"]);
    $userId = $userInfo[0]['id'];
    $content = $_POST['Content'];

    postComm($postId, $userId, $content);

} else {
    header("Location: ../connexion.php");
    die();
}

?>