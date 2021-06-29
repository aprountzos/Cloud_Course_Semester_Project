<?php

include("server.php");

if (isset($_POST['signup'])){
    
    //Aquire registration info from 'signup.php', by for using Post method
    
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $email = $_POST['email'];
    $role = $_POST['role'];
    

    //Check if username or/and email already in use
    //other possible errors are being handled in frontend
    $usererror = false;
    $emailerror = false;

    $sql_ue ="SELECT * FROM users WHERE username='$username' or email='$email' LIMIT 1";
    $res_ue = $conn->query($sql_ue);
    $user =$res_ue->fetch_assoc();

    if($user){
        if($user['USERNAME'] === $username){
            $usererror = true;
            echo"Username already in use!";
            
        }    
        if($user['EMAIL'] === $email){
            $emailerror = true;
            echo "Email already in use!"; 
            
        }
    }else{
        //Prepare Registration Query

        $entry =("INSERT INTO users (NAME,SURNAME,USERNAME,PASSWORD,EMAIL,ROLE) VALUES('$name','$surname','$username','$password','$email','$role')");
        //$entry->bind_param('ssssss', $name, $surname, $username, $password, $email, $role );
        //Execute querry and redirect to 'index.php'
        if ($conn->query($entry)){
            echo "<script>
            window.location.replace('index.php');
            </script>";
        }

    }
}

?>

<script>
    //$("#username","#password").removeClass("input-error");
    var errorUsername = "<?php echo $usererror; ?>";
    var errorEmail = "<?php echo $emailerror; ?>";
    

    if (errorUsername == true){
        $("#username").val("");
        
    }
    if (errorEmail == true){
        $("#email").val("");
        
    }

    

</script>


