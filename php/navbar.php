<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/clapper.png">
    <link rel="stylesheet" href="css/navbar.css">
</head>
<body>
    
     <?php
     //if logged in
    if(isset($_SESSION['username'])) : ?>
        <div>
    <ul>
      <li>
        <div class='dropdown'>
            <a class="menu" href="welcome.php">Home</a>
              <div class="dropdown-content">
                <!-- <a href="administration.php">Admin Dashboard</a> -->
                <a href="owner.php">Owner Dashboard</a>
                <a href="movies.php">Browse Movies</a>
              </div>              
      </div>
      
      
      <li style="float: right;"><a class='logout' href="welcome.php?logout='1'">Log Out</a></li>
      <li class='user'><?php echo $_SESSION['fullname'] . ' (' . $_SESSION['role'] . ')'  ; ?></a></li>
    </ul>

        </div>
    <?php endif ?>

  


</body>
</html>