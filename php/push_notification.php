<!-- GET NOTIFICATION FROM ORION AND SAVE IT TO DB -->
<?php
    include('server.php');
    $stri=substr($_SERVER['PHP_SELF'],strlen('\/push_notification.php\/')-2);
    $id_token=explode('_',$stri);
    $userid=$id_token[0];
    $_SESSION['access_token']=$id_token[1];
    $post_data = file_get_contents("php://input");
    
    $api_url = "fiware-myapi-proxy:7897/notification_create.php";
    $client = curl_init($api_url);
    
    curl_setopt($client, CURLOPT_POST, true);
    curl_setopt ($client, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($client, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($client,CURLOPT_HTTPHEADER ,array(
        'X-Auth-Token:'.$_SESSION['access_token'],
        'Content-Type: application/json'
    ));
  
    $response=curl_exec($client);
    //$response=json_encode($response,true);
    //$response=$response->toArray();
    //$data=json_decode($response,true);
    //$data=json_decode($data,true);
    echo $response;
    curl_close($client);

    $api_url = "fiware-myapi-proxy:7897/rest_resource_update.php";
    $client = curl_init($api_url);
    $response=json_decode($response,true);
    $response['action']='updatefav';
    $response['userid']=$userid;
    $response=json_encode($response);
    echo $response;
    curl_setopt($client, CURLOPT_POST, true);
    curl_setopt ($client, CURLOPT_POSTFIELDS, $response);
    curl_setopt($client, CURLOPT_RETURNTRANSFER,true);
     curl_setopt($client,CURLOPT_HTTPHEADER ,array(
        'X-Auth-Token:'.$_SESSION['access_token'],
         'Content-Type: application/json'
     ));
    $response=curl_exec($client);
        
    curl_close($client);
    //echo $response;
?>