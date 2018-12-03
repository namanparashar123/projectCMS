<?php
    $imageSan = '';
    $nameSan = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $descriptionSan = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
    $characterId = filter_input(INPUT_POST, 'characterId', FILTER_SANITIZE_NUMBER_INT);
    $slugFilter = filter_input(INPUT_POST, 'slug', FILTER_SANITIZE_SPECIAL_CHARS);
    $slug = preg_replace('#[ -]+#', '-', $slugFilter);


    if($_POST && "all required variables are present")
    {
        session_start();
        if($_POST['captcha'] != $_SESSION['code']) die("Sorry, the CAPTCHA code entered was incorrect!");
        session_destroy();
    }
    
    
    function file_upload_path($original_filename, $upload_subfolder_name = 'Images')
    {
        $current_folder = dirname(FILE);
        $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
        return join(DIRECTORY_SEPARATOR, $path_segments);
    }

    function file_is_an_image($temporary_path, $new_path) 
    {
        $allowed_mime_types      = ['image/jpeg', 'image/png'];
        $allowed_file_extensions = ['jpg', 'jpeg', 'png'];

        $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
        $actual_mime_type        = $_FILES['image']['type'];


        $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
        $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);

        $fileExtCheck = $file_extension_is_valid? "true" : "false";
        $fileExtCheck1 = $mime_type_is_valid? "true" : "false";

        return $file_extension_is_valid && $mime_type_is_valid;
    }

    $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);
    $upload_error_detected = isset($_FILES['image']) && ($_FILES['image']['error'] > 0);

    echo $_FILES['image']['error'];

    if ($image_upload_detected) {
        echo "image update detected";
        $image_filename = pathinfo($_FILES['image']['name'], PATHINFO_FILENAME);
        $image_fileExtention = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $temporary_image_path = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        $new_image_path = file_upload_path($_FILES['image']['name']);
        echo $new_image_path;
        echo $temporary_image_path;

        if (file_is_an_image($temporary_image_path, $new_image_path)) {
            echo 'test';
            move_uploaded_file($temporary_image_path, $new_image_path);
            $imageSan = $_FILES['image']['name'];
            echo $imageSan;
        }
    }

    if ($_POST['command'] == "Delete") {
        require('connect.php');

        $query = "DELETE FROM characters WHERE characterId = :characterId";
        $statement = $db->prepare($query);
        $statement->bindValue(':characterId', $characterId, PDO::PARAM_INT);
        $statement->execute();

        $queryImg = "DELETE FROM images WHERE characterId = :characterId";
        $statement = $db->prepare($queryImg);
        $statement->bindValue(':characterId', $characterId, PDO::PARAM_INT);
        $statement->execute();
        header("Location: characters.php");
        exit;
    } 
    elseif(empty($nameSan) or empty($descriptionSan)){
    
        header("Location: error.php");
        exit;
    
    }

    elseif ($_POST['command'] == "Update")
    {
        require('connect.php');
        $query = "UPDATE characters SET RealName = :name, Description = :description, slug = :slug WHERE characterId = :characterId";
        $statement = $db->prepare($query);
        $statement->bindValue(':name', $nameSan);
        $statement->bindValue(':description', $_POST['description']);
        $statement->bindValue(':slug', $slug);
        $statement->bindValue(':characterId', $characterId, PDO::PARAM_INT);
        $statement->execute();

        
        $imgQuery = "INSERT INTO images (ImageName, CharacterId) values (:img, :characterId)";
        $statement = $db->prepare($imgQuery);
        $statement->bindValue(':img', $imageSan);
        $statement->bindValue(':characterId', $characterId);
        $statement->execute();
        

        echo $_POST['chkbox'];
        if(isset($_POST['chkbox']))
        {
            echo "being deleted";
            $queryImg = "DELETE FROM images WHERE characterId = :characterId";
            $statement = $db->prepare($queryImg);
            $statement->bindValue(':characterId', $characterId, PDO::PARAM_INT);
            $statement->execute();
            header("Location: characters.php");
            exit;
        }

        // header("Location: characters.php");
        // exit;
    }


    
?>