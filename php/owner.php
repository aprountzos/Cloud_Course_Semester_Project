<?php
$_SESSION['msg']='';
include('server.php');
//if not logged in redirect to login page
if(!isset($_SESSION['username'])){
    $_SESSION['msg'] = "You must log in first to view this page!";
    //echo $_SESSION['msg'];
    header('location: index.php?' .$_SESSION['msg']);
}
//logged in
if(isset($_SESSION['username'])){
    //if not cinema owner redirect to welcome
	if($_SESSION['role']!='CINEMAOWNER'){
    $_SESSION['msg'] = "You are not a Cinema Owner!";
    //echo $_SESSION['msg'];
    header('location: welcome.php?'. $_SESSION['msg'] );
}else{
 
}


}



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cinema</title>
    <link rel="stylesheet" href="css/form.css">
    <link rel="icon" href="img/clapper.png">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="funcs.js"></script> 
    <style>


        .scrollable {
            height: 250px;
        }

    </style>
<script>
  $( function() {
    $( "#dialog_cine" ).dialog({
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
  } );
  </script>
  <script>
    $(document).ready(function(){
        var cinename='<?php echo $_SESSION['cine_name'];?>';
        begin();
        console.log(cinename);
    $('#add_cinema').submit(function(){
        //ADD CINEMA FOR THIS OWNER
    event.preventDefault();
    var user='<?php echo $_SESSION['username']; ?>' ;
    var cine_name = $('.reg_cine').val();
    
    console.log(cine_name)
    var action = 'set_cine';
    
    $.ajax({
        url:'fetch.php',
        type:'post',
        data:{action:'set_cine',user:user,cine_name:cine_name},
        success:function(data){
            console.log(data);
            if(data==0){
                cinename=cine_name;
            $("#dialog_cine").dialog( "close" );
            begin();

            }

        }
    });

    
});


        function begin(){
            //IF NOT CINEMA->ADD ELSE SHOW MOVIES REGISTERED BY THIS USER++
        if(cinename==''){
            $("#dialog_cine").dialog("open");
        }else{
            var htm='<br><br><br>'+
            '<button class="opener" onclick="registerAmovie();" >Register movie</button>'+
            '<div style="overflow-x:auto;">'+
                '<div class="scrollable">'+
                    '<table style="width:100%;text-align: center;">'+
                    '<thead>'+
                        '<tr style="cursor:default">'+
                            '<th>TITLE</th>'+
                            '<th>START DATE</th>'+
                            '<th>END DATE</th>'+
                            '<th>CINEMA NAME</th>'+
                            '<th>CATEGORY</th>'+
                            '<th style="text-align:center;" colspan="2">Actions</th>'+
                        '</tr>'+
                    '</thead>'+
                    '<tbody>'+
                    '</tbody>'+
                '</div>'+
            '</div>';
            $('.main').html(htm);
            fetch_mine(cinename);
        }
        }



        function fetch_mine(cine_name){
           //SHOW THIS OWNER'S MOVIES
           //console.log(cine_name);
           $.ajax({
               type:'POST',
               url:"fetch.php",
               data:{action:'fetch_mine',cine_name:cine_name},
               success:function(data){
                  console.log(data);
                   $('tbody').html(data);
               }
           })
       }

       $('#reg_up_mov').submit(function(){
           //REGISTER/UPDATE A MOVIE
event.preventDefault();
var el = this;

// Register id
var id = $('input.txt').val();
var title = $('input#title').val();
var start = $('input#start').val();
var end = $('input#end').val();
var cine = $('input.cine').val();
if(cine=='' || cine==null){
    cine=cinename;
}
var submit = $('input.re').val();
var cate = $('input#cate').val();

//console.log(title+" "+cine)

        // AJAX Request
        $.ajax({
        url: 'fetch.php',
        type: 'POST',
        data: { id:id,title:title,cinema:cine,start:start,end:end,category:cate,action:submit },
        success: function(response){
            console.log(response)
            if(response != ''){
                if(submit=='Register'){
                    if($('tr#noData').length){
                        $('tr#noData').remove();
                    }
                    var row="<tr id="+response+" class='clickable' style='cursor:default'>"+
                        "<td style='display:none;' id='id'>"+response+"</td>"+
                        "<td id='title'>"+title+"</td>"+
                        "<td id='startd'>"+start+"</td>"+
                        "<td id='endd'>"+end+"</td>"+ 
                        "<td id='cine'>"+cine+"</td>"+
                        "<td id='cate'>"+cate+"</td>"+
                        "<td><button class='update"+response+"' onclick=\"upda('"+response+"');\">Update</button></td>"+
                        "<td>"+
                    "<button class='delete"+response+"' onclick=\"delet('"+response+"');\">Delete</button>"+
                      "</td>"+
                    "</tr>";
                    $("#dialog").dialog( "close" );
                    $('tbody').append(row);
                }else if(submit=='Update'){
                    var row='tr#'+response;
                    var htmlrow="<td style='display:none;' id='id'>"+response+"</td>"+
                        "<td id='title'>"+title+"</td>"+
                        "<td id='startd'>"+start+"</td>"+
                        "<td id='endd'>"+end+"</td>"+ 
                        "<td id='cine'>"+cine+"</td>"+
                        "<td id='cate'>"+cate+"</td>"+
                        "<td><button class='update"+response+"' onclick=\"upda('"+response+"');\">Update</button></td>"+
                        "<td>"+
                    "<button class='delete"+response+"' onclick=\"delet('"+response+"');\">Delete</button>"+
                      "</td>";
                      $("#dialog").dialog( "close" );
                    $(row).html(htmlrow);
                    $('input.re').val("Register");
                    

                }

            }else{
            
        alert('Error.');
            }

        }
    });
    



});
    })

       

    
    function registerAmovie() {
			//takes the ID of appropriate dialogue

		   //open dialogue
			$("#dialog").dialog("open");
            $('input#title').val('');
            $('input#start').val('');
            $('input#end').val('');
            $('input#cate').val('');
	}

    function upda(id1) {
        
        
		//$(".update").click(function () {
			//takes the ID of appropriate dialogue
           
            var el='tr#'+id1;
            var title=$(el).children('td#title').html();
            var start=$(el).children('td#startd').html();
            var end=$(el).children('td#endd').html();
            var cine=$(el).children('td#cine').html();
            var cate=$(el).children('td#cate').html();
            //console.log(title)
		   //open dialogue
			$("#dialog").dialog("open");
            $(".txt").val(id1);
            $('input#title').val(title);
            $('input#start').val(start);
            $('input#end').val(end);
            $('input#cate').val(cate);
            $('input.cine').val(cine);
            $('input.re').val('Update');
		//});
	}


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
  } );

  </script>



    <script>
        function delet(id1){
            

                // Delete A MOVIE
               
                var elem=".delete"+id1;
                var el = $(elem);

                // Delete id
                var id = id1;
                //var cinema = $(this).data('cine');
                console.log(id)
                var confirmalert = confirm("Are you sure?");
                if (confirmalert == true) {
                        // AJAX Request
                        $.ajax({
                        url: 'fetch.php',
                        type: 'POST',
                        data: { id:id,action:"delete_movie" },
                        success: function(response){
                            console.log(response)
                            if(response == 1){
                        // Remove row from HTML Table
                        $(el).closest('tr').css('background','#ddd');
                        $(el).closest('tr').fadeOut(800,function(){
                            $(this).remove();
                        });
                            }else{
                            
                        alert('Error.');
                            }

                        }
                        });
                    

                }

                //});

                //});
        }
              

