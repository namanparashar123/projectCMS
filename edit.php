<?php
    require 'connect.php';
    require 'authentication.php';

    // Sanitize $_GET['id'] to ensure it's a number.
    $characterId = filter_input(INPUT_GET, 'CharacterId', FILTER_SANITIZE_NUMBER_INT);

    // Build a query using ":id" as a placeholder parameter.
    $query = "SELECT * FROM characters WHERE CharacterId = :characterId";
    $statement = $db->prepare($query);

    // Bind the :id parameter in the query to the previously
    // sanitized $id specifying a type of INT.
    $statement->bindValue(':characterId', $characterId, PDO::PARAM_INT);
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
    print_r($imgStatus);
    echo "<br>";
    $count_query = "SELECT COUNT(*) AS imgCount FROM images WHERE characterId LIKE :characterId";
    $statement = $db->prepare($count_query);
    $statement->bindValue(':characterId', $characterId, PDO::PARAM_INT);
    $statement->execute();
    $imgStatuses = $statement->fetch();
    print_r($imgStatus);
    $allcount = $imgStatuses['imgCount'];
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Edit <?=$status['RealName']?></title>
    <link rel="stylesheet" href="main.css" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Allerta+Stencil" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
</head>
<body>
    <div id="wrapper">
        <nav class="topnav">
            <a href="https://www.marvel.com"><img src = "Images/indeximages.png" alt = "Avengers"></a>
            <ul>
                <li><a href = "index.php">About</a></li>
                <li><a href = "characters.php">Characters</a></li>      
                <li><a href = "#">Something</a></li>
                <li><a href = "login.php">Login</a></li>
            </ul>
        </nav>
    <div id="all_blogs">
        <form action="shared.php" method="post">
            <fieldset>
                <legend>Edit Avenger Information</legend>
                <p>
                    <label for="name">Real Name</label>
                    <input name="name" id="name" value="<?=$status['RealName']?>" />
                </p>
                <p>
                    <label for="description">Content</label>
                    <textarea name="description" id="description"><?=$status['Description']?></textarea>
                </p>
                <p>
                    <?php if($allcount == 0): ?>
                    <p>
                        <?="test"?>
                        <label for="image">Image</label>
                        <input type="file", name="image", id="image">
                    </p>
                    <?php else : ?>
                    <?=$imgStatus?>
                        <img id="image" src="Images/<?=$imgStatus['ImageName']?>" alt="<?=$imgStatus['ImageName']?> ">
                        <label for="img">Delete this image</label>
                        <input type="checkbox" id="img" name="chkbox" value="checked">
                    <?php endif ?>
                <p>
                <p>
                    <img src="captcha.php" width="120" height="30" style="border:1" alt="CAPTCHA">
                </p>
                
                <p><input type="text" size="6" maxlength="5" name="captcha" value=""><br>
                <small>Enter the digits to prove you won't take over this world.</small></p>

                <p>
                    <label for="slug">Slug for URL</label>
                    <input type="text" name="slug" id="slug">
                </p>

                <p>
                    <input type="hidden" name="characterId" value="<?=$status['CharacterId']?>" />
                    <input type="submit" name="command" value="Update" />
                    <input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this post?')" />
                </p>
            </fieldset>
        </form>
    </div>
    </div>
</body>
</html>