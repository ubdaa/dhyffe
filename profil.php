<?php
    session_start();

    require("include/globalFunction.php");

    $infosPage = getInfoFromUser($_GET["p"]);
    if (isset($_SESSION["username"])) {
        $infos = getInfoFromUser($_SESSION["username"]);
    }

    function exist() {
        $infosPage = getInfoFromUser($_GET["p"]);

        if (empty($infosPage)) {
            $exist = 0;
        } else {
            $exist = 1;
        }

        if ($exist === 1) {
            return true;
        } else {
            return false;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <?php 
        if(exist()) {
            echo '<title>Profil : @' . $infosPage[0]["username"] . ' - Dhyffe</title>' ;
        } else {
            echo '<title>Profil inexistant - Dhyffe</title>' ;
        }
        
        ?>
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

        <div class="main">
            <div class="postLine">
                <div class="post">
                    <div class="compte">

                        <div class="profil">

                            <?php 
                                if(exist()) {
                                    echo '<img src="' . $infosPage[0]["pdpPath"] .'" alt="">
                                    <p>' . $infosPage[0]["name"] . '</p>
                                    <p class="pseudoAt">@' . $infosPage[0]["username"] . '</p>';
                                } else {
                                    echo '<img src="images/default-avatar.jpg" alt="">
                                    <p>Ce profil n\'existe pas</p>';
                                }

                                if (exist()) {
                                    if(isset($infos)) {
                                        if ($infos[0]["username"] === $infosPage[0]["username"]) {
                                            echo '<form action="modifyAccount.php" method="post">
                                            <button><span class="material-symbols-rounded">edit</span></button>
                                            </form>';
                                        }
                                    }
                                }
                                
                            ?>

                        </div>

                        <div class="biographie">

                            <h4>Biographie</h4>
                            <?php 
                                if (exist()) {
                                    echo '<p>'. $infosPage[0]["bio"] .'</p>'; 
                                } else {
                                    echo '<p>Ce profil n\'existe pas ou n\'existe plus, assurez vous bien de pas vous être trompé sur l\'orthographe du nom</p>'; 
                                }
                            ?>
                            <hr>
                        </div>

                        <?php

                            $posts = getAllPostFromUser($infosPage[0]["id"]);
                            
                            if (exist() && !empty($posts)) {
                                foreach (array_reverse($posts) as $post) {
                                    echo '<a href=post.php?p=' . $post["postId"] . '>';
                                    echo '<h3>' . $post["title"] . '</h3>';
                                    echo '<p>' . $post["content"] . '</p>';
                                    echo '<p class="datetime">' . $post["postedAt"] . '</p>';
                                    echo '</a>';
                                    echo '<hr>';
                                }
                            }
                            
                        ?>

                    </div>
                </div>
            </div>
        </div>

        <script src="script.js"></script>
    </body>
</html>