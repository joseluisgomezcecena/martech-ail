<?php
require_once("../../settings/db.php");

global $connection;

$id = $_POST['file-id'];


$query = "UPDATE action_files SET file_active = 0 WHERE file_id = $id";
$run = mysqli_query($connection, $query);
if($run)
{
    echo "success";
}