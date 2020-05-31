<?php
// headers to access through http
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");

include_once "../../../../PHPprocessing/simplexlsx-master/simplexlsx-master/src/SimpleXLSX.php";
include_once "../../config/Database.php";
include_once "../../models/post.php";

$results = [];
$file = $_FILES['postcode']['tmp_name'];
$filename = $_FILES['postcode']['name'];

$row = 1;

$fileinfo = pathinfo($filename, PATHINFO_EXTENSION);
var_dump($_FILES);

if($fileinfo == "xlsx"){
$allowed = array("Post code", "postcode", "POSTCODE", "Post Code", "PostCode", "Postcode");

if ( $xlsx = SimpleXLSX::parse($file) ) {
    // Produce array keys from the array values of 1st array element
	$header_values = $rows = [];
	foreach ( $xlsx->rows() as $k => $r ) {
        if ( $k === 0 ) {
            $header_values = $r;
			continue;
        }
        
        // get the individual header titles and compare to array of postcodes to see if theres a match
        for($i = 0; $i < count($header_values); $i++){
            if(in_array($header_values[$i], $allowed)){
                
                array_push($results, $r[$i]);
            }
            
        }
        // var_dump($header_values[$k]);
	}
}
} else if ($fileinfo == "csv"){
    if (($handle = fopen($file, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $num = count($data);
            $row++;
            for ($c=0; $c < $num; $c++) {
                echo $data[$c] . "<br />\n";
                $results[] = $data[$c];
                $keys = array_keys($data);
        }
    }
    fclose($handle);
}
} else if ($fileinfo == "txt"){
    $lines = file($file, FILE_IGNORE_NEW_LINES);

    // var_dump($lines);
    foreach($lines as $l){
        array_push($results, $l);
    }

} else {
    echo "Please upload files in csv, txt or xlsx format";
    exit();
}

// var_dump($results);
// seperating each value to a string to be read by sql
$array = array();

foreach($results as $p){
    $p = "'" . $p . "'";
    array_push($array, $p);
}
$com_seperated = implode(",", $array);

// instantiate db and connect

$database = new Database();

$db = $database->connect();

// instantiate post 

$post = new Post($db);

// query
$result = $post->read($com_seperated);

$num = $result->rowCount();

foreach($results as $res){
    $q[] = $res;
}
// var_dump($q);
if($num > 0){
    print_r($res);
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

// check if any post
