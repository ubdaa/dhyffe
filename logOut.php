<?php

session_start();

unset($_SESSION["username"]);
unset($_SESSION["connState"]);

header("Location: ../accueil.php");