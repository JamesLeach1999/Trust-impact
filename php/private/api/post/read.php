<?php
// headers to access through http
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");

include_once "../../config/Database.php";
include_once "../../models/post.php";
// include_once "../../../index.php";
// only process if submit is set
if(isset($_POST['postcode'])){
    $postie = $_POST['postcode'];
};

// instantiate db and connect

$database = new Database();

$db = $database->connect();

// instantiate post 

$post = new Post($db);

// query
$result = $post->read($postie);

$num = $result->rowCount();
if($num > 0){
    // post array
    $posts_arr = array();
    $posts_arr['data'] = array();
    
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        $post_item = array();
        extract($row);
        
        $post_item = array(
            "postcode" => $postcode,
            "imd" => $imd
            
    );
    
        // push to "data"
        array_push($posts_arr['data'], $post_item);
    }
    // header("Location: ../../../maps.html");
    
    
    // turn to json
    echo json_encode($posts_arr);
} else {
    echo json_encode(array("message" => "no posts found"));
}

// save to a temporary file to be read by the maps.html page
$fp = fopen("results.json", "w");
fwrite($fp, json_encode($posts_arr));
fclose($fp);
// redirect to maps
header("Location: ../../../maps.html");
// str.replace("/<\/?[^>]+>/gi", '');


// check if any post
