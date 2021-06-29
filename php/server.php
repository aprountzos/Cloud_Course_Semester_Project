<!-- NOT USED ANYMORE -->
<!-- NOT USED ANYMORE -->
<!-- NOT USED ANYMORE -->
<!-- NOT USED ANYMORE -->
<!-- NOT USED ANYMORE -->
<!-- NOT USED ANYMORE -->
<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
session_start();


//connection info
$servername = 'db';
$server_username = 'devuser';
$conn_password = 'devpass';
$dbname = 'movieapp';



$errors =array();
$usererror ="";
$emailerror ="";

//Create Connection
$conn= new mysqli($servername, $server_username, $conn_password, $dbname);
//Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//init varriables
$name ='';
$surname ='';
$username ='';
$password ='';
$email ='';
$role ='';




































