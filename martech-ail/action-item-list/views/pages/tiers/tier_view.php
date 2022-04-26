<?php

 $get_tier = "SELECT * FROM tiers WHERE tier_id = {$_GET['tier_id']}";
 $run_get = mysqli_query($connection, $get_tier);
 $row_data = mysqli_fetch_array($run_get);


 
//check if user can see this
if($_SESSION['quatroapp_user_level'] == 0)
{
   $action_numer = 0;

    $query = "SELECT * FROM tier_actions 
    LEFT JOIN tiers ON tier_actions.action_tier_id = tiers.tier_id 
    LEFT JOIN tier_area ON tier_area.tier_id = tiers.tier_id 
    LEFT JOIN departments ON tier_actions.action_department = departments.department_id 
    LEFT JOIN tier_action_responsible ON tier_action_responsible.a_action_id = tier_actions.action_id 
    WHERE  
    tier_action_responsible.a_responsible_user = {$_SESSION['quatroapp_user_id']} AND tiers.tier_id = {$_GET['tier_id']}  
    ORDER BY tier_actions.action_promise_date";
    
    $run_check = mysqli_query($connection, $query);

    if(mysqli_num_rows($run_check) == 0)
    {
        die("<br>You dont have permission to access this tier, or there are no actions for this tier add actions first <a href='index.php'>Go Back</a>");
    }
     $row = mysqli_fetch_array($run_check);

}

//get area
if(isset($_GET['area_id']) && $_GET['area_id'] != "")
{
    $query_area = "SELECT * FROM tier_area WHERE area_id = {$_GET['area_id']}";
    $run_area = mysqli_query($connection, $query_area);
    $row_area = mysqli_fetch_array($run_area);
    $tier_area_name = ", " . $row_area['area_name'];
    $area_id = "&area_id=" . $_GET['area_id'];
}
else
{
    $tier_area_name = "";
    $area_id = "";
}


?>
<h1 class="h3 mb-4 text-gray-800">Tier: <b><?php echo $row_data['tier_name'] ?><?php echo $tier_area_name; ?></b></h1>

<div style="margin-bottom:15px;">
    
    <?php if($_SESSION['quatroapp_user_level'] > 1): ?>
        <a  href="index.php?page=tier_action_add&tier_id=<?php echo $_GET['tier_id']; ?><?php if(isset($_GET['area_id']) && $_GET['area_id'] != ""){echo "&area_id={$_GET['area_id']}";}else{echo "";} ?>" id="add-newuser" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" ><i class="fas fa-plus fa-sm text-white-50"></i>&nbsp;&nbsp;Add Action</a>
    
    
    <?php else: ?>
        <a  href="trigger.php" id="add-newuser" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" ><i class="fas fa-plus fa-sm text-white-50"></i>&nbsp;&nbsp;Add Action</a>

    <?php endif; ?>
    
    <a  href="index.php?page=report_tier&tier_id=<?php echo $_GET['tier_id']; ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>&nbsp;&nbsp;Report All</a>
    <a  href="index.php?page=report_tier_active&tier_id=<?php echo $_GET['tier_id']; ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>&nbsp;&nbsp;Report Active</a>
</div>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.php?page=tier_list">Back To Tier List</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo $row_data['tier_name'] ?></li>
  </ol>
