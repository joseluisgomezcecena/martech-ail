<?php
/*
App Settings for project
*/

ob_start();

date_default_timezone_set("America/Tijuana");

if(isset($_GET['site']))
    $site = $_GET['site'];
else
    $site = "";



if(isset($_GET['page']))
    $page = $_GET['page'];
else
    $page = "";


//datatables con botones
if(
    $page == "main_table" || $page == "ail_report" || $page == "project_list" || $page == "project_list_lean" || 
    $page == "project_view" || $page == "view_update" || $page == "report" || $page == "tier_pending"
)
{
    $datatablesop = 2;
}
else
{
    $datatablesop = 1;
}  
    
//require_once("functions/users/users.php");
//require_once("libraries/importcsv.php");
//require_once("libraries/add_sop.php");
//require_once("libraries/remove_sop.php");
//require_once("libraries/importcsvpersonnel.php");


?>