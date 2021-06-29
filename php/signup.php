


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinematrix</title>
    <link rel="icon" href="img/clapper.png">
    <script type="text/javascript" src="funcs.js"></script> 
    <link rel="stylesheet" href="css/signup.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function(){
        $(".regform").submit(function(event){
            event.preventDefault();
            var name = $("#name").val();
            var surname = $("#surname").val();
            var username = $("#username").val();
            var password = $("#password").val();
            var email = $("#email").val();
            var role = $("#role").val();
            var signup = $("#signup").val();
            $(".form-message").load("checkregister.php", {
                name: name,
                surname: surname,
                username: username,
                password: password,
                email: email,
                role: role,
                signup: signup
            })

        });
    });
</script>
</head>




<body>

    <div class="container" >

        <div class="header">

            <h2>Register Here!</h2>
            <p>Fill up the form to create an account.</p>

        </div>

        <form class='regform' id='form' action="checkregister.php" onKeyup="check_reg_form();" method="post" >
        
        

            <div>
                <label for="name">Name:</label><br>
                <input id='name' type="text" name="name" required>
            </div> 

            <div>
                <label for="surname">Surname:</label><br>
                <input id='surname' type="text" name="surname" required>
            </div>

            <div>
                <label for="username">Username:</label><br>
                <input id='username' type="text" name="username" required>
            </div> 

            <div>
                <label for="password">Password:</label><br>
                <input type="password" name="password1" id="password" onkeyup='check();' required>
            </div>
            <div>
                <label for="password">Confirm Password:</label><br>
                <input type="password" name="password2" id="password2" onkeyup='check();' required><br>
                <span id='message'></span> <br>
                
                
            </div>

            <div>
                <label for="email">Email:</label><br>
                <input type="email" name="email" id='email' required onkeyup="validateEmail();" placeholder="example@example.com"><br>
                <span id='valid-email'></span> <br> 
                
            </div>

            <div >
                <label for="role" >Select a Role</label><br>
                <select id='role' name="role">
                <option value="USER">USER</option>
                <option value="CINEMAOWNER">CINEMAOWNER</option>
                <option value="ADMIN">ADMIN</option>
                </select>
                <br>
            </div>
            
    
            <div>
                <input type="submit" value="Submit!" disabled="disabled" name="signup-submit" id="signup" >
                <a href="index.php">
                    <input type="button" value="Cancel" name="cancel-signup" id="cancel-signup" />
                </a>
                <br>
                <span style="color:red"class="form-message"></span>
            </div>
        


        </form>


    </div>

    
</body>

</html>