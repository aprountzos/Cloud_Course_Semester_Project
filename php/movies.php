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
    //if user
    //echo $_SESSION['current_id'];

}
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My dashboard</title>
    <link rel="stylesheet" href="css/form.css">
    <link rel="icon" href="img/clapper.png">
    <script type="text/javascript" src="funcs.js"></script> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    
    $(document).ready(function(){
        //SHOW MOVIES AND FILTER FAVS
        fetch_data();
        function fetch_data(){
            var userid=<?php echo '\''.$_SESSION['current_id'].'\''; ?> ;
            $.ajax({
                type:'POST',
                url:"fetch.php",
                data:{action:'fetch_all',userid:userid},
                success:function(data){
                   console.log(data);
                    $('tbody').html(data);
                }
            })
        }
    })
    function fav(id1){
        //ADD/REMOVE FAVORITE
    $(document).ready(function(){
        var userid=<?php echo '\''.$_SESSION['current_id'].'\''; ?> ;
        var elem=".addfav"+id1;
        var el = $(elem);
        var id = $(el).data('id');
        var op=$(el).html();
        console.log(op);
        $.ajax({
        url: 'fetch.php',
        type: 'POST',
        data: { action:op,userid:userid,movie_id:id},
        success: function(response){
            console.log(response)
            if(response == 1){
                //alert(op);
                if(op=='Add'){
                    $(el).html('Remove');
                }
                else if(op=='Remove'){
                    $(el).html('Add');
                }
                
                
            }else{
                alert('Error.');
            }

        }
        });
        });
    }



        $(document).ready(function(){
            //SEARCH 
            $('.srch').submit(function(event){
                event.preventDefault();
                var userid=<?php echo '\''.$_SESSION['current_id'].'\''; ?> ;
                var sel=$('#sel').val();
                var qu=$('#qu').val();
                console.log(sel+" "+qu)
                $.ajax({
                    url: 'fetch.php',
                    type: 'POST',
                    data: {action:'search',userid:userid, select:sel,query:qu},
                    success: function(response){
                        console.log(response)
                        if(response){
                            
                            while($('.clickable').length){
                                $('.clickable').remove();
                            }
                            
                            $('tbody').append(response);
                        }else{
                            
                        }

                    }
                });
            });

        });
    </script>
  <link rel="stylesheet" href="css/movies.css">
</head>
<body>
<h1 style="color: white">My dashboard!</h1>
    <?php include('navbar.php'); ?>
    <div class="search">
    <form  class='srch' action="movies.php" method='post' onchange="text2date();">
        <select name="sel" id="sel">
            <option value="title">Title</option>
            <option value="cinema">Cinema</option>
            <option value="category">Category</option>
            <option value="date">Date</option>
            <!-- <option value="enddate">End Date</option> -->
            
        </select>
        <input  type="search" name="qu" id="qu">
        <input type="submit" value="Search">
        <button onclick="location.href='favorites.php'" type="button">Favorites</button>
    </form><br>

    </div>



    

                
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

<?php
        // while ($row = $movies->fetch_assoc()) { 
                   
        //     echo "<tr class='clickable' style='cursor:default'>";
        //         echo "<td>"  . $row['TITLE'] . "</td>";
        //         echo "<td>" . $row['STARTDATE'] . "</td>";
        //         echo "<td>" . $row['ENDDATE'] . "</td>"; 
        //         echo "<td>" . $row['CINEMANAME'] . "</td>"; 
        //         echo "<td>" . $row['CATEGORY'] . "</td>";
        //         $movid=$row["ID"];
                
        //         $sql="SELECT * FROM favorites WHERE MOVIEID='$movid' AND USERID='$usid' LIMIT 1";
        //         if($results=$conn->query($sql)){
        //             //if movies on favorites or not different "button" is displayed
        //             if(mysqli_num_rows($results)){
        //                 echo '<td><button onclick="fav('.$row["ID"].');" class="addfav'.$row["ID"].'" data-id='.$row["ID"].'>Remove</button></td>';
        //             }else{
        //                 echo '<td><button onclick="fav('.$row["ID"].');" class="addfav'.$row["ID"].'" data-id='.$row["ID"].'>Add</button></td>';
        //             }
        //         }else{
        //             echo '<td><button onclick="fav('.$row["ID"].');" class="addfav'.$row["ID"].'" data-id='.$row["ID"].'>Add</button></td>';
        //         }

                
                
        //     echo "</tr>";
           
        //}
        
        echo "</table>";
        echo "</div>";
        
?>

<div class='dialog'>

</div>
            

        
</body>
</html>