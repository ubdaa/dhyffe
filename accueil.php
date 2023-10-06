<?php

session_start();

require "include/globalFunction.php";

$index = 0;
$l_Index = 0;

function addToIndex(int $index) {
    $index = $index + 5;
    return $index;
}

$posts = getPostsFromToday();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Page d'accueil - Dhyffe</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
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
                        $infos = getInfoFromUser($_SESSION["username"]);
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
                    echo '<a href="accueil.php"><button><span class="material-symbols-rounded">home</span>Accueil</button></a><br>
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

            <?php
                if (empty($posts)) {
                    echo '<div class="post">
                        <p>Pas de posts pour aujourd\'hui !</p>';
                    echo '</div>';
                } else {
                    foreach(array_slice(array_reverse($posts), $index) as $post) {
                        $actualPostAuthorInfo = getInfoFromAuthor($post["userId"]);
                        echo '<div class="post">
                            <a href="profil.php?p=' . $actualPostAuthorInfo[0]["username"]  .'">
                                <div class="profil">
                                    <img src="' . $actualPostAuthorInfo[0]["pdpPath"] . '" alt="">
                                    <p>' . $actualPostAuthorInfo[0]["name"] . '</p>
                                    <p class="pseudoAt">@' . $actualPostAuthorInfo[0]["username"] . '</p>
                                </div>
                            </a>
    
                                <a href="post.php?p=' . $post["postId"] . '">
                                    <h3>' . $post["title"] . '</h3>
                                    <p>' . $post["content"] . '</p>
                                    <p class="datetime">' . $post["postedAt"] . '</p>
                                </a>
    
                                <hr>
    
                                <form action="commPost.php?p=' . $post["postId"] . '" class="commentaire">
                                    <input type="text" placeholder="Mettre un commentaire">
                                    <button><img src="images/send.png" alt=""></button>
                                </form>
                        </div>';
    
                        $l_Index++;
    
                        if ($index+5 === $l_Index) {
                            addToIndex($index);
                            $l_Index = 0;
                            break;
                        }
                    }
                }
            ?>

            </div>
        </div>

        <script src="script.js"></script>
    </body>
</html>