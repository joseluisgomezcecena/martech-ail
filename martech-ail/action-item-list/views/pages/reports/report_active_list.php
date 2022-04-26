<h1 class="h3 mb-4 text-gray-800">Active Project Report</h1>

<div style="margin-bottom:15px;">
    <!-- 
    <a  href="index.php?page=project_add" id="add-newuser" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" ><i class="fas fa-plus fa-sm text-white-50"></i>&nbsp;&nbsp;Add Project</a>
       
    <a  href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>&nbsp;&nbsp;Generate Report</a>
    -->
</div>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"></h6>
    </div>
        <div class="card-body">
            <div style="margin-top:-20px;" class="table-responsive">
            <table  style="font-size: 14px; vertical-align:middle; " class="table  order-column " id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Project Name</th>
                    <th style="width: 200px;">Project Description</th>
                    <th>Department</th>
                    <th>Owner</th>
                    <th>Support</th>
                    <th>Start</th>
                    <th>Promise Date</th>
                    <th style="width: 100px;">Status</th>
                    <th>Complete</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                   
                    if($_SESSION['quatroapp_user_level'] >= 1)
                    {
                        $query = "SELECT * FROM projects 
                        LEFT JOIN departments ON projects.project_department = departments.department_id 
                        LEFT JOIN users as owner ON projects.project_owner = owner.user_id 
                        LEFT JOIN users as support ON projects.project_support = support.user_id 
                        LEFT JOIN actions ON projects.project_id = actions.action_project_id  
                        WHERE project_active = 1 AND project_status = 0 AND actions.action_project_id > 0 
                        GROUP BY project_id  
                        ORDER BY project_id; ";
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
                        AND project_status = 0 GROUP BY projects.project_id";
                    }

                    

                    $result = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_array($result)):
                    ?>
                        <tr>
                            <td style="text-align: center;"><?php echo $row['project_id'];  ?></td>
                            <td style="text-align: center;"><?php echo $row['project_name'];  ?></td>
                            <td style="text-align: justify;"><?php echo $row['project_description'];  ?></td>
                            <td style="text-align: center;"><?php echo $row['department_name'];  ?></td>
                            <td style="text-align: center;"><?php if($_SESSION['quatroapp_user_level']>= 1){echo $row['16'];}else{echo $row['34']; }  ?></td>
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
                                <!--    
                                <a href='index.php?page=action_add&project_id=<?php echo $row['project_id']?>'  class=''  data-cat-name='{$row['user_name']}' data-cat-id='{$row['user_id']}'><i data-toggle='tooltip' data-placement='left' title='Add a task to this project' style='font-size: 20px; color:#b5b5b5' class='fas fa-folder-plus options'></i></a>
                                -->
                                <a href='index.php?page=report&project_id=<?php echo $row['project_id']?>'  class=''  data-cat-name='{$row['user_name']}' data-cat-id='{$row['user_id']}'><i data-toggle='tooltip' data-placement='left' title='Generate Report' style='font-size: 28px; color:#03913a' class='far fa-file-excel options2'></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>                
            </table>
        </div>
    </div>
</div>




