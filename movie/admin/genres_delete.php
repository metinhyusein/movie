<?php
require_once '../config/index.php';

$id = $_GET['id'];
 
 $sql = "DELETE FROM 
          `".TABLE_GENRES."`
        WHERE `id` = '".mysqli_real_escape_string($conn, $id)."' ";

$result = mysqli_query($conn, $sql);
 

header("Location:genres_list.php");

?>