<h1 class="h3 mb-4 text-gray-800">Lean Tracker (Lean Projects)</h1>

<div style="margin-bottom:15px;">
    <a  href="index.php?page=project_add" id="add-newuser" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" ><i class="fas fa-plus fa-sm text-white-50"></i>&nbsp;&nbsp;Add Project</a>
    <!--    
    <a  href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>&nbsp;&nbsp;Generate Report</a>
    -->
</div>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"></h6>
    </div>
        <div class="card-body">
            <div style="margin-top:-20px;" class="table-responsive">
            <table  style="font-size: 14px; vertical-align:middle; " class="table  order-column " id="dataTableExcel" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th class="text-center" style="font-size: 10px; vertical-align:middle; ">ID</th>
                    <th class="text-center" style="font-size: 10px; vertical-align:middle; ">Priority</th>
                    <th class="text-center" style="font-size: 10px; vertical-align:middle; min-width: 100px;">Project Type</th>
                    <th class="text-center" style="font-size: 10px; vertical-align:middle; min-width:50px;">Improvement Oportunity</th>
                    <th class="text-center" style="font-size: 10px; vertical-align:middle; ">Expected Improvement</th>
                    <th class="text-center" style="font-size: 10px; vertical-align:middle; ">Expected Cost Saving</th>
                    <th class="text-center" style="font-size: 10px; vertical-align:middle; ">ROI</th>
                    <th class="text-center" style="font-size: 10px; vertical-align:middle;min-width: 100px; ">Project Name</th>
                    <th class="text-center" style="min-width: 300px !important; font-size: 10px; vertical-align:middle;">Project Description</th>
                    <th class="text-center" style="font-size: 10px; vertical-align:middle; min-width:50px;">Department</th>
                    <th class="text-center" style="font-size: 10px; vertical-align:middle; min-width:50px;">Staff</th>
                    <th class="text-center" style="font-size: 10px; vertical-align:middle; min-width:50px;">Owner</th>
                    <th class="text-center" style="font-size: 10px; vertical-align:middle; min-width:50px;">Support</th>
                    <th class="text-center" style="font-size: 10px; vertical-align:middle; min-width:50px; ">Start</th>
                    <th class="text-center" style="font-size: 10px; vertical-align:middle; min-width:50px; ">Promise Date</th>
                    <th class="text-center" style="width: 100px; font-size: 10px; vertical-align:middle; min-width:50px;">Status</th>
                    <th class="text-center" style="width: 100px; font-size: 10px; vertical-align:middle; min-width:300px;">Last Update</th>
                    <th class="text-center" style="width: 100px; font-size: 10px; vertical-align:middle; min-width:100px;">Options</th>
                    <th class="text-center" style="font-size: 10px; vertical-align:middle; ">Complete</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                   
                    if($_SESSION['quatroapp_user_level'] >= 1)
                    {
                        $query = "SELECT * FROM projects 
                        LEFT JOIN departments ON projects.project_department = departments.department_id 
                        LEFT JOIN users as owner ON projects.project_owner = owner.user_id 
                        LEFT JOIN users as staff ON projects.staff = staff.user_id 
                        LEFT JOIN users as support ON projects.project_support = support.user_id 
                        WHERE project_active = 1 AND  project_status != 1 AND lean = 1";
                    }
                    else
                    {
                        $query = "SELECT * FROM `projects` 
                        LEFT JOIN departments ON projects.project_department = departments.department_id  
                        LEFT JOIN actions ON projects.project_id = actions.action_project_id 
                        LEFT JOIN action_responsible ON actions.action_id = action_responsible.a_action_id
                        LEFT JOIN users as owner ON projects.project_owner = owner.user_id 
                        LEFT JOIN users as support ON projects.project_support = support.user_id  
                        WHERE project_id IN (SELECT action_project_id FROM actions) 
                        AND action_responsible.a_responsible_user = {$_SESSION['quatroapp_user_id']} 
                        AND project_active = 1 
                        AND project_status != 1 
                        AND lean = 1
                        OR (project_owner = {$_SESSION['quatroapp_user_id']} OR project_support = {$_SESSION['quatroapp_user_id']} OR project_user_register = {$_SESSION['quatroapp_user_id']}  AND lean = 1)
                        GROUP BY projects.project_id";
                    }

                    

                    $result = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_array($result)):
                    ?>
                        <tr>
                            <td style="text-align: center;"><?php echo $row['project_id'];  ?></td>

                            <td style="text-align: center;">
                                <?php 
                                    if(isset($row['project_priority']) && $row['project_priority'] != 0)
                                    {
                                        echo $row['project_priority'];
                                    }
                                    else
                                    {
                                        echo "N/A";
                                    }
                                ?>
                            </td>
                            <td>
                            <?php 
                                if(isset($row['project_type']) && $row['project_type'] != '')
                                {
                                    echo $row['project_type'];
                                }
                                else
                                {
                                    echo "N/A";
                                }
                            ?>
                            </td>
                            <td style="text-align: center;">
                                <?php
                                if(isset($row['improvement_oportunity']) && $row['improvement_oportunity'] != '')
                                {
                                    echo $row['improvement_oportunity'];
                                }
                                else
                                {
                                    echo "N/A";
                                }
                                ?>
                            </td>
                            <td style="text-align: center;">
                                <?php
                                if(isset($row['expected_improvement']) && $row['expected_improvement'] != '')
                                {
                                    echo $row['expected_improvement'];
                                }
                                else
                                {
                                    echo "N/A";
                                }
                                ?>
                            </td>
                            <td style="text-align: center;">
                                <?php
                                if(isset($row['expected_cost_saving']) && $row['expected_cost_saving'] != '')
                                {
                                    echo $row['expected_cost_saving'];
                                }
                                else
                                {
                                    echo "N/A";
                                }
                                ?>
                            </td>
                            <td style="text-align: center;">
                                <?php
                                if(isset($row['roi']) && $row['roi'] != '')
                                {
                                    echo $row['roi'];
                                }
                                else
                                {
                                    echo "N/A";
                                }
                                ?>
                            </td>                         

                            <td style="text-align: center;"><?php echo $row['project_name'];  ?></td>
                            <td style="text-align: justify;"><?php echo $row['project_description'];  ?></td>
                            <td style="text-align: center;"><?php echo $row['department_name'];  ?></td>
                            <!--leader-->
                            <td style="text-align: center;">
                            <?php
                            if($row['staff'] != 0)
                            {
                                $query_leader = "SELECT * FROM users WHERE user_id = {$row['staff']}; ";
                                $run_leader_query = mysqli_query($connection, $query_leader);
                                $row_leader = mysqli_fetch_array($run_leader_query);
                                echo  $row_leader['user_name'] . "<br>";
                                echo $row_leader['user_first_name'] . " " . $row_leader['user_last_name'];
  
                            }
                            ?>
                            </td>
                            <td style="text-align: center;"><?php if($_SESSION['quatroapp_user_level']>= 1){echo $row['28'];}else{echo $row['46']; }  ?></td>
                            <td style="text-align: center;"><?php echo $row['user_name'];  ?></td>
                            <td style="text-align: center;"><?php echo date('m-d-Y', strtotime($row['project_start_date']));  ?></td>
                            <td style="text-align: center;"><?php echo date('m-d-Y', strtotime($row['project_promise_date']));  ?></td>
                            <td style="text-align: center;">
                                <?php 
                                $cont = 0;
                                $query = "SELECT * FROM actions WHERE action_project_id = {$row['project_id']}";
                                $run = mysqli_query($connection, $query);
                                $total = mysqli_num_rows($run);
                                while($rowc = mysqli_fetch_array($run))
                                {
                                    if($rowc['action_complete'] == 1)
                                    {
                                        $cont++;
                                    }
                                }
                                if($total == 0 || $cont == 0)
                                {
                                    $percentage = 0;
                                }
                                else
                                {
                                    $percentage = ceil(($cont/$total)*100);
                                }
                                
                                

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
                                <div data-toggle='tooltip' data-placement='left' title='<?php echo  $cont . " Of " . $total . " Tasks Completed"?>' class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated <?php echo $bg; ?>"  role="progressbar" aria-valuenow="<?php echo $percentage ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percentage ?>%"></div>
                                </div>
                                
                                <?php
                                    if($row['project_status'] == 0 && date("Y-m-d") >= $row['project_promise_date'])
                                    {
                                        echo "Late";
                                    }
                                    elseif($row['project_status'] == 0 && date("Y-m-d") < $row['project_promise_date'])
                                    {
                                        echo "On Time";
                                    }
                                    elseif($row['project_status'] == 1 && date("project_end_date") < $row['project_promise_date'])
                                    {
                                        echo "Finished On Time";
                                    }
                                    elseif($row['project_status'] == 1 && date("project_end_date") >= $row['project_promise_date'])
                                    {
                                        echo "Finished Late";
                                    }
                                    else
                                    {
                                        echo "N/A";
                                    }  
                                ?>
                            </td>
                            <td>
                                <?php
                                $last_update = "SELECT * FROM action_updates LEFT JOIN actions ON action_updates.a_update_action_id = actions.action_id 
                                WHERE actions.action_project_id = {$row['project_id']} ORDER BY action_updates.a_update_id DESC LIMIT 1";
                                $last_update_result = mysqli_query($connection, $last_update);
                                if($last_update_result)
                                {
                                    $row_last_update = mysqli_fetch_array($last_update_result);
                                    if($row_last_update['a_update_descr'] != "")
                                    {
                                        echo $row_last_update['a_update_descr'];
                                    }
                                    else
                                    {
                                        echo "No updates have been made.";    
                                    }

                                }
                                else{
                                    echo "N/A";
                                }
                                
                                ?>
                            </td>
                            <td>
                                <a href='index.php?page=project_view&project_id=<?php echo $row['project_id']?>'  class=''  data-cat-name='{$row['user_name']}' data-cat-id='{$row['user_id']}'><i data-toggle='tooltip' data-placement='left' title='View Project' style='font-size: 20px; color:#b5b5b5' class='far fa-eye options'></i></a>

                                <?php 
                                if( $_SESSION['quatroapp_user_level'] >= 1 || $row['project_owner']== $_SESSION['quatroapp_user_id'] || $row['project_support']== $_SESSION['quatroapp_user_id']):
                                ?>
                                <a href='index.php?page=project_edit&project_id=<?php echo $row['project_id']?>'  class=''  data-cat-name='{$row['user_name']}' data-cat-id='{$row['user_id']}'><i data-toggle='tooltip' data-placement='left' title='Edit Project' style='font-size: 20px; color:#b5b5b5' class='far fa-edit options'></i></a>
                                <a href='index.php?page=project_delete&project_id=<?php echo $row['project_id']?>'  class=''  data-cat-name='{$row['user_name']}' data-cat-id='{$row['user_id']}'><i data-toggle='tooltip' data-placement='left' title='Delete Project' style='font-size: 20px; color:#b5b5b5' class='far fa-trash-alt options'></i></a>
                                <?php 
                                endif;
                                ?>
                            </td>
                            <td>
                                <a href='index.php?page=project_complete&project_id=<?php echo $row['project_id']?>'  class=''  data-cat-name='{$row['user_name']}' data-cat-id='{$row['user_id']}'><i data-toggle='tooltip' data-placement='left' title='Mark as completed' style='font-size: 20px; color:#b5b5b5' class='fas fa-check options2'></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>                
            </table>
        </div>
    </div>
</div>




