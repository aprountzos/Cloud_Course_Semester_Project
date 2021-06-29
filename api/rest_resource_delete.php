<?php
$sub_id='';
// required headers

// include database file
include_once 'mongodb_config.php';

$dbname = 'movieapp';
$post_data = file_get_contents("php://input");
$post = json_decode($post_data,true);
$delete = new MongoDB\Driver\BulkWrite();

//DB connection
$db = new DbManager();
$conn = $db->getConnection();

if($post['action']=='delete_movie'){
    $collection = 'movies';
    $id = new MongoDB\BSON\ObjectID($post['id']);
    $delete->delete(
        ['_id' => $id],
        ['limit' => 1]
    );
    $result = $conn->executeBulkWrite("$dbname.$collection", $delete);
}
if($post['action']=='remove_fav'){
    $collection = 'favorites';
    $id =$post['movie_id'];
    $userid=$post['userid'];
    $filter = ["userid" => $userid,"movieid"=>$id];
    $option = [];
    $read = new MongoDB\Driver\Query($filter, $option);
    
    //fetch records
    $favorites = $conn->executeQuery("$dbname.$collection", $read);
    $favorites = $favorites->toArray();
    $favorite = $favorites[0];
    $favorite= json_decode(json_encode($favorite),true);
    
    $sub_id=(string)$favorite['sub_id'];

    $delete->delete(
        ['movieid' => $id,'userid'=>$userid],
        ['limit' => 0]
    );
    $result = $conn->executeBulkWrite("$dbname.$collection", $delete);
    $delete2 = new MongoDB\Driver\BulkWrite();
    $collection='notifications';
    $delete2->delete(
        ['subscriptionId'=>$sub_id],
        ['limit'=>0]
    );
    $conn->executeBulkWrite("$dbname.$collection", $delete2);
}





//print_r($result);

// verify
if ($result->getDeletedCount()) {
    echo json_encode(
		array("response" => 1,"sub_id"=>$sub_id)
	);
} else {
    echo json_encode(
            array("response" => 0)
    );
}

?>