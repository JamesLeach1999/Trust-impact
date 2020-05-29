<?php
//  require_once("../private/initialize.php");
// include_once("../php/private/models/post.php"); ?>


<?php
$test = "numberwang";
echo file_exists("/private/api/post/post.php");
// $query = $_POST['postcode'];


?>

<div id="content">

<form action="/Trust impact/php/private/api/post/read.php" method="post">
    <input type="text" name="postcode" multiple>
    <input type="submit" value="submit" name="submit">
</form>


</div>