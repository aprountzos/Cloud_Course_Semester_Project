<?php include('server.php'); 

if (isset($_POST['login'])){

    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);
 
    $errorUsername = false;
    $errorPass = false;
    $errorConfirmed = false;


$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, 'http://fiware-keyrock:3005/oauth2/token');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_POST, 1);
$data='grant_type=password&username='.$username.'&password='.$password;
curl_setopt($curl, CURLOPT_POSTFIELDS,$data);
$headers = array();
$base=base64_encode('47d82f21-32be-45a6-95c5-4f2ba0bb7631:e03b2fdc-5a09-4f35-ba83-2daf3e7a237b');
$headers[] = 'Authorization: Basic '.$base.'==';
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($curl);
$result = json_decode($result,1);
$access_token=$result['access_token'];
curl_close($curl);


      
        if($access_token!=null){
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://fiware-keyrock:3005/user?access_token='.$access_token,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Cookie: session=eyJyZWRpciI6Ii8ifQ==; session.sig=TqcHvLKCvDVxuMk5xVfrKEP-GSQ'
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // echo $response;
            $response=json_decode($response,1);
            $id=$response['id'];
            $username=$response['username'];
            $roles=$response['roles'];
            if($roles[0]==null){
                $role=null;
            }else {
                $role=$roles[0]['name'];
            } 

            if($role!=null){
                $_SESSION['username'] = $username;
                $_SESSION['fullname'] = $username;
                $_SESSION['role'] = $role;
                $_SESSION['current_id'] = $id;
                $_SESSION['success'] = $success;
                $_SESSION['access_token']=$access_token;

                echo "<script>
                window.location.replace('welcome.php');
                </script>";
            }else{
                echo "<span class='form-error'>User is not confirmed!</span>";
                $errorConfirmed = true;
                
                //array_push($errors, 'User is not confirmed. Wait for admin to confirm your acount.');
            }
        }else{
            echo "<span class='form-error'>Wrong username/password combination. Try again!</span>";
            $errorPass = true;
            
            //array_push($errors, 'Wrong username/password combination. Try again!');
        }
    }



?>


<script>
    //$("#username","#password").removeClass("input-error");
    var errorUsername = "<?php echo $errorUsername; ?>";
    var errorPass = "<?php echo $errorPass; ?>";
    

    if (errorUsername == true){
        $("#username").addClass("input-error");
        
    }
    if (errorPass == true){
        $("#password").addClass("input-error");
        
    }



    if (errorUsername == false){
        $("#username").removeClass("input-error");
    }
    if (errorPass == false){
        $("#password").removeClass("input-error");
    }
    

</script>
