<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database file
include_once 'mongodb_config.php';

$dbname = 'movieapp';
$post_data = file_get_contents("php://input");
$post = json_decode($post_data,true);
$delete = new MongoDB\Driver\BulkWrite();

//DB connection
$db = new DbManager();
$conn = $db->getConnection();
$collection = 'notifications';
$delete->delete(
    ['count' => (int)$post[count],'subscriptionId'=>$post['sub_id']],
    ['limit' => 0]
);
$result = $conn->executeBulkWrite("$dbname.$collection", $delete);

if($result->getDeletedCount()){
    echo json_encode(
		array("response" => 1)
	);
}else{
    echo json_encode(
            array("response" => 0)
    );
}
?>