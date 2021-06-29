
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinematrix</title>
    <link rel="icon" href="img/clapper.png">
    <script type="text/javascript" src="funcs.js"></script> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/index.css">

    <script>
        $(document).ready(function(){
            $("#loginform").submit(function(event){
                event.preventDefault();
                var username = $("#username").val();
                var password = $("#password").val();
                var login = $("#login").val();
                $(".form-message").load("checklogin.php", {
                    username: username,
                    password: password,
                    login: login
                })

            });
        });
    </script>

</head>



<body>

    <div class="container" >

        <div class="header">

            <h2>Log in</h2>
            

        </div>

        <form id='loginform' method="post" action="checklogin.php" onKeyup='check_login_form();'>

            

            <div >
                <label for="username">Email:</label><br>
                <input  id="username" type="email" name="username" required>
            </div>

            <div >
                <label for="password">Password:</label><br>
                <input  id="password" type="password" name="password" id="password"  required>
                <br><br>
            </div>
               <input  type="submit" name="login" value="Log In!" disabled="disabled" id="login" >
               <br>
               <span style="color:red"class="form-message"></span>
               <br>
               <p>Don't you have an account?<a href="http://localhost:3005/sign_up/" > <b>Register</b></a></p>
               <br>
               <p>Are you an admin?<a href="http://localhost:3005/idm" > <b>Administration</b></a></p>
            </div>
            


        </form>


    </div>

    
</body>

</html>