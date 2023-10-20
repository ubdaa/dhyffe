<?php

session_start();

require("include/globalFunction.php");

if(isset($_SESSION["connState"])) {
    if ($_SESSION["connState"] === 0) {
        header("Location ../accueil.php");
        die();
    } 
} else {
    header("Location: ../accueil.php");
    die();
}

$infos = getInfoFromUser($_SESSION["username"]);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Création de post - Dhyffe</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div class="header">
            <img src="images/dhyffe-logo.png" alt="">
            <h1>Dhyffe</h1>
        </div>
        <div class="dashboard">
            <div class="profil">
                    <?php
                        if(isset($_SESSION["connState"]) && $_SESSION["connState"] === 1) {
                            echo '<img src="' . $infos[0]["pdpPath"] .'" alt="">
                            <p>' . $infos[0]["name"] . '</p>
                            <p class="pseudoAt">@' . $infos[0]["username"] . '</p>';
                        } else {
                            echo '
                            <img src="images/default-avatar.jpg" alt="">
                            <p>Déconnecté</p>';
                        }
                    ?>
            </div>
                <?php
                    if (isset($state) && $state === 1) {
                        echo '
                        <a href="accueil.php"><button><span class="material-symbols-rounded">home</span>Accueil</button></a><br>
                        <a href="profil.php?p=' . $infos[0]["username"] . '"><button><span class="material-symbols-rounded">account_circle</span>Profil</button></a><br>
                        <a href="createPost.php"><button><span class="material-symbols-rounded">post_add</span>Créer un post</button></a><br>
                        <a href="logOut.php"><button class="logout"><span class="material-symbols-rounded">logout</span>Déconnexion</button></a>';
                    } else {
                        echo '
                        <a href="accueil.php"><button><span class="material-symbols-rounded">home</span>Accueil</button></a><br>
                        <a href="connexion.php"><button class="logout"><span class="material-symbols-rounded">login</span>Se connecter</button></a>';
                    }
                ?>
            </div>
        </div>

        <div class="main">
            <div class="postLine">
                
                <div class="post">
                    <div class="modifyTitle">
                        <p>Création de post !</p>

                        <?php
                            if(isset($_SESSION["err"]) &&  $_SESSION["err"] === "empty") {
                                echo '<div class="error">
                                    <p>Veuillez remplir tous les champs !</p>
                                </div>';
                                unset($_SESSION["err"]);
                            };    
                        ?>
                    </div>
                </div>
                
                <div class="post">
                    <div class="compte">
                        <form action="confirmPost.php" method="post">

                            <div class="profil">
                                <?php
                                    echo '<img src="' . $infos[0]["pdpPath"] .'" alt="">
                                    <p>' . $infos[0]["name"] . '</p>
                                    <p class="pseudoAt">@' . $infos[0]["username"] . '</p>';
                                ?>
                            </div>
                            
                            <hr>

                            <div class="postCreation">
                                
                                <?php 
                                    if (isset($_SESSION["title"])) {
                                        echo '<input type="text" name="title" placeholder="Votre titre" value=' . $_SESSION["title"] . '>';
                                    } else {
                                        echo '<input type="text" name="title" placeholder="Votre titre">';
                                    }

                                    if (isset($_SESSION["content"])) {
                                        echo '<textarea name="content" id="" placeholder="Le contenu de votre post">' . $_SESSION["content"] . '</textarea>';
                                    } else {
                                        echo '<textarea name="content" id="" placeholder="Le contenu de votre post"></textarea>'; 
                                    }
                                ?>

                                <button><span class="material-symbols-rounded">send</span>Poster</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <script src="modify.js"></script>
    </body>
</html>