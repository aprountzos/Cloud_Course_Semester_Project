
<!-- NOT USED ANYMORE -->
<!-- NOT USED ANYMORE -->
<!-- NOT USED ANYMORE -->
<?php include_once('server.php');

//if not logged in redirect to login
if(!isset($_SESSION['username'])){
    $_SESSION['msg'] = "You must log in first to view this page!";
    //echo $_SESSION['msg'];
    header('location: index.php' .$_SESSION['msg']);
}
//logged in
if(isset($_SESSION['username'])){
    //if not admin redirect to welcome 
	if($_SESSION['role']!='ADMIN'){
    $_SESSION['msg'] = "You are not an admin!";
    //echo $_SESSION['msg'];
    header('location: welcome.php'. $_SESSION['msg'] );
    }
    //if admin
    else{
    
    //if any post   
    if(isset($_POST['update'])) {
    
    
    
            $name = $_POST['name'];
            $surname = $_POST['surname'];
            $username = $_POST['username'];
            $password = md5($_POST['password']);
            $email = $_POST['email'];
            $role = $_POST['role'];
            $confirmed=0;
            
            if(isset($_POST['confirmed'])){
                $confirmed=$_POST['confirmed'];
            }
            $id=$_POST['id'];
            //if there is change in password, querry will change password as well
            //because if empty string is enctypted will give "trash" string and pass will change
            //md5 is used here
            if($_POST['password']!="" || $_POST['password']!=null ) {
                $sql = "UPDATE users SET NAME ='$name',SURNAME = '$surname',USERNAME ='$username',
                PASSWORD='$password',EMAIL='$email',ROLE='$role',CONFIRMED='$confirmed' 
                WHERE ID=$id" ;
            }else{
                $sql = "UPDATE users SET NAME ='$name',SURNAME = '$surname',USERNAME ='$username',
                EMAIL='$email',ROLE='$role' ,CONFIRMED='$confirmed' 
                 WHERE ID=$id";
            }
                if ($conn->query($sql) === TRUE) {
                    //if query successfull will redirect back to adminstration page
                   echo $id;
                   exit();
                } else {
                    echo '';
                    exit();
                    
                }
        
        }
        

    }

}





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="icon" href="img/clapper.png">
    <style>
        .container{
               
               margin-left: 42%;
               margin-right: 42%;
               margin-top: 4%;
               margin-bottom: 4%;
               
              
                
        }
        
    </style>
</head>



<body>
	<h1 style="color: white">Update this Account!</h1>
	<?php include("navbar.php");?>
    
    <div class="container" >

        <div class="header">

            <h2>Update User</h2>

        </div>

        <form action="update.php"  method="post" >
        
        
        <?php

        $name=$row['NAME'];
        $surname=$row['SURNAME'];
        $username =$row['USERNAME'];
        $email =$row['EMAIL'];
        $role=$row['ROLE'];
        $confirmed =$row['CONFIRMED'];
        $id=$row['ID'];
        

        //bad practice to print the table
        // could use php tag inside html
        echo '<div>
        
        <label for="name">Name:</label><br>
        <input type="hidden" name="id" class="txtField" value='. $id.'>
        <input type="text" name="name" value=' . $name. ' >
        </div> ' ;
        
        echo '<div>
        <label for="surname">Surname:</label><br>
        <input type="text" name="surname" value=' . $surname. ' >
        </div> ' ;

        echo '<div>
        <label for="username">Username:</label><br>
        <input type="text" name="username" value=' . $username. ' >
        </div> ' ;


        echo '<div>
        <label for="password">New Password:</label><br>
        <input type="password" name="password" value="" >
        </div> ' ;

        echo ' <div>
        <label for="email">Email:</label><br>
        <input type="email" name="email" id="email" value=' . $email . ' ""onkeyup="validateEmail();" ><br>
        <span id="valid-email"></span> <br> 
        
    </div>';
    //select role of user to be already selected as "default" in select input
    
        $admin=$user=$owner='';
        if($role=='ADMIN'){$admin='selected';}
        elseif($role=='USER'){$user='selected';}
        else{$owner='selected';}

        echo '<div >
                <label for="role" id="role">Select a Role</label><br>
                
                <select name="role">
                <option  '. $user.' value="USER">User</option>
                <option  '. $owner.'  value="CINEMAOWNER">Cinema Owner</option>
                <option  '. $admin.'  value="ADMIN">Admin</option>
                </select><br>
                <br>
                
            </div>';

         ?>
            

    
        

            

            <div>
            <label for="confirmed" id="confirmed">Confirmed</label>
            <?php $checked='';
            //if user is already confirmed checkbox is already checked
            if($confirmed!= 0){
                $checked= 'checked';}
                echo '<input name="confirmed" type="checkbox" value=1 ' . $checked .'>';

            ?>
            
                <br>
                <br>
            </div>

            <div>
                <input type="submit" value="Update!"  name="update" id="update" >
                <a href="administration.php">
                    <input type="button" value="Cancel" name="cancel-update" id="cancel-update" />
                </a>
            </div>
        


        </form>


    </div>

    
</body>


</html>