$(document).ready(function(){


});
        



    </script>

   
    

</head>
<body>
<h1 style="color: white">Cinema Manager!</h1>
    
    <?php include_once('navbar.php'); ?>
    <div class='main'>
    
    </div>
 
        
    <div id='dialog'>

        <form id='reg_up_mov' action="fetch.php" method='post'>
            
       <input type="hidden" name="id" class="txt" >
       <label for="title"><b>Title:</b></label><br>
       <input type="text" name="title"id='title' >
       <br>
       <label for="start"><b>Start date:</b></label><br>
       <input type="date" name="start" id='start' >
       <br>
       <label for="end"><b>End date:</b></label><br>
       <input type="date" name="end" id='end'  onchange="validate_date();">
       <br>
       <input type="hidden" name="cinema" value=<?php echo $_SESSION['cine_name'];?>  class='cine' >
       <label for="category"><b>Category:</b></label><br>
       <input type="text" name="category"  id='cate'>
       <br>
       <br>
       <input class='re' type="submit" id='submit'  name="movie"  value="Register"  >
       
       
       <h2 id='val_date'></h2> 
        </form>
    </div>

    <div id='dialog_cine' title='Register your Cinema'>
    <form id='add_cinema' action='fetch.php' method='post'>
        <label for='cinema'>Cinema Name</label><br>
        <input type='text' name='cinema' class='reg_cine'>
        <br><br>
        <input class='cine_reg' type='submit' value='Register Cinema'>
    </form>
    </div>
            
    
 
</body>
</html>