</nav>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Actions Overview</h6>
    </div>
        <div class="card-body">
            <div style="margin-top:-20px;" class="table-responsive">
            <table  style="font-size: 14px; vertical-align:middle; " class="table  order-column " id="dataTableExcel" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>ID</th>
                    <th style="width: 20%;">Issue</th>
                    <th style="width: 20%;">Action</th>
                    <th style="width: 5%;">Department</th>
                    <th style="width: 10%;">Team</th>
                    <th style="width: 10%;">Promise Date</th>
                    <th style="width: 5%;">Status</th>
                    <th style="width: 5%;">Complete</th>
                    <th style="width: 10%;">Actions</th>
                    <th style="width: 10%;">Updates</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    
                    if(isset($_GET['area_id']) && $_GET['area_id'] != "")
                    {
                        $string = " AND tier_actions.action_tier_area = {$_GET['area_id']} ";
                    }
                    else
                    {
                        $string = "";
                    }
                    
                    if($_SESSION['quatroapp_user_level'] == 0)
                    {

                        $query = "SELECT * FROM tier_actions 
                        LEFT JOIN tiers ON tier_actions.action_tier_id = tiers.tier_id 
                        LEFT JOIN tier_area ON tier_area.tier_id = tiers.tier_id 
                        LEFT JOIN departments ON tier_actions.action_department = departments.department_id 
                        LEFT JOIN tier_action_responsible ON tier_action_responsible.a_action_id = tier_actions.action_id 
                        WHERE  
                        tier_action_responsible.a_responsible_user = {$_SESSION['quatroapp_user_id']} AND tiers.tier_id = {$_GET['tier_id']}  
                        $string  AND tier_actions.action_complete = 0
                        GROUP BY tier_actions.action_id 
                        ORDER BY tier_actions.action_promise_date";
                    }
                    else
                    {
                        $query = "SELECT * FROM tier_actions 
                        LEFT JOIN tiers ON tier_actions.action_tier_id = tiers.tier_id 
                        LEFT JOIN tier_area ON tier_area.tier_id = tiers.tier_id 
                        LEFT JOIN departments ON tier_actions.action_department = departments.department_id 
                        LEFT JOIN tier_action_responsible ON tier_action_responsible.a_action_id = tier_actions.action_id 
                        WHERE  
                        tiers.tier_id = {$_GET['tier_id']}  
                        $string  AND tier_actions.action_complete = 0
                        GROUP BY tier_actions.action_id 
                        ORDER BY tier_actions.action_promise_date";
                    }
                    
                    
                    $result = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_array($result)):
                    ?>
                        <tr>
                            <td><?php echo $row['action_id'];  ?></td>
                            <td><?php echo $row['action_name'];  ?></td>
                            <td style="text-align: justify;"><?php echo $row['action_description'];  ?></td>
                            <td><?php echo $row['department_name'];  ?></td>
                            <td>
                                <?php   
                                $query2 = "SELECT * FROM tier_action_responsible 
                                LEFT JOIN users ON tier_action_responsible.a_responsible_user = users.user_id
                                WHERE a_action_id = {$row['action_id']}";
                                $result2 = mysqli_query($connection, $query2);
                                while($row2 = mysqli_fetch_array($result2)):
                                if($row2['a_responsible_main'] == 1)
                                {
                                    $icon = "<i class='fas fa-exclamation-circle text-danger'></i>";
                                }
                                else
                                {
                                    $icon = "";
                                }
                                ?>
                                    <a href="index.php?page=user_info&user_id=<?php echo $row2['user_id'] ?>"><?php echo $row2['user_name'] ?>&nbsp;&nbsp;<?php echo $icon ?></a><br>
                                <?php endwhile; ?>
                            </td>
                            <td><?php echo date('m-d-Y', strtotime($row['action_promise_date']));  ?></td>
                            <td>
                                <?php
                                    if($row['action_status'] == 0 && $row['action_promise_date'] <= date("Y-m-d"))
                                    {
                                        echo "Late";
                                    }   
                                    elseif($row['action_status'] == 0 && $row['action_promise_date'] > date("Y-m-d"))
                                    {
                                        echo "On time";
                                    }
                                ?>
                            </td>
                            <td>
                            <?php 

                            $percentage = $row['action_percent'];

                            if($percentage <= 25)
                            {
                                $bg = "bg-danger";
                            }
                            elseif($percentage > 25 && $percentage <= 75)
                            {
                                $bg = "bg-warning";
                            }
                            elseif($percentage > 75 && $percentage <= 99)
                            {
                                $bg = "bg-success";
                            }
                            else
                            {
                                $bg = "bg-primary";
                            }

                            ?>
                                <div data-toggle='tooltip' data-placement='left' title='<?php echo  $percentage . "% Complete"?>' class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated <?php echo $bg; ?>" role="progressbar" aria-valuenow="<?php echo $row['action_complete'] ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $row['action_percent'] ?>%"></div>
                                </div>
                            </td>
                            <td>
                                <a href='index.php?page=tier_view_update&action_id=<?php echo $row['action_id']?>'  class=''  data-cat-name='{$row['user_name']}' data-cat-id='{$row['user_id']}'><i data-toggle='tooltip' data-placement='left' title='View action details' style='font-size: 20px; color:#b5b5b5' class='fas fa-eye options'></i></a>
                                &nbsp;&nbsp;
                                <a href='index.php?page=tier_action_edit&action_id=<?php echo $row['action_id']?>&tier_id=<?php echo $_GET['tier_id'] ?><?php echo $area_id; ?>'  class=''  data-cat-name='{$row['user_name']}' data-cat-id='{$row['user_id']}'><i data-toggle='tooltip' data-placement='left' title='Edit action' style='font-size: 20px; color:#b5b5b5' class='fa fa-edit options'></i></a>
                            </td>
                            <td>
                                <a href='index.php?page=tier_action_add_file&action_id=<?php echo $row['action_id']?>&tier_id=<?php echo $_GET['tier_id'] ?>'  class=''  data-cat-name='{$row['user_name']}' data-cat-id='{$row['user_id']}'><i data-toggle='tooltip' data-placement='left' title='Add a file docx, xlsx, csv, pdf or image' style='font-size: 20px; color:#b5b5b5' class='fas fa-file-upload options'></i></a>
                                &nbsp;&nbsp
                                <a href='index.php?page=tier_action_progress&action_id=<?php echo $row['action_id']?>&tier_id=<?php echo $_GET['tier_id'] ?>'  class=''  data-cat-name='{$row['user_name']}' data-cat-id='{$row['user_id']}'><i data-toggle='tooltip' data-placement='left' title='Update progress' style='font-size: 20px; color:#b5b5b5' class='fas fa-tasks options'></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>                
            </table>
        </div>
    </div>
