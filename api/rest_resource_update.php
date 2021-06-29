<?php


// include database file
include_once 'mongodb_config.php';

$dbname = 'movieapp';

$post_data = file_get_contents("php://input");
$post = json_decode($post_data,true);
//DB connection
$db = new DbManager();
$conn = $db->getConnection();

//record to update
//$data = json_decode(file_get_contents("php://input", true));
if($post['action']=="Update"){
    $collection = 'movies';
    $id=$post['id'];
    $title=$post['title'];
    $start=$post['start'];
    $end =$post['end'];
    $cinema =$post['cinema'];
    $category=$post['category'];
    $fields=array(
        'title'=>$title,
        'startdate'=>new MongoDB\BSON\UTCDateTime((new DateTime($start))->getTimestamp()*1000),
        'enddate'=>new MongoDB\BSON\UTCDateTime((new DateTime($end))->getTimestamp()*1000),
        'cinema'=>$cinema,
        'category'=>$category
    );
    // update record
$update = new MongoDB\Driver\BulkWrite();
$update->update(
	['_id'=>new \MongoDB\BSON\ObjectID($id)], ['$set' => $fields], ['multi' => false, 'upsert' => true]
);

$result = $conn->executeBulkWrite("$dbname.$collection", $update);

// verify
if ($result->getModifiedCount() == 1) {
    echo json_encode(
		array("id" => $id)
	);
} else {
    echo json_encode(
            array("id" => '')
    );
}

}
if($post['action']=='updatefav'){
    $fields=array(
        'sub_id'=>$post['sub_id']
    );
    $collection='favorites';
    $update = new MongoDB\Driver\BulkWrite();
$update->update(
	['movieid'=>$post['movie_id'],'userid'=>$post['userid']], ['$set' => $fields], ['multi' => false, 'upsert' => false]
);

$conn->executeBulkWrite("$dbname.$collection", $update);
echo json_encode($post_data);
}



?>