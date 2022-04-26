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
    tier_triggers.trigger_complete = 0
    ";

    $result = mysqli_query($connection, $query);
    if(mysqli_num_rows($result) > 0)
    {


    while($row = mysqli_fetch_array($result))
    {
        echo 
        '
        <a  class="dropdown-item d-flex align-items-center" href="#">
                <div class="mr-3">
                    <div class="icon-circle bg-danger">
                    <i class="fas fa-exclamation text-white"></i>
                    </div>
                </div>
                <div>
                    <div class="small text-gray-500">'.$row['tier_name']." - ".date_format(date_create($row['trigger_date']), "m-d-Y") .'</div>
                    <span class="font-weight-bold">'.$row['trigger_issue'].'</span>
                </div>
        </a>
        ';


    }

    }
    else
    {
    echo 
        '
        <a  class="dropdown-item d-flex align-items-center" href="#">
                <div class="mr-3">
                    <div class="icon-circle bg-success">
                    <i class="fas fa-clipboard-check text-white"></i>
                    </div>
                </div>
                <div>
                    <div class="small text-gray-500">Nothing to show</div>
                    <span class="font-weight-bold">No Late Actions</span>
                </div>
        </a>
        ';

    }




}
else{
    echo "";
}




