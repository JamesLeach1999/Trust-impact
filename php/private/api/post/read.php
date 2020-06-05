<?php
// headers to access through http
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");

include_once "../../../SimpleXLSX.php";
include_once "../../config/Database.php";
include_once "../../models/post.php";
include_once "../../../reader.php";
// initialize results array
// retrieve file from index.php, also get the filename so the extension can be aquired later
$results = [];
$file = $_FILES['postcode']['tmp_name'];
$filename = $_FILES['postcode']['name'];

$row = 1;
// the file extension
$fileinfo = pathinfo($filename, PATHINFO_EXTENSION);

// if statements to process the file differently depending on its type
if($fileinfo == "xlsx"){

if ( $xlsx = SimpleXLSX::parse($file) ) {
    // Produce array keys from the array values of 1st array element
	$header_values = $rows = [];
	foreach ( $xlsx->rows() as $k => $r ) {
        if ( $k === 0 ) {
            $header_values = $r;
			continue;
        }
        array_map("trim", $header_values);
        array_map("strtolower", $header_values);
        
        if($header_values[$k] = "postcode"){
            
                $filtered = array_values(array_filter($r));
                $value = array_shift($filtered);
                
            array_push($results, $value);
        } else if (preg_match("/([Gg][Ii][Rr] 0[Aa]{2})|((([A-Za-z][0-9]{1,2})|(([A-Za-z][A-Ha-hJ-Yj-y][0-9]{1,2})|(([A-Za-z][0-9][A-Za-z])|([A-Za-z][A-Ha-hJ-Yj-y][0-9][A-Za-z]?))))\s?[0-9][A-Za-z]{2})/", $header_values[$k])){
            $filtered = array_values(array_filter($r));
                $value = array_shift($filtered);
                
            array_push($results, $value);
        }
        
	}
}
} else if ($fileinfo == "xls"){
    $allowed = array("Post code", "postcode", "POSTCODE", "Post Code", "PostCode", "Postcode");

    if ( $xls = SimpleXLS::parse($file) ) {

    // Produce array keys from the array values of 1st array element
    $header_values = $rows = [];
	foreach ( $xls->rows() as $k => $r ) {
        if ( $k === 0 ) {
            $header_values = $r;
			continue;
        }
        // get the individual header titles and compare to postcodes to see if theres a match
        array_map("trim", $header_values);
        array_map("strtolower", $header_values);
        
        if($header_values[$k] = "postcode"){
            
                $filtered = array_values(array_filter($r));
                $value = array_shift($filtered);
                
            array_push($results, $value);
        } else if (preg_match("/([Gg][Ii][Rr] 0[Aa]{2})|((([A-Za-z][0-9]{1,2})|(([A-Za-z][A-Ha-hJ-Yj-y][0-9]{1,2})|(([A-Za-z][0-9][A-Za-z])|([A-Za-z][A-Ha-hJ-Yj-y][0-9][A-Za-z]?))))\s?[0-9][A-Za-z]{2})/", $header_values[$k])){
            $filtered = array_values(array_filter($r));
                $value = array_shift($filtered);
                
            array_push($results, $value);
        }
    }
    // var_dump($results);
    
}

// csv processing, fairly straight forward
} else if ($fileinfo == "csv"){
    if (($handle = fopen($file, "r")) !== FALSE) {
        // loop over the file handle, seperating results where there is a comma
        while (($data = fgetcsv($handle, ",")) !== FALSE) {
            $num = count($data);
            
            $row++;
            for ($c=0; $c < $num; $c++) {
                $results[] = $data[$c];
                array_filter($data);           
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
    echo "Please upload files in csv, txt, xls or xlsx format";
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
    // print_r($res);
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
    header("Location: ../../../maps.html");
    echo json_encode($posts_arr);
} else {
    echo json_encode(array("message" => "no posts found"));
}

// save to a temporary file to be read by the maps.html page
$fp = fopen("results.json", "w");
fwrite($fp, json_encode($posts_arr));
fclose($fp);
// redirect to maps

