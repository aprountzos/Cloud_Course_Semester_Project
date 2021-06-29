<?php
include('fetchNEW.php');
include('server.php');

$api_url = "fiware-myapi-proxy:7897/";
if($_POST['action']=='delete_notification'){
    $post_data = array(
        'sub_id' => $_POST['sub_id'],
        'count' => $_POST['count']
    );
    $api_url .='notification_delete.php';
    $post_data = json_encode($post_data); 
}
if($_POST['action']== 'fetch_all' || $_POST['action']== 'fetch_fav'){
    $post_data = array(
        'action' => $_POST['action'],
        'userid' => $_POST['userid']
    );
    $api_url .='rest_resource_read.php';
    $post_data = json_encode($post_data); 
}
if($_POST['action']=='notify'){
    $post_data=array(
        'action' => $_POST['action'],
        'userid' => $_POST['userid']
    );
    $api_url .='notifications_read.php';
    $post_data = json_encode($post_data); 
}
if($_POST['action']=='search'){
    $post_data = array(
        'action' => $_POST['action'],
        'userid' => $_POST['userid'],
        'select' =>$_POST['select'],
        'query' =>$_POST['query']
    );
    $api_url .='rest_resource_read.php';
    $post_data = json_encode($post_data); 
}
if($_POST['action']=='Add'){
    subscribe($_POST['movie_id'],$_POST['userid']);
    $post_data = array(
        'sub_id'=>'',
        'action' => 'add_fav',
        'userid' => $_POST['userid'],
        'movie_id' => $_POST['movie_id']
    );
    $api_url .='rest_resource_create.php';
    $post_data = json_encode($post_data);
}
if($_POST['action']=='Remove'){
    $post_data = array(
        'action' => "remove_fav",
        'userid' => $_POST['userid'],
        'movie_id' => $_POST['movie_id']
    );
    $api_url .='rest_resource_delete.php';
    $post_data = json_encode($post_data);
}
if($_POST['action']=='fetch_mine'){
    $post_data = array(
        'action' => $_POST['action'],
        'cine_name' => $_POST['cine_name']
    );
    $api_url .='rest_resource_read.php';
    $post_data = json_encode($post_data);
}
if($_POST['action']=='get_cine'){
    $post_data = array(
        'action' => $_POST['action'],
        'user' => $_POST['user']
    );
    $api_url .='rest_resource_read.php';
    $post_data = json_encode($post_data);
}
if($_POST['action']=='set_cine'){
    $post_data = array(
        'action' => $_POST['action'],
        'user' => $_POST['user'],
        'cine_name' => $_POST['cine_name']
    );
    $api_url .='rest_resource_create.php';
    $post_data = json_encode($post_data);
}
if($_POST['action']=='Update'){
    $post_data = array(
        'action' => $_POST['action'],
        'id' => $_POST['id'],
        'title' => $_POST['title'],
        'cinema' => $_POST['cinema'],
        'start' => $_POST['start'],
        'end' => $_POST['end'],
        'category' => $_POST['category']
    );
    $api_url .='rest_resource_update.php';
    $post_data = json_encode($post_data);
}
if($_POST['action']=='delete_movie'){
    $post_data = array(
        'action' => $_POST['action'],
        'id' => $_POST['id']
    );
    delete_movie_entity($_POST['id']);
    $api_url .='rest_resource_delete.php';
    $post_data = json_encode($post_data);
}
if($_POST['action']=='Register'){
    $post_data = array(
        'action' => $_POST['action'],
        'title' => $_POST['title'],
        'cinema' => $_POST['cinema'],
        'start' => $_POST['start'],
        'end' => $_POST['end'],
        'category' => $_POST['category']
    );
    $api_url .='rest_resource_create.php';
    $post_data = json_encode($post_data);
}


