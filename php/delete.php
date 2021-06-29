<!-- NOT USED ANYMORE -->
<!-- NOT USED ANYMORE -->
<!-- NOT USED ANYMORE --><!-- NOT USED ANYMORE -->
<!-- NOT USED ANYMORE -->
<!-- NOT USED ANYMORE -->

<?php
include_once 'server.php';
//if not logged in redirect to login
if(!isset($_SESSION['username'])){
    $_SESSION['msg'] = "You must log in first to view this page!";
    //echo $_SESSION['msg'];
    header('location: index.php?' .$_SESSION['msg']);
}
//logged in
if(isset($_SESSION['username'])){
    //admin to delete a user
    if($_SESSION['role']=='ADMIN' && isset($_POST['user'])){
        //cannot delete your account
        //if($_POST["id"]==$_SESSION['current_id']){
            //$_SESSION['rep']= "Cannot delete your own account!";
            //header('location: administration.php?');
        //    echo 0;
       // }
        //else{ 
           $sql = "DELETE FROM users WHERE ID='" . $_POST["id"] . "'";
            if (mysqli_query($conn, $sql)) {
                //$_SESSION['rep']= "User deleted successfully";
                echo 1;
                //header('location: administration.php');
            } else {
                echo 0;
                //echo "Error deleting record: " . mysqli_error($conn);
                
            }
        //}
    }
    else{
    $_SESSION['rep'] = "You are not authorized!";
    echo $_SESSION['rep'];
    header('location: welcome.php?'. $_SESSION['rep'] );
    }
}


?>