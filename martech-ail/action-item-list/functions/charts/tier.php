<?php
error_reporting(0);
header('Content-Type: application/json');

require_once("../../settings/db.php");
session_start();

global $connection;
$per = 0;

if(isset($_GET['area_id']) && $_GET['area_id'] != "" &&  is_numeric($_GET['area_id']))
{
    $query = "SELECT COUNT(*) as cuenta FROM tier_actions 
    WHERE action_tier_id = {$_GET['tier_id']} AND action_tier_area = {$_GET['area_id']}";
    
}
else
{
    $query = "SELECT COUNT(*) as cuenta FROM tier_actions 
    WHERE action_tier_id = {$_GET['tier_id']}";
    
}
$result = mysqli_query($connection,$query);
$row  = mysqli_fetch_array($result); 


if(isset($_GET['area_id']) && $_GET['area_id'] != "" &&  is_numeric($_GET['area_id']))
{
    $query2 = "SELECT * FROM tier_actions 
    WHERE action_tier_id = {$_GET['tier_id']} AND action_tier_area = {$_GET['area_id']}";
}
else
{
    $query2 = "SELECT * FROM tier_actions 
    WHERE action_tier_id = {$_GET['tier_id']} ";
}
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