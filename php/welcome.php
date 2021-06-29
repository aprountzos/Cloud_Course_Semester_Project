<?php
include_once 'server.php';



//if user not logged in gets redirected to login page
if(!isset($_SESSION['username'])){
    $_SESSION['msg'] = "You must log in first to view this page!";
    //echo $_SESSION['msg'];
    header('location: index.php?msg=' .$_SESSION['msg'] .'');
}
//if user logs out gets redirected to login page after session is destroyed and database connection is closed
if(isset($_GET['logout'])){
    $conn->close();
    session_destroy();
    unset($_SESSION['username']);
    header('location: index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="css/form.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>

    $(document).ready(function(){
        var role='<?php echo $_SESSION['role']; ?>' ;
        if(role=='CINEMAOWNER'){
            get_cine();
        }
        // get cinema name if owner
        function get_cine(){
            var user='<?php echo $_SESSION['username']; ?>' ;
            //console.log(cine_name);
            $.ajax({
                type:'POST',
                url:"fetch.php",
                data:{action:'get_cine',user:user},
                success:function(data){
                    console.log(data);   
                }
                
            });
        }

    });
    function deletsub(id,count){
        // delete a notification
        var elem="tr#"+id+"-"+count;
        $.ajax({
                type:'POST',
                url:"fetch.php",
                data:{action:'delete_notification',sub_id:id,count:count},
                success:function(response){
                    console.log(response);
                    if(response){
                        $(elem).css('background','#ddd');
                    $(elem).fadeOut(800,function(){
                    $(this).remove();
                    }); 
                }
                }
                
            });
        }
    
    function loadDoc() {
        //load notifications
            var userid=<?php echo '\''.$_SESSION['current_id'].'\''; ?> ;
            
            $.ajax({
                type:'POST',
                url:"fetch.php",
                data:{action:'notify',userid:userid},
                success:function(data){
                    
                        $('tbody').html(data);
                    
                    
                }
                
            });
    }
        var role='<?php echo $_SESSION['role']; ?>' ;
        if(role=='USER'){
            loadDoc();
        setInterval(loadDoc,30000);
        }

    </script>
    <style>
        h2{
           
            
            margin-left: 40%;
            margin-right: 40%;
            margin-top: 20%;
            width: 30%;
        }
    </style>
</head>
<body>
	<h1 style="color: white">Welcome on Cinematrix!</h1>
    <?php
include('navbar.php');


//display message passed from other pages which redirect user to welcome for certain reasons
if(isset($_SESSION['msg'])){
    echo '<h2 style="align-text:center;color: white">';
    echo $_SESSION['msg'];
    echo '</h2>';
    unset($_SESSION['msg']);
}
if($_SESSION['role']=='USER'){
    echo    '<div class="scrollable" >
            <table style="width:100%;text-align: center;">
            <thead>
            <tr style="cursor:default">
            <th>Notifications</th>
            <th></th>
            </tr>
            </thead>

            <tbody>
            </tbody>';
}

?>

</body>
</html>