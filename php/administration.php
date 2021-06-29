<!-- NOT USED ANYMORE -->
<!-- NOT USED ANYMORE -->
<!-- NOT USED ANYMORE --><!-- NOT USED ANYMORE -->
<!-- NOT USED ANYMORE -->
<!-- NOT USED ANYMORE -->

<?php include('server.php');
$_SESSION['msg']='';

//if not logged in redirect to login page
if(!isset($_SESSION['username'])){
    $_SESSION['msg'] = "You must log in first to view this page!";
    //echo $_SESSION['msg'];
    header('location: index.php?' .$_SESSION['msg']);
}

//logged in
if(isset($_SESSION['username'])){
    //if not admin redirect to welcome
	if($_SESSION['role']!='ADMIN'){
    $_SESSION['msg'] = "You are not an admin!";
    //echo $_SESSION['msg'];
    header('location: welcome.php?'. $_SESSION['msg'] );
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/clapper.png">
    <title>Admin</title>
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
    
      $( function() {
    $( "#dialog" ).dialog({
      autoOpen: false,
      show: {
        effect: "blind",
        duration: 1000
      },
      hide: {
        effect: "explode",
        duration: 1000
      }
    });
      });
     function upd(id1) {
		//$(".update").click(function () {
			//takes the ID of appropriate dialogue
            var id=id1;
            console.log(id)
            var el='tr#'+id;
            var name=$(el).children('td#name').html();
            var surname=$(el).children('td#surname').html();
            var username=$(el).children('td#username').html();
            var email=$(el).children('td#email').html();
            var role=$(el).children('td#role').html();
            var confirmed=$(el).children('td#con').html();
            console.log(confirmed)
		   //open dialogue
			 $("#dialog").dialog("open");
             $(".txtField").val(id);
             $('input#name').val(name);
             $('input#surname').val(surname);
             $('input#username').val(username);
             $('input#password').val('');
             $('input#email').val(email);

            $('option#'+role).prop('selected','selected');
            
             if(confirmed=='true'){
                 confirmed=1;
             }else confirmed=0;
             $('input#confirmed').prop('checked',confirmed);
           
		//});
	

 

  } 
    
    </script>
    <script>
        function dele(id1){
            //$(document).ready(function(){

            // Delete 
            //$('.delete').click(function(){
            //var el = this;
            currentid= <?php echo $_SESSION['current_id'] ?>;

            // Delete id
            var deleteid = id1;
            //console.log($(this))
            //var confirmalert = confirm("Are you sure?");
           // if (confirmalert == true) {
                if( currentid==deleteid){
                    alert('Can\'t delete your own acount!');
                }else{
                    // AJAX Request
                    $.ajax({
                    url: 'delete.php',
                    type: 'POST',
                    data: { id:deleteid,user:"" },
                    success: function(response){

                        if(response == 1){
                    // Remove row from HTML Table
                    $('tr#'+id1).css('background','#ddd');
                    $('tr#'+id1).fadeOut(800,function(){
                        $(this).remove();
                    });
                        }else{
                        
                    alert('Error.');
                        }

                    }
                    });
                }

           // }

            //});

           // });
        }

$(document).ready(function(){
$('#upd_form').submit(function(){
event.preventDefault();
var id=$(".txtField").val();
var name=$('input#name').val();
var surname=$('input#surname').val();
var username=$('input#username').val();
var password=$('input#password').val();
var email=$('input#email').val();
var role= $('select#role').val();

var confirmed=$('input#confirmed').is(':checked');
if(confirmed){
    confirm=1;
}else confirm=0;

var submit= $('input#update').val();
           



        // AJAX Request
        $.ajax({
        url: 'update.php',
        type: 'POST',
        data: {id:id,name:name,surname:surname,username:username,password:password,email:email,role:role,confirmed:confirm,update:submit},
        success: function(response){
            console.log(response)
            if(response != ''){
                
                    var row='tr#'+id;
                    var htmlrow="<td id='id'>"+response+"</td>"+
                        "<td id='name'>"+name+"</td>"+
                        "<td id='surname'>"+surname+"</td>"+
                        "<td id='username'>"+username+"</td>"+ 
                        "<td id='email'>" +email+"</td>"+
                        "<td id='role'>"+role+"</td>"+
                        "<td id='con'>"+confirmed+"</td>"+
                        "<td><button class='update' onclick='upd("+response+");' >Update</td>"+
                        "<td style='cursor:pointer'>"+
                    "<button class='delete' onclick='dele(\""+response+"\");' >Delete"+
                      "</td>";
                      $("#dialog").dialog( "close" );
                    $(row).html(htmlrow);
                    

                

            }else{
            
        alert('Error.');
            }

        }
        });

    



});

});


    </script>
</head>
<body>
    <h1 style="color: white">Administration!</h1>

<?php include('navbar.php');
//get all users
$sql = "SELECT * FROM users";
$users = $conn->query($sql);
//print table of users
    echo '<div class="scrollable">';
    echo '<table style="width:100%;text-align: center;">
    
     <tr style="cursor:default">
       <th>ID</th>
       <th>Name</th>
       <th>Surname</th>
       <th>Username</th>
       <th>Email</th>
       <th>Role</th>
       <th>Confirmed</th>
       <th style="text-align:center;" colspan="2">Actions</th>

     </tr>'
     ; 
     
    while ($row = $users->fetch_assoc()) { 
       
        echo "<tr id='". $row['ID'] ."'class='clickable' style='cursor:default'>";
            echo "<td id='id'>"  . $row['ID'] . "</td>";
            echo "<td id='name'>"  . $row['NAME'] . "</td>";
            echo "<td id='surname'>" . $row['SURNAME'] . "</td>";
            echo "<td id='username'>" . $row['USERNAME'] . "</td>"; 
            echo "<td id='email'>" . $row['EMAIL'] . "</td>";
            echo "<td id='role'>"  . $row['ROLE'] . "</td>";
            $checked='';
            if($row['CONFIRMED']){
                echo "<td id='con'>true</td>"; 
            }else{
            echo "<td id='con'>false</td>"; 
            }
            //update or delete user
            echo '<td><button class="update" onclick="upd(\''.$row['ID']. '\');">Update</td>';
            //echo '<td><a href="delete.php?user&id='. $row["ID"].'">Delete</a></td>';
            echo "<td style='cursor:pointer'>
            <button class='delete' onclick='dele(\"" .$row['ID']."\");' >Delete
          </td>";
        echo "</tr>";
       
    }
    
    echo "</table>";
    echo "</div>";


?>

    <div id='dialog'>
        <form id='upd_form' action="update.php" method='post'>
        
        <label for="name">Name:</label><br>
        <input type="hidden" name="id" class="txtField" >
        <input type="text" name="name" id='name'><br>
        <label for="surname">Surname:</label><br>
        <input type="text" name="surname" id='surname'><br>
        <label for="username">Username:</label><br>
        <input type="text" name="username" id='username'><br>
        <label for="password">New Password:</label><br>
        <input type="password" name="password" id='password'><br>
        <label for="email">Email:</label><br>
        <input type="email" name="email" id="email" onkeyup="validateEmail();" ><br>
        <span id="valid-email"></span> <br>
        <label for="role" >Select a Role</label><br>       
        <select name="role" id="role">
        <option id='USER' value="USER">User</option>
        <option id='CINEMAOWNER' value="CINEMAOWNER">Cinema Owner</option>
        <option id='ADMIN' value="ADMIN">Admin</option>
        </select><br>
        <label for="confirmed">Confirmed</label>
        <input name="confirmed"  id="confirmed" type="checkbox" >
        <br> <br>
        <input type="submit" value="Update!"  name="update" id="update" >
        
        
        </form>
    </div>
     
</body>
</html>