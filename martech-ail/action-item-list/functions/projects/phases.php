<?php
require_once("../../settings/db.php");

global $connection;

$id = $_POST['phase-id'];
$value = $_POST['value'];

$query = "UPDATE project_phase SET phase_name = '$value' WHERE phase_id = $id";
$run = mysqli_query($connection, $query);
if($run)
{
    echo "success";
}