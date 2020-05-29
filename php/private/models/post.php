<?php

// include "/XAMPP1/htdocs/Trust%20impact/php/index.php";
class Post {

    
    private $conn;
    private $table = "posts";
    
    public $postcode;
    
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;
    
    // constructor for db
    
    public function __construct($db){
        $this->conn = $db;
        
    }
    var $postie = [];
    
    public function read($postie){
        foreach($postie as $i){
            $res = $i;
        }
        // create query
        $query = "SELECT * FROM trust WHERE trust.postcode IN ('" . $postie . "')";
        var_dump($res);

        // prepared statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;

    }
    
}
?>