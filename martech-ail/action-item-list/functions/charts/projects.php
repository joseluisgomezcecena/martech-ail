<?php
error_reporting(0);
header('Content-Type: application/json');

require_once("../../settings/db.php");
session_start();

global $connection;
$per = 0;

$query = "SELECT COUNT(*) as cuenta FROM actions 
WHERE action_project_id = {$_GET['project_id']}";

$result = mysqli_query($connection,$query);
$row  = mysqli_fetch_array($result); 

$query2 = "SELECT * FROM actions 
WHERE action_project_id = {$_GET['project_id']}";

$result2 = mysqli_query($connection,$query2);

while($row2 = mysqli_fetch_array($result2))
{
    $per += $row2['action_percent'];
}


$data = array();

$cuenta = $row['cuenta']*100;
$per = $per*100;

$completo = $per/$cuenta;
$faltante = 100 - $completo;

$data[0] = round($faltante);
$data[1] = round($completo);


mysqli_close($connection);

echo json_encode($data);
?>