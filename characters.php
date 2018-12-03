<?php
    require("connect.php");
    $query = '';
    $statement = '';
    $status = '';
    $rowperpage = 5;
    $row = 0;
    $enablePageLink = "none";
    if(isset($_GET['action']) == 'ASC')
    {
        $query = 'SELECT * FROM characters ORDER BY Age ASC';
        $statement = $db->prepare($query);
    }
    else if(isset($_GET['action']) == 'DESC')
    {
        $query = 'SELECT * FROM characters ORDER BY Age DESC';
        $statement = $db->prepare($query);
        
    }
    else{
        
        if (isset($_GET['searchResult'])) {
            echo "test";
            // Previous Button
            if(isset($_POST['but_prev'])){
                $row = $_POST['row'];
                $row -= $rowperpage;
                if( $row < 0 ){
                    $row = 0;
                }
            }

            // Next Button
            if(isset($_POST['but_next'])){
                $row = $_POST['row'];
                $allcount = $_POST['allcount'];
                $val = $row + $rowperpage;
                if( $val < $allcount ){
                    $row = $val;
                }
            }

            $searchString = "%" . filter_input(INPUT_GET, 'searchResult', FILTER_SANITIZE_FULL_SPECIAL_CHARS) . "%";
            
            $count_query = "SELECT COUNT(*) AS rowCount FROM characters WHERE RealName LIKE :search";
            $statement = $db->prepare($count_query);
            $statement->bindValue(':search', $searchString);      
            $statement->execute();
            $status = $statement->fetch();
            $allcount = $status['rowCount'];
            
            $enablePageLink = ($allcount > 5)? "inline-block" : "none";
            $select_query = "SELECT * FROM characters WHERE RealName LIKE :search LIMIT $row,".$rowperpage;
            $statement = $db->prepare($select_query);
            $statement->bindValue(':search', $searchString);
        }
        else{
            $query = 'SELECT * FROM characters';
            $statement = $db->prepare($query);
        }
    }
        
        $statement->execute();
        $marvel = $statement->fetchAll();

    

?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Welcome Avengers!</title>
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
        <form method=post action="searchProcess.php">
                    <ul style="list-style-type:none">
                        <li><input name="search_text" id="search_text"  placeholder="Search Avenger"></li>
                        <li><input type="submit" name="search"  value="Search" /></li>
                    </ul>
        </form>
    </nav>
    <br>
    <a id="asc" href="characters.php?action=ASC">Sort by Character Age</a>
    <?php foreach($marvel as $currentAvenger): ?>
    <h1><a class="linkhead" href ="show.php?CharacterId=<?=$currentAvenger['CharacterId']?>&slug=<?=$currentAvenger['slug']?>"><?= $currentAvenger['RealName']?></a></h1>
        <?php if(strlen($currentAvenger['Description']) > 0): ?>
        
            <?= substr($currentAvenger['Description'], 0, 351)?>... <a class="readit" href = "show.php?CharacterId=<?=$currentAvenger['CharacterId']?>">Read More</a>
       
        <?php endif ?>
    <?php endforeach ?>
    <form method="post" action="#" style="display:<?=$enablePageLink?>">
            <div id="div_pagination" style="color:black">
                <input type="hidden" name="row" value="<?php echo $row; ?>">
                <input type="hidden" name="allcount" value="<?php echo $allcount; ?>">
                <input type="submit" class="button" name="but_prev" value="Previous">
                <input type="submit" class="button" name="but_next" value="Next">
            </div>
    </form>
</body>
</html>