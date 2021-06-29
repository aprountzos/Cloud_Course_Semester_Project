<?php



function delete_movie_entity($id){
  //DELETE MOVIE ENTITY ON ORION
  $url='http://fiware-orion-proxy:1027/v2/entities/'.$id;
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'DELETE',
  CURLOPT_HTTPHEADER => array(
    'X-Auth-Token:'.$_SESSION['access_token']
  ),
  ));
  
  curl_exec($curl);
  
  curl_close($curl);
}


function reg_movie_entity($array){
  //REGISTER MOVIE ENTITY ON ORION
  $post_data='{
    "id":"'.$array['id'].'",
    "type":"Movie",
    "title":{
      "type":"Text",
      "value":"'.$array['title'].'"
    },
    "cinema":{
      "type":"Text",
      "value":"'.$array['cinema'].'"
    },
    "startdate":{
      "type":"Date",
      "value":"'.$array['start'].'"
    },
    "enddate":{
      "type":"Date",
      "value":"'.$array['end'].'"
    },
    "category":{
      "type":"Text",
      "value":"'.$array['category'].'"
    }
}';
  $url='http://fiware-orion-proxy:1027/v2/entities/';
  custom_request($post_data,'POST',$url);
}

function update_movie_entity($array){
  //UPDATE MOVIE ENTITY ON ORION
  $post_data='{
    "title":{
      "type":"Text",
      "value":"'.$array['title'].'"
    },
    "cinema":{
      "type":"Text",
      "value":"'.$array['cinema'].'"
    },
    "startdate":{
      "type":"Date",
      "value":"'.$array['start'].'"
    },
    "enddate":{
      "type":"Date",
      "value":"'.$array['end'].'"
    },
    "category":{
      "type":"Text",
      "value":"'.$array['category'].'"
    }
}';
  $url="http://fiware-orion-proxy:1027/v2/entities/".$array['id']."/"."attrs/";
  custom_request($post_data,'POST',$url);
}

function custom_request($post_data,$req,$url){

    $curl = curl_init();


    curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => $req,
      CURLOPT_POSTFIELDS =>$post_data,
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'X-Auth-Token:'.$_SESSION['access_token']
      ),
    ));
    
    curl_exec($curl);
    
    curl_close($curl);
}

function subscribe($movie_id,$userid){
  //SUBSCRIBE ON MOVIE ENTITY
  $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://fiware-orion-proxy:1027/v2/subscriptions/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{ 
  "description": "Notify me of movie",
  "subject": {
    "entities": [
      {
        "id": "'.$movie_id.'", "type": "Movie"
      }
    ],
     "condition": {
      "attrs": [ "startdate" ,"enddate"]
    }
  },
  "notification": {
    "http": {
      "url": "http://php:80/push_notification.php/'.$userid.'_'.$_SESSION['access_token'].'"
    },
    "attrs":["startdate","enddate"],
      "onlyChangedAttrs": true
  },
    "attrsFormat" : "keyValues"
}',
  CURLOPT_HTTPHEADER => array(
    'content-type: application/json',
    'X-Auth-Token:'.$_SESSION['access_token']
  ),
));

$response = curl_exec($curl);

curl_close($curl);

}

function unsubscribe($sub_id){
  //DELETE SUBSCRIPTION 
  $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://fiware-orion-proxy:1027/v2/subscriptions/'.$sub_id,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'DELETE',
  CURLOPT_HTTPHEADER => array(
    'X-Auth-Token:'.$_SESSION['access_token']
  ),
));

$response = curl_exec($curl);

curl_close($curl);
}
