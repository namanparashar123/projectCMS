<?php
    $imageSan = '';
    $nameSan = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $descriptionSan = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
    $characterId = filter_input(INPUT_POST, 'characterId', FILTER_SANITIZE_NUMBER_INT);
    $slugFilter = filter_input(INPUT_POST, 'slug', FILTER_SANITIZE_SPECIAL_CHARS);
    $slug = preg_replace('#[ -]+#', '-', $slugFilter);

    if($_POST['command'] == "Create")
    {
        require('connect.php');
        $query = "INSERT INTO characters (RealName, Description, slug) values (:name, :description, :slug)";
        $statement = $db->prepare($query);
        $statement->bindValue(':name', $nameSan);
        $statement->bindValue(':description', $_POST['description']);
        $statement->bindValue(':slug', $slug);
        $statement->execute();
        $insert_id = $db->lastInsertId();

        $imgQuery = "INSERT INTO images (ImageName, CharacterId) values (:img, :characterId)";
        $statement = $db->prepare($imgQuery);
        $statement->bindValue(':img', $imageSan);
        $statement->bindValue(':characterId', $insert_id);
        $statement->execute();

        header("Location: characters.php");
        exit;
    }
?>