<?php
require_once("../../settings/db.php");
session_start();

global $connection;
$meeting_id = $_GET['meeting_id'];

$query_1 = "SELECT COUNT(*) FROM ail_action WHERE action_complete = 1 AND ail_meeting_id = $meeting_id";
$result_1 = mysqli_query($connection, $query_1);

$row_1 = mysqli_fetch_array($result_1);

$query_2 = "SELECT COUNT(*) FROM ail_action WHERE action_complete = 0 AND ail_meeting_id = $meeting_id";
$result_2 = mysqli_query($connection, $query_2);

$row_2 = mysqli_fetch_array($result_2);


$data = array();

$data[0] = $row_2[0];
$data[1] = $row_1[0];

echo json_encode($data);
?>
