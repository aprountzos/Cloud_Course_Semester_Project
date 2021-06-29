<?php

// required headers

// include database file
include_once 'mongodb_config.php';

$dbname = 'movieapp';

$post_data = file_get_contents("php://input");
$post = json_decode($post_data,true);
$db = new DbManager();
$conn = $db->getConnection();
$insert = new MongoDB\Driver\BulkWrite();

if($post["action"]=='add_fav'){
        $collection = 'favorites';
        $userid=$post['userid'];
        $movieid=$post['movie_id'];
        $sub_id=$post['sub_id'];
        $data=array(
                'userid' => $userid,
                'movieid' => $movieid,
                'sub_id'=>$sub_id
        );
        $insert->insert($data);

        $result = $conn->executeBulkWrite("$dbname.$collection", $insert);

        // verify
        if ($result->getInsertedCount()) {
        echo json_encode(
                        array("response" => 1)
                );
        } else {
        echo json_encode(
                array("response" => 0)
        );
        }

}
if($post['action']=='set_cine'){
        $collection='cinemas';
        $name=$post['cine_name'];
        
        $owner=$post['user'];
        $filter =["owner" => $owner,'name'=>$name];
        $option = ['limit' => 1];
        $read = new MongoDB\Driver\Query($filter, $option);
        $data = $conn->executeQuery("$dbname.$collection", $read);

        if(count($data->toArray())){
                echo json_encode(
                        array("error" => 1)
                );
        }else{
                $data=array(
                        'name'=>$name,
                        'owner'=>$owner
                );
                $insert->insert($data);
        
                $result = $conn->executeBulkWrite("$dbname.$collection", $insert);
        
                // verify
                if ($result->getInsertedCount()) {
                echo json_encode(
                                array("error" => 0)
                        );
                } else {
                echo json_encode(
                        array("error" => 1)
                );
                }
        }
       

}
if($post['action']=='Register'){
        
        $collection = 'movies';
        $title=$post['title'];
        $startdate=$post['start'];
        $enddate =$post['end'];
        $cinema =$post['cinema'];
        $category=$post['category'];
        $data=array(
                'title' =>$title,
                'startdate'=>new MongoDB\BSON\UTCDateTime((new DateTime($startdate))->getTimestamp()*1000),
                'enddate'=>new MongoDB\BSON\UTCDateTime((new DateTime($enddate))->getTimestamp()*1000),
                'cinema'=>$cinema,
                'category'=>$category
        );
        $id=(string)$insert->insert($data);
        $result = $conn->executeBulkWrite("$dbname.$collection", $insert);

        // verify
        if ($result->getInsertedCount()) {
        echo json_encode(
                        array("id" => $id)
                );
        } else {
        echo json_encode(
                array("id" => '')
        );
        }
}


//DB connection


?>