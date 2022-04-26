<?php
require_once("../../settings/db.php");
require_once("../../settings/settings.php");

session_start();

global $connection;

$today = date("Y-m-d");

$query = "SELECT * FROM action_responsible  
LEFT JOIN actions ON action_responsible.a_action_id = actions.action_id
WHERE 
actions.action_complete = 0 AND action_responsible.a_responsible_user = {$_SESSION['quatroapp_user_id']} 
AND actions.action_promise_date <= '$today'
";
$result = mysqli_query($connection, $query);
$num = mysqli_num_rows($result);






$query2 = "SELECT * FROM tier_action_responsible  
LEFT JOIN tier_actions ON tier_action_responsible.a_action_id = tier_actions.action_id
WHERE 
tier_actions.action_complete = 0 AND tier_action_responsible.a_responsible_user = {$_SESSION['quatroapp_user_id']} 
AND tier_actions.action_promise_date <= '$today'
";
$result2 = mysqli_query($connection, $query2);
$num2 = mysqli_num_rows($result2);


echo $num + $num2;