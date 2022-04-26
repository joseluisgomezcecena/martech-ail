<?php
/*
$stmt = $connection->prepare(
    "SELECT * FROM projects 
    LEFT JOIN project_phase ON actions.action_phase = project_phase.phase_id 
    LEFT JOIN projects ON actions.action_project_id = projects.project_id 
    LEFT JOIN departments ON actions.action_department = departments.department_id
    WHERE action_id = ?"
);
*/
$stmt = $connection->prepare(
    "SELECT * FROM actions  
    LEFT JOIN projects ON actions.action_project_id = projects.project_id
    LEFT JOIN project_phase ON actions.action_phase = project_phase.phase_id 
    LEFT JOIN departments ON actions.action_department = departments.department_id 
    WHERE projects.project_id = ? ORDER BY actions.action_promise_date;"
);

$stmt->bind_param("i", $_GET['project_id']);
$stmt->execute();

$result = $stmt->get_result();
if($result->num_rows === 0) 
{
    //echo "Nothing to report, no actions were found. <a href='{$_SERVER['HTTP_REFERER']}'>Go Back.</a>";
    if(isset($_SERVER['HTTP_REFERER']))
    {
        exit("Nothing to report, no actions were found. <a href='{$_SERVER['HTTP_REFERER']}'>Go Back.</a>");
    }
    else
    {
        exit("Nothing to report, no actions were found. <a href='index.php'>Go Back.</a>");
    }
    
}   

$row_data = $result->fetch_array();
$stmt->close();
?>
<h1 class="h3 mb-4 text-gray-800">Project <b><?php echo $row_data['project_name'] ?></b> Report</h1>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.php?page=report_active_list">Reports</a></li>
    <li class="breadcrumb-item active" aria-current="page">Report <?php echo $row_data['project_name'] ?></li>
  </ol>
</nav>


<div class="row">



<div class="col-lg-12">
    <div class="card shadow mb-4 ">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Action info</h6>
        </div>
            <div class="card-body">

            <!--table-->

            <div style="margin-top:-20px;" class="table-responsive">
            <table  style="font-size: 14px; vertical-align:middle; " class="table  order-column " id="dataTableExcel" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Phase</th>
                    <th>Action</th>
                    <th>Description</th>
                    <th>Department</th>
                    <th>Team</th>
                    <th>Register Date</th>
                    <th>Promise Date</th>
                    <th>Status</th>
                    <th>Complete</th>
                    <th>Updates</th>
                </tr>
                </thead>
                <tbody>
                    <?php 

                    
                    $query = "SELECT * FROM actions
                    LEFT JOIN projects ON actions.action_project_id = projects.project_id
                    LEFT JOIN project_phase ON actions.action_phase = project_phase.phase_id 
                    LEFT JOIN departments ON actions.action_department = departments.department_id 
                    WHERE projects.project_id = {$_GET['project_id']} ORDER BY actions.action_promise_date";
                
                    $result = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_array($result)):
                    ?>
                        <tr>
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
                                ?>
                                    <?php echo $row2['user_name'] ?>
                                <?php endwhile; ?>
                            </td>
                            <td><?php echo date('m-d-Y', strtotime($row['action_start_date']));  ?></td>
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
                                echo $percentage = $row['action_percent'];
                            ?>
                            </td>
                           
                            <td>
                            <?php 
                            
                            $query3 = "SELECT * FROM action_updates
                            LEFT JOIN actions ON action_updates.a_update_action_id = actions.action_id
                            LEFT JOIN users ON action_updates.a_update_user = users.user_id 
                            WHERE action_updates.a_update_action_id = {$row['action_id']} ORDER BY a_update_id DESC";
                            $result3 = mysqli_query($connection, $query3);
                            while($row3 = mysqli_fetch_array($result3)):
                            ?>
                    
                            <?php echo $row3['a_update_descr']?><br>
                            <?php echo $row3['user_name']; ?><br>
                            <?php echo $row3['a_update_date']; ?><br>
                            
                            
                            <?php endwhile; ?>

                                                                                       
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>                
            </table>
        </div>

            <!--table-->

            </div>
    </div>
</div>    









<div class="col-lg-8">
<div class="card shadow mb-4 ">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Project Files</h6>
    </div>
        <div class="card-body">


        <div style="margin-top:-20px;" class="table-responsive">
            <table  style="font-size: 14px; vertical-align:middle; " class="table  order-column " id="example1" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>File ID</th>
                    <th>File Name</th>
                    <th>Download</th>
                </tr>
                </thead>
                <tbody>
                    <?php 
                    $query = "SELECT * FROM action_files 
                    LEFT JOIN actions ON action_files.file_action_id = actions.action_id 
                    LEFT JOIN projects ON actions.action_project_id = projects.project_id 
                    WHERE project_id = {$_GET['project_id']}";

                    $result = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_array($result)):
                    ?>
                        <tr>
                            <td><?php echo $row['file_id'];  ?></td>
                            <td><?php echo $row['file_name'];  ?></td>
                            <td><a href="<?php echo $row['file_url'];?>" download="<?php echo $row['file_url']; ?>" ><i style="font-size: 24px;"  class="fa fa-download"></i></a></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>                
            </table>
        </div>




        </div>
    </div>
</div>    


<!--
<div class="col-lg-4">
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Files</h6>
    </div>
        <div class="card-body">
            <div style="margin-top:-20px;" class="table-responsive">
            <table  style="font-size: 14px; vertical-align:middle; " class="table  order-column " id="example1" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>File ID</th>
                    <th>File Name</th>
                    <th>Download</th>
                </tr>
                </thead>
                <tbody>
                    <?php 
                    $query = "SELECT * FROM action_files WHERE file_action_id = {$_GET['action_id']}";
                    $result = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_array($result)):
                    ?>
                        <tr>
                            <td><?php echo $row['file_id'];  ?></td>
                            <td><?php echo $row['file_name'];  ?></td>
                            <td><a href="<?php echo $row['file_url'];  ?>"><i style="font-size: 16px;" data-toggle='tooltip' data-placement='top' title="<?php echo str_replace('uploads/actions/','',$row['file_url']); ?>" class="fa fa-download"></i></a></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>                
            </table>
        </div>
    </div>
</div>
</div>

</div>











<div class="row">
<div class="col-lg-6">
<div class="card shadow mb-4 ">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Updates By User</h6>
    </div>
        <div class="card-body">
            
            <div id="chart-container">
                <canvas id="graphCanvas"></canvas>
            </div>

        
    </div>
</div>
</div>    


<div class="col-lg-6">
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Updates By User</h6>
    </div>
        <div class="card-body">
            <div style="margin-top:-20px;" class="table-responsive">
            <table  style="font-size: 14px; vertical-align:middle; " class="table  order-column " id="example1" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>User</th>
                    <th>Updates</th>
                </tr>
                </thead>
                <tbody>
                    <?php 
                    $query = "SELECT COUNT(*) as cuenta, a_update_user, user_name, user_image FROM action_updates 
                    LEFT JOIN users ON action_updates.a_update_user = users.user_id WHERE a_update_action_id = {$_GET['action_id']} GROUP by users.user_name
                    ";
                    $result = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_array($result)):
                    ?>
                        <tr>
                            <td><img class='img-fluid user-img rounded-circle' src="<?php echo $row['user_image'] ?>">&nbsp;&nbsp;<?php echo $row['user_name'] ?></td>
                            <td><?php echo $row['cuenta'];  ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>                
            </table>
        </div>
    </div>
</div>
</div>

</div>
-->