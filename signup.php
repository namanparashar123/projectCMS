<?php
    include('server.php');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sign Up</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
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
    <div>
        <h2>Sign up!</h2>
    </div>

    <form class="reglog" method="post" action="signup.php">
        <?php include('loginerror.php'); ?>
        <div class="username-available-msg alert alert-primary input-group" role="alert" style="display:none">
            Username is available.
        </div>
        <div class="username-taken-msg alert alert-danger input-group" role="alert" style="display:none">
            Sorry this username is taken.
        </div>
        <div class="input-group">
            <label id="regLabel">Username</label>
            <input id="inputUsername" type="text" name="username" value="<?php echo $username; ?>">
        </div>
        <div class="input-group">
            <label id="regLabel">Email</label>
            <input type="email" name="email" value="<?php echo $email; ?>">
        </div>
        <div class="input-group">
            <label id="regLabel">Password</label>
            <input type="password" name="password_1">
        </div>
        <div class="input-group">
            <label id="regLabel">Confirm password</label>
            <input type="password" name="password_2">
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="reg_user">Register</button>
        </div>
        <p id="regLabel">
            Already a member? <a href="login.php">Log in</a>
        </p>
    </form>
    <script src="main.js"></script>
</body>
</html>