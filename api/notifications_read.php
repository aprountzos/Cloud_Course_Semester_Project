<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database file
include_once 'mongodb_config.php';
$data=array();
$dbname = 'movieapp';
$post_data = file_get_contents("php://input");
$post = json_decode($post_data,true);
//DB connection
$db = new DbManager();
$conn = $db->getConnection();
$collection = 'movies';
$userid=$post['userid'];
// read all records
$filter = [];
$option = [];
$read = new MongoDB\Driver\Query($filter, $option);

//fetch records
$movies = $conn->executeQuery("$dbname.$collection", $read);

$collection = 'favorites';
// read all favs
$filter = ["userid" => $userid];
$option = [];
$read = new MongoDB\Driver\Query($filter, $option);

//fetch favorites
$favorites = $conn->executeQuery("$dbname.$collection", $read);
$favorites = $favorites->toArray();
    foreach($movies as $movie){
        $id=(string)$movie->_id;
        $title=$movie->title;
        $movie= json_decode(json_encode($movie),true);
        if(count($favorites)){
            foreach($favorites as $favorite){
                $favorite= json_decode(json_encode($favorite),true);
                if($favorite['movieid']==$id){
                    $mov['title']=$title;
                    $mov['sub_id']=$favorite['sub_id'];
                    $movs[]=$mov;
                }
            }
        }
       
       
        
        
    }
$collection='notifications';
$filter =array('count' => array( '$gt' => 1));
$option = ['sort' => ['count' => -1]];
$read = new MongoDB\Driver\Query($filter, $option);
$data = $conn->executeQuery("$dbname.$collection", $read);
$data =$data->toArray();
    foreach($data as $note){
        $note= json_decode(json_encode($note),true);
       foreach($movs as $movie){
           if($movie['sub_id']==$note['subscriptionId']){
                $notification['sub_id']=$note['subscriptionId'];
                $notification['count']=$note['count'];
                $notification['title']=$movie['title'];
                $notification['start']=$note['data'][0]['startdate']['value'];
                $notification['end']=$note['data'][0]['enddate']['value'];
                $notifications[]=$notification;
           }
       }
    }
echo json_encode($notifications);


?>