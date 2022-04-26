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
if(mysqli_num_rows($result) > 0)
{


  while($row = mysqli_fetch_array($result))
  {
      echo 
      '
      <a  class="dropdown-item d-flex align-items-center" href="index.php?page=view_update&action_id='.$row['action_id'].'">
              <div class="mr-3">
                <div class="icon-circle bg-danger">
                  <i class="fas fa-exclamation text-white"></i>
                </div>
              </div>
              <div>
                <div class="small text-gray-500">Late action! '.date_format(date_create($row['action_promise_date']), "m-d-Y") .'</div>
                <span class="font-weight-bold">'.$row['action_name'].'</span>
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










$query2 = "SELECT * FROM tier_action_responsible  
LEFT JOIN tier_actions ON tier_action_responsible.a_action_id = tier_actions.action_id
WHERE 
tier_actions.action_complete = 0 AND tier_action_responsible.a_responsible_user = {$_SESSION['quatroapp_user_id']} 
AND tier_actions.action_promise_date <= '$today'
";

$result2 = mysqli_query($connection, $query2);
if(mysqli_num_rows($result2) > 0)
{


  while($row2 = mysqli_fetch_array($result2))
  {
      echo 
      '
      <a  class="dropdown-item d-flex align-items-center" href="index.php?page=tier_view_update&action_id='.$row2['action_id'].'">
              <div class="mr-3">
                <div class="icon-circle bg-danger">
                  <i class="fas fa-exclamation text-white"></i>
                </div>
              </div>
              <div>
                <div class="small text-gray-500">Late Tier action! '.date_format(date_create($row2['action_promise_date']), "m-d-Y") .'</div>
                <span class="font-weight-bold">'.$row2['action_name'].'</span>
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
                <span class="font-weight-bold">No Late Tier Actions</span>
              </div>
      </a>
      ';

}