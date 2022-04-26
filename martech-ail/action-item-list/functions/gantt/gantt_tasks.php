<?php
require_once("../../settings/db.php");
require_once("../../settings/settings.php");

session_start();

global $connection;

$today = date("Y-m-d");

/*
$stmt = $db->prepare('SELECT * FROM task');
$stmt->execute();
$items = $stmt->fetchAll();    
*/

$query = "SELECT * FROM action_responsible 
LEFT JOIN actions ON action_responsible.a_action_id = actions.action_id
LEFT JOIN projects ON actions.action_project_id = projects.project_id 
WHERE a_responsible_user = {$_SESSION['quatroapp_user_id']} AND action_complete = 0 GROUP BY action_responsible.a_action_id";

$run = mysqli_query($connection, $query);
class Task {}
$result = array();

while($items = mysqli_fetch_assoc($run))
{
    $r = new Task();

    if($items['action_promise_date'] <= $today)
    {
        $msj1 = "Late!";
    }
    else
    {
        $msj1 = "";
    }

    $result[] = array( 
        "id"=>$items['action_id'],
        "text"=>"$msj1 ".$items['action_name'],
        "start"=>$items['action_start_date'],
        "end"=>$items['action_promise_date'],
        "complete"=>$items['action_percent']
    );
}





$query = "SELECT * FROM tier_action_responsible 
LEFT JOIN tier_actions ON tier_action_responsible.a_action_id = tier_actions.action_id
LEFT JOIN tiers ON tier_actions.action_tier_id = tiers.tier_id 
WHERE a_responsible_user = {$_SESSION['quatroapp_user_id']} AND action_complete = 0 GROUP BY tier_action_responsible.a_action_id";

$run = mysqli_query($connection, $query);
//class Task {}
//$result = array();

while($items = mysqli_fetch_assoc($run))
{
    //$r = new Task();

    if($items['action_promise_date'] <= $today)
    {
        $msj1 = "Late";
    }
    else
    {
        $msj1 = "";
    }

    $result[] = array( 
        "id"=>$items['action_id'],
        "text"=>"$msj1 Tier : ".$items['action_name'],
        "start"=>$items['action_start_date'],
        "end"=>$items['action_promise_date'],
        "complete"=>$items['action_percent']
    );
}




//echo($items);

/*

class Task {}

$result = array();

foreach($items as $item) {
  $r = new Task();
  
  
  // rows
  $r->id = $item[1];
  $r->text = $item[9];
  $r->start = $item[12];
  $r->end = $item[13];

  
  
  $result[] = $r;
}
/*
echo " R : <pre>";
var_dump($result);
echo "</pre>";
*/
header('Content-Type: application/json');
echo json_encode($result);