<h1 class="h3 mb-4 text-gray-800">Meetings</h1>

<div style="margin-bottom:15px;">
    <a  href="index.php?page=ail_add" id="add-newuser" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" ><i class="fas fa-plus fa-sm text-white-50"></i>&nbsp;&nbsp;Add Meeting</a>
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
            <table  style="font-size: 12px; vertical-align:middle; " class="table  order-column table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th class="text-center" style="font-size: 12px; vertical-align:middle; ">ID</th>
                    <th class="text-center" style="font-size: 12px; vertical-align:middle; width:250px; ">Meeting</th>
                    <th class="text-center" style="font-size: 12px; vertical-align:middle;">Department</th>
                    <th class="text-center" style="font-size: 12px; vertical-align:middle; ">Meeting Date</th>
                    <th class="text-center" style="font-size: 12px; vertical-align:middle; width:250px; min-width:160px;">Actions</th>
                    <th class="text-center" style="width: 100px; font-size: 12px; vertical-align:middle; min-width:100px;">Options</th>
                    <th class="text-center" style="font-size: 12px; vertical-align:middle; ">Complete</th>
                </tr>
                </thead>
                <tbody>
                    <?php
//                        LEFT JOIN users as owner ON ail_meeting.project_owner = owner.user_id 
                   
                    if($_SESSION['quatroapp_user_level'] >= 1)
                    {
                        $query = "SELECT * FROM ail_meeting 
                        LEFT JOIN departments ON ail_meeting.meeting_department = departments.department_id  
                        WHERE ail_meeting.active = 1 AND ail_meeting.meeting_complete = 0";
                    }
                    else
                    {

                        /*
                        SELECT * FROM ail_meeting 
                        LEFT JOIN ail_action ON ail_meeting.meeting_id = ail_action.ail_meeting_id 
                        LEFT JOIN ail_users ON ail_users.ail_action_id = ail_action.ail_action_id 
                        LEFT JOIN users ON ail_users.ail_user_id = users.user_id 
                        WHERE ail_meeting.meeting_id IN (SELECT ail_meeting_id FROM ail_action) 
                        AND ail_users.ail_user_id = 143


                        SELECT * FROM ail_meeting 
                        LEFT JOIN ail_action ON ail_meeting.meeting_id = ail_action.ail_meeting_id 
                        LEFT JOIN ail_users ON ail_users.ail_action_id = ail_action.ail_action_id 
                        LEFT JOIN users ON ail_users.ail_user_id = users.user_id 
                        WHERE (ail_meeting.meeting_id IN (SELECT ail_meeting_id FROM ail_action) AND ail_users.ail_user_id = 143 AND active = 1) 
                        OR 
                        (ail_action.ail_owner = 143 AND active = 1)



                        */

                        $query = "SELECT * FROM ail_meeting 
                        LEFT JOIN ail_action ON ail_meeting.meeting_id = ail_action.ail_meeting_id 
                        LEFT JOIN ail_users ON ail_users.ail_action_id = ail_action.ail_action_id 
                        LEFT JOIN departments ON departments.department_id = ail_meeting.meeting_department 
                        LEFT JOIN users ON ail_users.ail_user_id = users.user_id 
                        WHERE 
                        (ail_meeting.meeting_id IN (SELECT ail_meeting_id FROM ail_action) AND ail_users.ail_user_id = {$_SESSION['quatroapp_user_id']} 
                        AND active = 1 AND meeting_complete = 0) 
                        OR 
                        (ail_action.ail_owner = {$_SESSION['quatroapp_user_id']} AND active = 1 AND meeting_complete = 0)
                        GROUP BY ail_meeting.meeting_id";
                    }

                    

                    $result = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_array($result)):
                    ?>
                        <tr>
                            <td style="text-align: center;"><?php echo $row['meeting_id'];  ?></td>
                            
                            <td style="text-align: center;"><?php echo $row['meeting_name'];  ?></td>
                            
                            <td style="text-align: center;"><?php echo $row['department_name'];  ?></td>
                            
                            <td style="text-align: center;"><?php echo date('m-d-Y', strtotime($row['meeting_date']));  ?></td>
                            
                            <td style="text-align: center;">
                                <?php 
                                $query_actions = "SELECT * FROM ail_action WHERE ail_meeting_id = {$row['meeting_id']}";
                                $run_query = mysqli_query($connection, $query_actions);
                                while($row_actions = mysqli_fetch_array($run_query)):
                                ?>
                                    <?php echo $row_actions['ail_action_name'] ?><br>
                                <?php endwhile; ?>
                            </td>
                            
                           
                            <td style="text-align: center;">
                                <a href='index.php?page=ail_view&meeting_id=<?php echo $row['meeting_id']?>'  class=''  data-cat-name='{$row['user_name']}' data-cat-id='{$row['user_id']}'><i data-toggle='tooltip' data-placement='left' title='View Meeting Details' style='font-size: 20px; color:#b5b5b5' class='far fa-eye options'></i></a>

                                <?php 
                                if($_SESSION['quatroapp_user_level'] >= 1 || $row['meeting_owner']== $_SESSION['quatroapp_user_id'] ):
                                ?>
                                
                                <a href='index.php?page=ail_add&meeting_id=<?php echo $row['meeting_id']?>'  class=''  data-cat-name='{$row['user_name']}' data-cat-id='{$row['user_id']}'><i data-toggle='tooltip' data-placement='left' title='Edit Meeting' style='font-size: 20px; color:#b5b5b5' class='far fa-edit options'></i></a>

                                <a href='index.php?page=meeting_ail_delete&meeting_id=<?php echo $row['meeting_id']?>'  class=''  data-cat-name='{$row['user_name']}' data-cat-id='{$row['user_id']}'><i data-toggle='tooltip' data-placement='left' title='Delete Meeting' style='font-size: 20px; color:#b5b5b5' class='far fa-trash-alt options'></i></a>
                                
                                <?php 
                                endif;
                                ?>
                            </td>
                            
                            <td style="text-align: center;">
                                <a href='index.php?page=ail_complete&meeting_id=<?php echo $row['meeting_id']?>'  class=''  data-cat-name='{$row['user_name']}' data-cat-id='{$row['user_id']}'><i data-toggle='tooltip' data-placement='left' title='Mark as completed' style='font-size: 20px; color:#b5b5b5' class='fas fa-check options2'></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>                
            </table>
        </div>
    </div>
</div>




