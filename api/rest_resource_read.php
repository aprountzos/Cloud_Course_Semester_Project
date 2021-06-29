<?php

// required headers


// include database file
include_once 'mongodb_config.php';

$dbname = 'movieapp';
$post_data = file_get_contents("php://input");
$post = json_decode($post_data,true);


//DB connection
$db = new DbManager();
$conn = $db->getConnection();

if($post['action']=='get_cine'){
    $collection = 'cinemas';
    $owner =$post['user'];
    $filter =["owner" => $owner];
    $option = ['limit' => 0];
    $read = new MongoDB\Driver\Query($filter, $option);
    $data = $conn->executeQuery("$dbname.$collection", $read);
    $data =$data->toArray();
    $data=$data[0];
    
}
if($post['action']=='fetch_mine'){
    $collection = 'movies';
    $cine =$post['cine_name'];
    $filter =["cinema" => $cine];
    $option = [];
    $read = new MongoDB\Driver\Query($filter, $option);
    $movies = $conn->executeQuery("$dbname.$collection", $read);
    $data =$movies->toArray();
    //$data =json_decode(json_encode($movies),true);//$movies->toArray();

    
}
if($post['action']=='fetch_all' || $post['action']=='search'){
if($post['action']=='search'){
    $field=$post['select'];
    $query=$post['query'];
    if($field=='date'){
        $filter=array('startdate'=>array ('$lte'=>new MongoDB\BSON\UTCDateTime((new DateTime($query))->getTimestamp()*1000)),
        'enddate'=>array ('$gte'=>new MongoDB\BSON\UTCDateTime((new DateTime($query))->getTimestamp()*1000))
    );   
    }else{
        $value = new MongoDB\BSON\Regex(trim($query, '/'), 'i');
        $filter = array($field => $value);
    }

}else{
    $filter =[];
}

$collection = 'movies';
$userid=$post['userid'];
// read


$option = [];
$read = new MongoDB\Driver\Query($filter, $option);

//fetch records
$movies = $conn->executeQuery("$dbname.$collection", $read);

$collection = 'favorites';
// read all favs
$filter = ["userid" => $userid];
$option = [];
$read = new MongoDB\Driver\Query($filter, $option);

//fetch records
$favorites = $conn->executeQuery("$dbname.$collection", $read);
$favorites = $favorites->toArray();
    foreach($movies as $movie){
        $id=(string)$movie->_id;
        $movie= json_decode(json_encode($movie),true);
        if(count($favorites)){
        foreach($favorites as $favorite){
            $favorite= json_decode(json_encode($favorite),true);
                if($favorite['movieid']==$id){
                    $movie['favorite']='Remove';
                    break;
                }else{
                    $movie['favorite']='Add';
                }
            }
         }else{
            $movie['favorite']='Add';
         }

        $data[]=$movie;
        
    }

};
if($post['action']=='fetch_fav'){
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
    
    //fetch records
    $favorites = $conn->executeQuery("$dbname.$collection", $read);
    $favorites = $favorites->toArray();
        foreach($movies as $movie){
            $id=(string)$movie->_id;
            $movie= json_decode(json_encode($movie),true);
            if(count($favorites)){
                foreach($favorites as $favorite){
                    $favorite= json_decode(json_encode($favorite),true);
                    if($favorite['movieid']==$id){
                        $movie['favorite']='Remove';
                        $data[]=$movie;
                    }
                }
            }
           
           
            
            
        }
      
  
}



echo json_encode($data);

?>