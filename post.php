<?php

session_start();

require("include/globalFunction.php");

if(isset($_SESSION["connState"])) {
    if ($_SESSION["connState"] === 1) {
        $infos = getInfoFromUser($_SESSION["username"]);
    } 
}

$postInfo = getInfoFromPost($_GET["p"]);
$author = getInfoFromAuthor($postInfo[array_key_first($postInfo)]["userId"]);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Post - Dhyffe</title>
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
                    <?php echo '<a href=profil.php?p=' . $author[0]["username"] .'>'; ?>
                        <div class="profil">
                            <?php
                                echo '<img src="' . $author[0]["pdpPath"] .'" alt="">
                                <p>' . $author[0]["name"] . '</p>
                                <p class="pseudoAt">@' . $author[0]["username"] . '</p>';
                            ?>
                        </div>
                    <?php echo '</a>'; ?>
                    

                    <?php
                        echo '<h3>' . $postInfo[array_key_first($postInfo)]["title"] . '</h3>';
                        echo '<p>' . $postInfo[array_key_first($postInfo)]["content"] . '</p>';
                        echo '<p class="datetime">' . $postInfo[array_key_first($postInfo)]["postedAt"] . '</p>';
                    ?>
                    
                    <hr>

                    <?php echo '<form action="commPost.php?p=' . $postInfo[0]["postId"] . '" class="commentaire" method="post">'; ?>
                        <input type="text" name="Content" placeholder="Mettre un commentaire">
                        <button><img src="images/send.png" alt=""></button>
                    </form>

                    <?php
                        require_once("include/globalFunction.php");

                        $comms = getAllCommsFromPost($postInfo[0]['postId']); 

                        if (!($comms == NULL)) {
                            
                            foreach($comms as $comm) {
                                $commPost = getInfoFromAuthor($comm["creatorId"]);

                                echo '<div class="profil" style="padding-top: 20px;">
                                    <img src="' . $commPost[0]["pdpPath"] . '" style="width: 60px;" alt="">
                                    <p>' . $commPost[0]["name"] . '</p>
                                    <p class="pseudoAt">@' . $commPost[0]["username"] . '</p>
                                </div>';

                                echo '<p>' . $comm['content'] . '</p>';
                                echo '<hr>';
                            }
                        }
                    ?>
                </div>
            </div>
        </div>

        <script src="modify.js"></script>
    </body>
</html>