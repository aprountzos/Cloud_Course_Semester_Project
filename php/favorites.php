<?php
include('server.php');
$usid=$_SESSION['current_id'];

//if not logged in redirect to login page
if(!isset($_SESSION['username'])){
    $_SESSION['msg'] = "You must log in first to view this page!";
    //echo $_SESSION['msg']; 
    header('location: index.php?' .$_SESSION['msg']);
}

//user logged in
if(isset($_SESSION['username'])){
    //if not user pass not user msg to be printed in welcome page
    //redirect to welcome
	if($_SESSION['role']!='USER'){
    $_SESSION['msg'] = "You are not a User!";
    //echo $_SESSION['msg'];
    header('location: welcome.php?'. $_SESSION['msg'] );
}else{
    //user deletes a favorite
        if(isset($_POST['fav_del'])){
            $id=$_POST['id'];
            $sql= $conn->prepare("DELETE FROM favorites WHERE USERID='$usid' AND MOVIEID='$id'");
            if ($sql->execute() === TRUE){
                echo 1;
                exit();
            } else {
                echo 0;
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
    <title>My Favorites</title>
    <link rel="stylesheet" href="css/form.css">
    <link rel="icon" href="img/clapper.png">
    <script type="text/javascript" src="funcs.js"></script> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>

        $(document).ready(function(){
            fetch_fav();
            function fetch_fav(){
                //SHOW FAVORITES
                
                var userid=<?php echo '\''.$_SESSION['current_id'].'\''; ?> ;
                
                $.ajax({
                    type:'POST',
                    url:"fetch.php",
                    data:{action:'fetch_fav',userid:userid},
                    success:function(data){
                    //console.log(data);
                        $('tbody').html(data);
                    }
                })
            }
        });



        function fav(id1){
            //DELETE FAV
        $(document).ready(function(){
        var userid=<?php echo '\''.$_SESSION['current_id'].'\''; ?> ;
        var elem=".addfav"+id1;
        var el = $(elem);
        var id = $(el).data('id');
        //var op=$(el).html();
        //console.log(op);
        $.ajax({
        url: 'fetch.php',
        type: 'POST',
        data: { action:'Remove',userid:userid,movie_id:id},
        success: function(response){
            console.log(response)
            if(response == 1){
                    $(el).closest('tr').css('background','#ddd');
                    $(el).closest('tr').fadeOut(800,function(){
                    $(this).remove();
                    });
            }else{
                alert('Error.');
            }

        }
        });
        });
        }
    


    </script>
  <link rel="stylesheet" href="css/movies.css">
</head>
<body>
<h1 style="color: white">My Favorites!</h1>
    <?php include('navbar.php'); ?>



    <div class="scrollable">
        <table style="width:100%;text-align: center;">
            <thead>
                <tr style="cursor:default">
                    <th>TITLE</th>
                    <th>START DATE</th>
                    <th>END DATE</th>
                    <th>CINEMA NAME</th>
                    <th>CATEGORY</th>
                    <th>FAVORITES</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
        <br><br>
        <br><br><button onclick="location.href='movies.php'" type="button">Back to Movie List</button>
        
</body>
</html>