<?php
$stmt = $connection->prepare("SELECT * FROM projects WHERE project_id = ?");
$stmt->bind_param("i", $_GET['project_id']);
$stmt->execute();

$result = $stmt->get_result();
if($result->num_rows === 0) 
    exit('No rows');

$row = $result->fetch_array();
$stmt->close();



//check if user can see this
if($_SESSION['quatroapp_user_level'] == 0)
{
    $action_numer = 0;

    $query = "SELECT * FROM actions 
    LEFT JOIN projects ON actions.action_project_id = projects.project_id 
    LEFT JOIN project_phase ON actions.action_phase = project_phase.phase_id 
    LEFT JOIN departments ON actions.action_department = departments.department_id 
    LEFT JOIN action_responsible ON action_responsible.a_action_id = actions.action_id 
    WHERE 
    (projects.project_id = {$row['project_id']} AND action_responsible.a_responsible_user = {$_SESSION['quatroapp_user_id']}) 
    OR (projects.project_id = {$row['project_id']} AND projects.project_owner = {$_SESSION['quatroapp_user_id']}) 
    OR (projects.project_id = {$row['project_id']} AND projects.project_support = {$_SESSION['quatroapp_user_id']}) 
    ORDER BY actions.action_promise_date";
    
    $run_check = mysqli_query($connection, $query);
    if(mysqli_num_rows($run_check) > 0)
    {
        $action_numer = 1;

    }

    $query_p = "SELECT * FROM projects WHERE project_id = {$row['project_id']} AND (project_owner = {$_SESSION['quatroapp_user_id']} OR project_support = {$_SESSION['quatroapp_user_id']})";
    $run_query_p = mysqli_query($connection, $query_p);
    if(mysqli_num_rows($run_query_p) > 0)
    {
        $action_numer = 1;
    }


    if($action_numer == 0)
    {

        //save in db people trying to access/hack data
        $query_perm = "INSERT INTO notpermitted (perm_user_id, p_id) VALUES ('{$_SESSION['quatroapp_user_id']}', '{$row['project_id']}')";
        $run_perm = mysqli_query($connection, $query_perm);
        if(!$run_perm)
        {
            echo $query_perm;
        }
        die("<br>You dont have permission to access this project, or there are no actions for this project add actions first <a href='index.php'>Go Back</a>");


    }

}



?>
<h1 class="h3 mb-4 text-gray-800">Project(s): <b><?php echo $row['project_name'] ?></b></h1>

<div style="margin-bottom:15px;">
    <a  href="index.php?page=action_add&project_id=<?php echo $_GET['project_id']; ?>" id="add-newuser" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" ><i class="fas fa-plus fa-sm text-white-50"></i>&nbsp;&nbsp;Add Action</a>
    <a  href="index.php?page=report&project_id=<?php echo $_GET['project_id']; ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>&nbsp;&nbsp;Generate Report</a>
