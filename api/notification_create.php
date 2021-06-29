<?php
include_once 'mongodb_config.php';
$post_data = file_get_contents("php://input");
//$movieid=$post_data->subscriptionId;
//$movieid=$movieid['id'];
$post_data=json_decode($post_data,true);

$db = new DbManager();
$conn = $db->getConnection();
$insert = new MongoDB\Driver\BulkWrite();


// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database file


$dbname = 'movieapp';
$id=(string)$post_data['subscriptionId'];
$movieid=$post_data['data'][0];
$movieid=(string)$movieid['id'];
$collection = 'notifications';

$filter = ['subscriptionId'=>$id];
$option = [];
$read = new MongoDB\Driver\Query($filter, $option);
$notifications = $conn->executeQuery("$dbname.$collection", $read);
$notific = $notifications->toArray();
$count=0;
//count used so if count=1 means user subscribed and will not give notification on read
foreach($notific as $not){
        $not=json_decode(json_encode($not),true);
        if($count<$not['count']){
                $count=$not['count'];
        }
}

$post_data['count']=$count+1;
        $insert->insert($post_data);

        $result = $conn->executeBulkWrite("$dbname.$collection", $insert);

echo  json_encode(array('sub_id'=>$id,'movie_id'=>$movieid,'count'=>$count));