$client = curl_init($api_url);
curl_setopt($client, CURLOPT_POST, true);
curl_setopt ($client, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($client, CURLOPT_RETURNTRANSFER,true);
curl_setopt($client,CURLOPT_HTTPHEADER ,array(
    'X-Auth-Token:'.$_SESSION['access_token'],
    'Content-Type: application/json'
));

$response = curl_exec($client);

$result = json_decode($response,true);

$output = '';
if($_POST['action']=='delete_notification'){
    echo 1;
    exit();
}
elseif($_POST['action']=='Add' || $_POST['action']=='Remove' || $_POST['action']=='delete_movie'){
    if($_POST['action']=='Remove'){
        unsubscribe($result['sub_id']);
    }
    echo $result['response'];
    exit();
}
elseif($_POST['action']=='get_cine'){

    $_SESSION['cine_name'] = $result['name'];
    echo $result['name'];
    exit();
    
   
}elseif($_POST['action']=='Update' || $_POST['action']=='Register'){
    $post_data=json_decode($post_data,true);
    if($_POST['action']=='Register'){
        $post_data['id']=$result['id'];
        reg_movie_entity($post_data);
    }elseif($_POST['action']=='Update'){
        update_movie_entity($post_data);
    }
    
    echo $result['id'];
    exit();
}
elseif($_POST['action']=='set_cine'){
    $_SESSION['cine_name']=$_POST['cine_name'];
    echo $result['error'];
    exit();
}
elseif($_POST['action']=='fetch_mine'){
    if($result){
        foreach($result as $row){
            $id=$row['_id'];
            $start=$row['startdate']['$date']['$numberLong']/1000;
            $start =(string)date( "Y-m-d",$start);
            $end=$row['enddate']['$date']['$numberLong']/1000;
            $end=(string)date( "Y-m-d",$end);
            $output .="
            <tr id=". $id['$oid'] ." class='clickable' style='cursor:default'>
            <td style='display:none;' id='id'>"  . $id['$oid'] . "</td>
            <td id='title'>"  . $row['title'] . "</td>
            <td id='startd'>" . $start . "</td>
            <td id='endd'>" . $end . "</td>
            <td id='cine'>" . $row['cinema'] . "</td>
            <td id='cate'>" . $row['category'] . "</td>
            <td><button class='update" .$id['$oid']."' onclick=\"upda('" .$id['$oid']."');\">Update</button></td>
            <td>
            <button class='delete" .$id['$oid']."' onclick=\"delet('" .$id['$oid']."');\">Delete</button>
          </td>
        </tr>";
        }
    }
    else{
        $output .='
        <tr  id="noData" class="clickable" style="cursor:default">
            <td colspan="6" align="center">No Data Found</td>
        </tr>
        ';
    }

}
elseif($_POST['action']== 'fetch_all' || $_POST['action']== 'fetch_fav'||$_POST['action']=='search'){
    if($result){
        foreach($result as $row){
            $id=$row['_id'];
            $start=$row['startdate']['$date']['$numberLong']/1000;
            $start =(string)date( "Y-m-d",$start);
            $end=$row['enddate']['$date']['$numberLong']/1000;
            $end=(string)date( "Y-m-d",$end);
            $output .='
            <tr class="clickable" style="cursor:default">
            <td>'.$row['title'].'</td>
            <td>'.$start.'</td>
            <td>'.$end.'</td>
            <td>'.$row['cinema'].'</td>
            <td>'.$row['category'].'</td>
            <td><button onclick="fav(\''.$id['$oid'].'\');" class="addfav'.$id['$oid'].'" data-id="'.$id['$oid'].'" >'.$row['favorite'].'</button></td>
            </tr>
            ';
    
        }
    
    }
    else{
        $output .='
        <tr id="noData" class="clickable" style="cursor:default">
            <td colspan="6" align="center">No Data Found</td>
        </tr>
        ';
    }

}elseif($_POST['action']=='notify'){
    if($result){
        foreach($result as $row){
            if($row['start']!=null && $row['end']!=null){
                $notification='Start Date changed to: '.$row['start'].', End Date changed to: '.$row['end'].'.';
            }elseif($row['start']!=null){
                $notification='Start Date changed to: '.$row['start'].'.';
            }
            elseif($row['end']!=null){
                $notification='End Date changed to: '.$row['end'].'.';
            }
            $output.='<tr id="'.$row['sub_id'].'-'.$row['count'].'" class="clickable" style="cursor:default">
            <td>
                <ul>
                    <li><b>Movie:"'.$row["title"].'"</b></li><br>
                    <li>'.$notification.'</li><br>
                </ul>
            </td>
            
            <td> 
            <button onclick="deletsub(\''.$row['sub_id']. '\',\''.$row['count']. '\');"> X </button>
            </td>

            </tr>
            ';
           
        }
        
    }
}
curl_close($client);
echo $output;




?>