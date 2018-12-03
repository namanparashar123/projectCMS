<?php
     require 'connect.php';
     require 'authentication.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Share!</title>
    <link rel="stylesheet" href="main.css" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Allerta+Stencil" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
</head>
<body>
    <div>
        <nav class="topnav">
            <a href="https://www.marvel.com"><img src = "Images/indeximages.png" alt = "Avengers"></a>
            
            <ul>
                <li><a href = "index.php">About</a></li>
                <li><a href = "characters.php">Characters</a></li>      
                <li><a href = "#">Something</a></li>
                <li><a href = "login.php">Login</a></li>
            </ul>
        </nav>
        <div>
        <form action="editShare.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Add a new Avenger</legend>
                <p>
                    <label for="name">Real Name</label>
                    <input name="name" id="name" />
                </p>
                <p>
                    <label for="description">Description</label>
                    <textarea name="description" id="description"></textarea>
                </p>
                <p>
                    <label for="image">Image</label>
                    <input type="file", name="image", id="image">
                </p>
                <p>
                    <label for="slug">Slug for URL</label>
                    <input type="text", name="slug", id="slug">
                </p>
                <p>
                    <input type="submit" name="command" value="Create" />
                </p>
            </fieldset>
        </form>
        
    </div>
</body>
</html>