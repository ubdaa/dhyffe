<?php
    session_start();

    if (isset($_SESSION['connState']) && $_SESSION['connState'] === 1) {
        header("Location: ../accueil.php");
    } 
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Connexion - Dhyffe</title>
        <link rel="stylesheet" href="connexion.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <body>
        <div class="panelPrin">
            <div class="logo">  
                <img src="images/dhyffe-logo.png" alt="">
                <h1>Dhyffe</h1>
            </div>
            <h3>Connexion</h3>

            <?php
                if(isset($_SESSION["err"]) &&  $_SESSION["err"] === "empty") {
                    echo '<div class="error">
                        <p>Veuillez remplir tous les champs !</p>
                    </div>';
                    unset($_SESSION["err"]);
                };
                if(isset($_SESSION["err"]) &&  $_SESSION["err"] === "pwd") {
                    echo '<div class="error">
                        <p>Le mot de passe ou le nom d\'utilisateur ne correspondent pas !</p>
                    </div>';
                    unset($_SESSION["err"]);
                };
                if(isset($_SESSION["err"]) &&  $_SESSION["err"] === "usernameDoesNotExist") {
                    echo '<div class="error">
                        <p>Le mot de passe ou le nom d\'utilisateur ne correspondent pas !</p>
                    </div>';
                    unset($_SESSION["err"]);
                };
            ?>

            <form action="verifConnexion.php" method="post">
                <?php
                    if(isset($_SESSION["username"])) {
                        echo '<input type="text" name="username" placeholder="Nom d\'utilisateur" value="' . $_SESSION["username"] .'">';
                    } else {
                        echo '<input type="text" name="username" placeholder="Nom d\'utilisateur">';
                    }

                    if(isset($_SESSION["pwd"])) {
                        echo '<input type="password" name="pwd" placeholder="Mot de passe" value="' . $_SESSION["pwd"] .'">';
                    } else {
                        echo '<input type="password" name="pwd" placeholder="Mot de passe">';
                    }
                ?>
                <p>Vous n'avez pas de compte ? <a href="inscription.php">S'inscrire ici</a></p>
                <button><span class="material-symbols-rounded">login</span>Se connecter</button>
            </form>
        </div>
    </body>

</html>