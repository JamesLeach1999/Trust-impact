<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use SimpleXLSX;
use SimpleXLS;

use App\Pages;
use DB;


class PagesController extends Controller
{
    public function index(){
        // $title = "numberwang";
        $posts = DB::select("SELECT * FROM postcodes");
        return view("pages.index")->with("posts", $posts);
    }

    // public function test(){
    //     $title = DB::table('postcodes')->get();

    //     return view('pages.test')->with("title", $title);
    // }
    Public function create(){

    // $posts = DB::select("SELECT * FROM upload");
        return view("pages.create");

    }

    
    public function parseXLSX($file_path) {
        $results = [];
        
        if ( $xlsx = SimpleXLSX::parse($file_path) ) {
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
                // gets postcodes based on if they match the regex
        } else if (preg_match("/([Gg][Ii][Rr] 0[Aa]{2})|((([A-Za-z][0-9]{1,2})|(([A-Za-z][A-Ha-hJ-Yj-y][0-9]{1,2})|(([A-Za-z][0-9][A-Za-z])|([A-Za-z][A-Ha-hJ-Yj-y][0-9][A-Za-z]?))))\s?[0-9][A-Za-z]{2})/", $header_values[$k])){
            $filtered = array_values(array_filter($r));
                $value = array_shift($filtered);
                
            array_push($results, $value);
        }
        
    }
    return $results;
}

    }

    public function parseXLS($file_path){
        $allowed = array("Post code", "postcode", "POSTCODE", "Post Code", "PostCode", "Postcode");
        $results = [];

    if ( $xls = SimpleXLS::parse($file_path) ) {

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
        // only gets results from the row called postcode
        if($header_values[$k] = "postcode"){
            
                $filtered = array_values(array_filter($r));
                $value = array_shift($filtered);
                
            array_push($results, $value);
            // gets postcodes based on if they match the regex
        } else if (preg_match("/([Gg][Ii][Rr] 0[Aa]{2})|((([A-Za-z][0-9]{1,2})|(([A-Za-z][A-Ha-hJ-Yj-y][0-9]{1,2})|(([A-Za-z][0-9][A-Za-z])|([A-Za-z][A-Ha-hJ-Yj-y][0-9][A-Za-z]?))))\s?[0-9][A-Za-z]{2})/", $header_values[$k])){
            $filtered = array_values(array_filter($r));
                $value = array_shift($filtered);
                
            array_push($results, $value);
        }
    }
    }
    return $results;
}

    public function parseCSV($file_path){
        if (($handle = fopen($file_path, "r")) !== FALSE) {
        // loop over the file handle, seperating results where there is a comma
        while (($data = fgetcsv($handle, ",")) !== FALSE) {
            $num = count($data);
            // gets each line of csv file 
            // TODO remove blank cells or elements from csv if in workbook
            for ($c=0; $c < $num; $c++) {
                $fil = array_values(array_filter($data[$c]));
                $value = array_shift($fil);
                $results[] = $data[$value];
                // array_walk($results, $data[$c]);

                array_filter($data);           
                $keys = array_keys($data);
        }
    }
    fclose($handle);
}
return $results;
    }

    public function parseFile(Request $request){
        // requesting file info to be processed by the functions
        $file_path = $request->cover_image->path();
        $file_extension = $request->cover_image->extension();
        
        $results = [];
        // given the simplicity, it seemed excessive to use a function to process txt files
        if($file_extension == "txt") {
            $lines = file($file_path, FILE_IGNORE_NEW_LINES);
            foreach($lines as $l){
                array_push($results, $l);
            }
        } else if ($file_extension == "csv"){
            $results = $this->parseCSV($file_path);
        } else if($file_extension == "xlsx"){
            $results = $this->parseXLSX($file_path);
        } else if ($file_extension == "xls"){
            $results = $this->parseXLS($file_path);
        } else {
            // returns back to upload page with error messaage
            return redirect("/create")->with("error", "Please upload txt, csv, xlsx or xls file");
        }
        // turns into string
        $trimmed = implode("','", $results);
        var_dump($trimmed);
        // the query and storing of results in array
        $post = DB::select("SELECT * FROM postcodes WHERE postcodes IN ('" . $trimmed . "')");
        $r = array();
        foreach($post as $key => $p){
            array_push($r, $p);
        }    
        // returns the second page with the results
        return view("pages.store")->with("res", $r);
        exit();
        

}

    }
