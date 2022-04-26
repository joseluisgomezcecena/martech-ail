<?php
require_once("../../settings/db.php");

global $connection;

$id = $_POST['phase-id'];


$query = "UPDATE project_phase SET phase_active = 0 WHERE phase_id = $id";
$run = mysqli_query($connection, $query);
if($run)
{
    echo "success";
}