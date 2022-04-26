<?php
require_once("../../settings/db.php");
require_once("../../settings/settings.php");

session_start();

global $connection;


if($_SESSION['quatroapp_user_level'] >= 1)
{

    $today = date("Y-m-d");
    $query = "SELECT * FROM tier_triggers  
    LEFT JOIN tiers ON tiers.tier_id = tier_triggers.trigger_tier_id 
    LEFT JOIN tier_area ON tier_triggers.trigger_area_id = tier_area.area_id
    WHERE 
    tier_triggers.trigger_complete = 0";
    $result = mysqli_query($connection, $query);
    $num = mysqli_num_rows($result);
    echo $num;
}
else{
    echo '0';
}