<?php

if (isset($_SESSION["connState"])) {
    $state = $_SESSION["connState"];
}

function uploadPost(string $username) {
    require("include/dbConnec.php");

    $userInfo = getInfoFromUser($username);

    $query2 = "SELECT localPostId FROM post WHERE userId = :idSearch;";

    $stmt = $pdo->prepare($query2);
    $stmt->bindParam(":idSearch", $userInfo[0]["id"]);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($results)) {
        $lPostId = 1;
    } else {
        $length = array_key_last($results);
        $lPostId = $results[$length]["localPostId"] + 1;
    }

    $query1 = "INSERT INTO post (localPostId, userId, title, content) VALUES (?, ?, ?, ?);";

    $stmt = $pdo->prepare($query1);
    $stmt->execute([$lPostId, $userInfo[0]["id"], $_SESSION["title"], $_SESSION["content"]]);

    $query3 = "SELECT postId FROM post WHERE localPostId = :lPostIdSearch AND userId = :idSearch;";

    $stmt2 = $pdo->prepare($query3);
    $stmt2->bindParam(":lPostIdSearch", $lPostId);
    $stmt2->bindParam(":idSearch", $userInfo[0]["id"]);
    $stmt2->execute();

    $results2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    $firstIndex = array_key_first($results2);

    if (empty($results2)) {
        header("Location: ../accueil.php");
    } else {
        header("Location: ../post.php?p=" . $results2[$firstIndex]["postId"]);
    }

    unset($_SESSION["title"]);
    unset($_SESSION["content"]);
    
    unset($userInfo);
    die();
}

function doesUserExist(string $username) {
    
    require("include/dbConnec.php");

    $query = "SELECT username FROM users WHERE username = :userSearch;";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":userSearch", $username);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($results)) {
        return false;
    } else {
        return true;
    }
}

function modifyAccount(string $username) {

    require("include/dbConnec.php");

    $query = "UPDATE users SET username = :username, name = :name, bio = :bio WHERE username = :userSearch;";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":userSearch", $username);

    $stmt->bindParam(":username", $_SESSION["usernameMod"]);
    $stmt->bindParam(":name", $_SESSION["nameMod"]);
    $stmt->bindParam(":bio", $_SESSION["bioMod"]);

    $stmt->execute();

    $pdo = null;
    $stmt = null;

    unset($_SESSION["username"]);
    $_SESSION["username"] = $_SESSION["usernameMod"];

    unset($_SESSION["usernameMod"]);
    unset($_SESSION["nameMod"]);
    unset($_SESSION["bioMod"]);

    header("Location: ../profil.php?p=" . $_SESSION["username"]);
    
}

function verifyAccount(string $username, string $pwd) {
    try {
        
        require("include/dbConnec.php");

        $query = "SELECT username, pwd FROM users WHERE username = :userSearch;";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":userSearch", $username);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $pdo = null;
        $stmt = null;
        
        foreach ($results as $result) {
            $hash = $result["pwd"];
        }
        
        if (password_verify($pwd, $hash)) {
            unset($_SESSION["pwd"]);
            $_SESSION["connState"] = 1;
            header("Location: ../accueil.php");
            die();
        } else {
            $_SESSION["err"] = "pwd";
            header("Location: ../connexion.php");
            die();
        }

    } catch (PDOException $e) {
        echo $e;
    }
}

function createAccount(string $username, string $pwd) {
    try {
        
        require("include/dbConnec.php");

        $query = "INSERT INTO users (username, pwd, name, bio, pdpPath) VALUES (?, ?, ?, ?, ?);";

        $bio = "Bonjour ! Je suis nouveau ici";
        $pdpPath = "images/default-avatar.jpg";

        $stmt = $pdo->prepare($query);
        $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT);
        $stmt->execute([$username, $hashedPwd, $username, $bio, $pdpPath]);

        $pdo = null;
        $stmt = null;

        unset($_SESSION["pwd"]);
        unset($_SESSION["pwdVer"]);

        $_SESSION["connState"] = 1;
        
        header("Location: ../accueil.php");
        die();

    } catch (PDOException $e) {
        echo $e;
    }
}

function getInfoFromUser(string $username) {

    require("include/dbConnec.php");

    $query = "SELECT * FROM users WHERE username = :userSearch;";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":userSearch", $username);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = null;

    if (empty($results)) {
        return null;
    } else {
        return $results;
    }
}

function getInfoFromPost(string $postId) {

    require("include/dbConnec.php");

    $query = "SELECT * FROM post WHERE postId = :idSearch;";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":idSearch", $postId);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($results)) {
        return null;
    } else {
        return $results;
    }
}

function getInfoFromAuthor(string $userId) {
    
    require("include/dbConnec.php");

    $query02 = "SELECT * FROM users WHERE id = :idSearch";
    
    $stmt2 = $pdo->prepare($query02);
    $stmt2->bindParam(":idSearch", $userId);
    $stmt2->execute();

    $results = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    if (empty($results)) {
        return null;
    } else {
        return $results;
    }
}

function getAllPostFromUser(string $profilId) {

    require("include/dbConnec.php");

    $query = "SELECT * FROM post WHERE userId = :idSearch";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":idSearch", $profilId);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($results)) {
        return null;
    } else {
        return $results;
    }

}

function getPostsFromToday() {

    require("include/dbConnec.php");

    $query = "SELECT * FROM `post` WHERE CAST(postedAt as DATE) = CAST(CURDATE() as DATE);";

    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($results)) {
        return null;
    } else {
        return $results;
    }
}