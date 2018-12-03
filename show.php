<?php
    require 'connect.php';

    // Sanitize $_GET['id'] to ensure it's a number.
    $charId = filter_input(INPUT_GET, 'CharacterId', FILTER_SANITIZE_NUMBER_INT);

    // Build a query using ":id" as a placeholder parameter.
    $query = "SELECT * FROM characters WHERE CharacterId = :CharacterId";
    $statement = $db->prepare($query);

    // Bind the :id parameter in the query to the previously
    // sanitized $id specifying a type of INT.
    $statement->bindValue(':CharacterId', $charId, PDO::PARAM_INT);
    $statement->execute(); 
    $status = $statement->fetch();

    // Sanitize $_GET['id'] to ensure it's a number.
    $imageId = filter_input(INPUT_GET, 'CharacterId', FILTER_SANITIZE_NUMBER_INT);

    // Build a query using ":id" as a placeholder parameter.
    $imgQuery = "SELECT * FROM images WHERE CharacterId = :CharacterId";
    $statement = $db->prepare($imgQuery);

    // Bind the :id parameter in the query to the previously
    // sanitized $id specifying a type of INT.
    $statement->bindValue(':CharacterId', $imageId, PDO::PARAM_INT);
    $statement->execute(); 
    $imgStatus = $statement->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=$status['RealName']?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Allerta+Stencil" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
</head>
<body>
    <nav class="topnav">
        <a href="https://www.marvel.com"><img src = "Images/indeximages.png" alt = "Avengers"></a>
        <ul>
            <li><a href = "index.php">About</a></li>
            <li><a href = "characters.php">Characters</a></li> 
            <li><a href = "share.php">Share</a></li>     
            <li><a href = "#">Something</a></li>
            <li><a href = "login.php">Login</a></li>
        </ul>
    </nav>
    <h2><?=$status['RealName']?></h2>
    <div id="imageside">
        <?php if($imgStatus['ImageName'] == ''): ?>
            <p>No Image Found</p>
        <?php else:?>
            <img id="image" src="Images/<?=$imgStatus['ImageName']?>">
        <?php endif?>
    </div>
    <div id="aside">
        <p id="para">
            <?=$status['Description']?>
        </p>
    </div>
        <p>
            <a id ="editlink" href = "edit.php?CharacterId=<?=$status['CharacterId']?>">Edit</a>
        </p>
</body>
</html>