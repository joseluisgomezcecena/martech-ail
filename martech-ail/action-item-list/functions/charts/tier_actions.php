<?php
error_reporting(0);
header('Content-Type: application/json');

require_once("../../settings/db.php");
session_start();

global $connection;



//$query = "SELECT COUNT(*) as cuenta, a_update_user, user_name FROM action_updates LEFT JOIN users ON action_updates.a_update_user = users.user_id GROUP by users.user_name";
$query = "SELECT COUNT(*) as cuenta, a_update_user, user_name FROM tier_action_updates 
LEFT JOIN users ON tier_action_updates.a_update_user = users.user_id WHERE a_update_action_id = {$_GET['action_id']} GROUP by users.user_name
";
$result = mysqli_query($connection,$query);

$data = array();
foreach ($result as $row) {
	$data[] = $row;
}


mysqli_close($connection);

echo json_encode($data);
?>