</div>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php if($row['lean'] == 0){echo "index.php?page=project_list";}elseif($row['lean'] == 1){echo "index.php?page=project_list_lean";} ?>">Back To Project List</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo $row['project_name'] ?></li>
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
                    <th>Phase</th>
                    <th style="width: 100px;">Action</th>
                    <th>Description</th>
                    <th>Department</th>
                    <th>Team</th>
                    <th style="width: 100px;">Promise Date</th>
                    <th>Status</th>
                    <th style="width: 100px;">Complete</th>
                    <th>Actions</th>
                    <th style="width: 100px;">Updates</th>
                </tr>
                </thead>
                <tbody>
                    <?php 
                    if($_SESSION['quatroapp_user_level'] >= 1)
                    {
                        $query = "SELECT * FROM actions
                        LEFT JOIN projects ON actions.action_project_id = projects.project_id
                        LEFT JOIN project_phase ON actions.action_phase = project_phase.phase_id 
                        LEFT JOIN departments ON actions.action_department = departments.department_id 
                        WHERE projects.project_id = {$_GET['project_id']} ORDER BY actions.action_promise_date";
                    }
                    else
                    {
                        $query = "SELECT * FROM actions
                        LEFT JOIN projects ON actions.action_project_id = projects.project_id
                        LEFT JOIN project_phase ON actions.action_phase = project_phase.phase_id 
                        LEFT JOIN departments ON actions.action_department = departments.department_id 
                        WHERE projects.project_id = {$_GET['project_id']} ORDER BY actions.action_promise_date";

                        /*
                        $query = "SELECT * FROM actions 
                        LEFT JOIN projects ON actions.action_project_id = projects.project_id 
                        LEFT JOIN project_phase ON actions.action_phase = project_phase.phase_id 
                        LEFT JOIN departments ON actions.action_department = departments.department_id 
                        LEFT JOIN action_responsible ON action_responsible.a_action_id = actions.action_id 
                        WHERE projects.project_id = {$_GET['project_id']} 
                        AND action_responsible.a_responsible_user = {$_SESSION['quatroapp_user_id']} 
                        ORDER BY actions.action_promise_date";
                        */
                    }
                    
                    
                    
                    $result = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_array($result)):
                    ?>
                        <tr>
                            <td><?php echo $row['action_id'];  ?></td>
                            <td><?php echo $row['phase_name'];  ?></td>
                            <td><?php echo $row['action_name'];  ?></td>
                            <td style="text-align: justify;"><?php echo $row['action_description'];  ?></td>
                            <td><?php echo $row['department_name'];  ?></td>
                            <td>
                                <?php   
                                $query2 = "SELECT * FROM action_responsible 
                                LEFT JOIN users ON action_responsible.a_responsible_user = users.user_id
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
                                <a href='index.php?page=view_update&action_id=<?php echo $row['action_id']?>'  class=''  data-cat-name='{$row['user_name']}' data-cat-id='{$row['user_id']}'><i data-toggle='tooltip' data-placement='left' title='View action details' style='font-size: 20px; color:#b5b5b5' class='fas fa-eye options'></i></a>
                                <a href='index.php?page=action_edit&action_id=<?php echo $row['action_id']?>&project_id=<?php echo $_GET['project_id'] ?>'  class=''  data-cat-name='{$row['user_name']}' data-cat-id='{$row['user_id']}'><i data-toggle='tooltip' data-placement='left' title='Edit action' style='font-size: 20px; color:#b5b5b5' class='fa fa-edit options'></i></a>
                            </td>
                            <td>
                                <!--
                                <a href='index.php?page=action_add_update&action_id=<?php echo $row['action_id']?>&project_id=<?php echo $_GET['project_id'] ?>'  class=''  data-cat-name='{$row['user_name']}' data-cat-id='{$row['user_id']}'><i data-toggle='tooltip' data-placement='left' title='Add an update to this action' style='font-size: 20px; color:#b5b5b5' class='fas fa-plus-circle options'></i></a>
                                &nbsp;&nbsp;&nbsp;
                                -->
                                <a href='index.php?page=action_add_file&action_id=<?php echo $row['action_id']?>&project_id=<?php echo $_GET['project_id'] ?>'  class=''  data-cat-name='{$row['user_name']}' data-cat-id='{$row['user_id']}'><i data-toggle='tooltip' data-placement='left' title='Add a file docx, xlsx, csv, pdf or image' style='font-size: 20px; color:#b5b5b5' class='fas fa-file-upload options'></i></a>
                                &nbsp;&nbsp;&nbsp;
                                <a href='index.php?page=action_progress&action_id=<?php echo $row['action_id']?>&project_id=<?php echo $_GET['project_id'] ?>'  class=''  data-cat-name='{$row['user_name']}' data-cat-id='{$row['user_id']}'><i data-toggle='tooltip' data-placement='left' title='Update progress' style='font-size: 20px; color:#b5b5b5' class='fas fa-tasks options'></i></a>
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
                        <canvas id="myChart"></canvas>
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
                    $query = "SELECT * FROM actions
                    LEFT JOIN projects ON actions.action_project_id = projects.project_id
                    LEFT JOIN project_phase ON actions.action_phase = project_phase.phase_id 
                    LEFT JOIN departments ON actions.action_department = departments.department_id  
                    WHERE projects.project_id = {$_GET['project_id']} AND action_end_date != '0000-00-00' AND action_complete = 1 ORDER BY actions.action_promise_date";

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
                                $query2 = "SELECT * FROM action_responsible 
                                LEFT JOIN users ON action_responsible.a_responsible_user = users.user_id
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

            
