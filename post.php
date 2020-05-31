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

    // parameter to store the postcodes in an array
    var $postie;
    
    public function read($postie){
        
        // sanitize, remove whitespace and convert to all caps
        $postie = strtoupper(htmlspecialchars(str_replace(" ","",$postie)));
        
        // create query
        $query = "SELECT * FROM trust WHERE trust.postcode IN (" . $postie . ")";

        // prepared statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;

    }
    
}
?>