</div>




<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4 ">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Project Completion Percentage</h6>
            </div>
            <div class="card-body">
                    
                    <div id="chart-container">
                        <canvas id="myChartTier"></canvas>
                    </div>
            </div>
        </div>
    </div>


    <div class="col-lg-6">
        <div class="card shadow mb-4 ">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Completed On Time vs Late</h6>
            </div>
            <div class="card-body">
                    
            <table  style="font-size: 14px; vertical-align:middle; " class="table  order-column " id="example1" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Action</th>
                    <th>Result</th>
                    <th>Leader</th>
                </tr>
                </thead>
                <tbody>
                    <?php 
                    $query = "SELECT * FROM tier_actions
                    LEFT JOIN tiers ON tier_actions.action_tier_id = tiers.tier_id 
                    LEFT JOIN departments ON tier_actions.action_department = departments.department_id  
                    WHERE tiers.tier_id = {$_GET['tier_id']} AND action_end_date != '0000-00-00' AND action_complete = 1 ORDER BY tier_actions.action_promise_date";

                    $result = mysqli_query($connection, $query);
                    
                    while($row = mysqli_fetch_array($result)):
                    
                    ?>
                    
                        <tr>
                            <td><?php echo $row['action_name']; ?></td>
                            <td>
                                <?php
                                    if($row['action_promise_date'] >= $row['action_end_date'])
                                    {
                                        echo "<b style='color:green'>On Time! </b><br>";
                                    }
                                    else
                                    {
                                        echo "<b style='color:red'>Late</b><br>";
                                        $dlate = round(strtotime($row['action_end_date']) - strtotime($row['action_promise_date']));
                                        echo $dlate / (60 * 60 * 24) . " Day(s)";

                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                $query2 = "SELECT * FROM tier_action_responsible 
                                LEFT JOIN users ON tier_action_responsible.a_responsible_user = users.user_id
                                WHERE a_action_id = {$row['action_id']} AND a_responsible_main = 1";
                                $result2 = mysqli_query($connection, $query2);
                                $row2 = mysqli_fetch_array($result2);
                                ?>
                                <img class='img-fluid user-img rounded-circle' src="<?php echo $row2['user_image'] ?>">&nbsp;&nbsp;<?php echo $row2['user_name'] ?>
                            </td>
                        </tr>
                    
                    <?php endwhile; ?>
                </tbody> 

            </div>
        </div>
    </div>
</div>    

            
