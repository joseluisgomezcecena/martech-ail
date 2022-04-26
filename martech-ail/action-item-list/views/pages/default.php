<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Home</h1>
</div>


<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">View Project List</a></li>
    <li class="breadcrumb-item active" aria-current="page">My Projects</li>
  </ol>
</nav>


  

<?php //include("views/includes/panels/project_cards.php"); ?> 



<div class="row">
  <div class="col-lg-12">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">My Pending Actions</h6>
    </div>
        <div class="card-body">
            <div style="margin-top:-20px;" class="table-responsive">
            <table  style=" vertical-align:middle; " class="table  order-column table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Action</th>
                    <th>Origin</th>
                    <th>Responsible</th>
                    <th>Promise Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                    <?php 
                    $query = "SELECT * FROM action_responsible 
                    LEFT JOIN actions ON action_responsible.a_action_id = actions.action_id
                    LEFT JOIN projects ON actions.action_project_id = projects.project_id 
                    WHERE a_responsible_user = {$_SESSION['quatroapp_user_id']} AND action_complete = 0 AND project_active = 1 
                    GROUP BY actions.action_id";
                  
                    $result = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_array($result)):
                    ?>
                        <tr>
                            <td><?php echo $row['action_name'];  ?></td>
                            
                            <td>
                                <b class="text-success">
                                    Projects: <?php echo $row['project_name']; ?>
                                </b>
                            </td>

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
                                <a href='index.php?page=view_update&action_id=<?php echo $row['action_id']?>'  class=''  data-cat-name='{$row['user_name']}' data-cat-id='{$row['user_id']}'><i data-toggle='tooltip' data-placement='left' title='Go to Action Details' style='font-size: 20px; color:#b5b5b5' class='fas fa-paper-plane options'></i></a>
                            </td>
                            
                        </tr>
                    <?php endwhile; ?>



                    <?php 
                    $query = "SELECT * FROM tier_action_responsible 
                    LEFT JOIN tier_actions ON tier_action_responsible.a_action_id = tier_actions.action_id
                    LEFT JOIN tiers ON tier_actions.action_tier_id = tiers.tier_id 
                    LEFT JOIN tier_area ON tier_actions.action_tier_area = tier_area.area_id  
                    WHERE a_responsible_user = {$_SESSION['quatroapp_user_id']} AND action_complete = 0   
                    GROUP BY tier_actions.action_id";
                  
                    $result = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_array($result)):
                    ?>
                        <tr>
                            <td><?php echo $row['action_name'];  ?></td>
                            <td><b class="text-primary"><?php echo $row['tier_name'];  ?><br><?php echo $row['area_name'];  ?> <?php echo $row['area_ident'];  ?></b></td>
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
                                <a href='index.php?page=tier_view_update&action_id=<?php echo $row['action_id']?>'  class=''  data-cat-name='{$row['user_name']}' data-cat-id='{$row['user_id']}'><i data-toggle='tooltip' data-placement='left' title='Go to Action Details' style='font-size: 20px; color:#b5b5b5' class='fas fa-paper-plane options'></i></a>
                            </td>
                            
                        </tr>
                    <?php endwhile; ?>


                    
                    <?php 
                    $query = "SELECT * FROM ail_users 
                    LEFT JOIN ail_action ON ail_users.ail_action_id = ail_action.ail_action_id
                    LEFT JOIN users ON users.user_id = ail_action.ail_owner 
                    LEFT JOIN ail_meeting ON ail_meeting.meeting_id = ail_action.ail_meeting_id 
                    WHERE (ail_user_id = {$_SESSION['quatroapp_user_id']} AND action_active = 1 AND action_complete = 0) 
                    OR
                    (ail_owner = {$_SESSION['quatroapp_user_id']} AND action_active = 1 AND action_complete = 0)   
                    GROUP BY ail_action.ail_action_id";

                    $result = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_array($result)):
                    ?>

                    <tr>
                        <td><?php echo $row['ail_action_name'] ?></td>
                        <td><b class="text-danger"><?php echo $row['meeting_name'] ?></b></td>
                        <td>
                        <?php
                            echo "<a href=''>" . $row['user_name'] . "</a>&nbsp;&nbsp;<i class='fas fa-exclamation-circle text-danger'></i>";

                            $query2 = "SELECT * FROM ail_users 
                            LEFT JOIN users ON ail_users.ail_user_id = users.user_id
                            WHERE ail_action_id = {$row['ail_action_id']}";
                            $result2 = mysqli_query($connection, $query2);
                            while($row2 = mysqli_fetch_array($result2)){
                                echo "<br><a href=''>" . $row2['user_name'] . "</a>" ;
                            }
                        ?>
                        </td>

                        <td><?php echo $row['ail_action_ecd']; ?></td>


                        <td>
                                <?php
                                    if($row['action_complete'] == 0 && $row['ail_action_ecd'] <= date("Y-m-d"))
                                    {
                                        echo "Late";
                                    }   
                                    elseif($row['action_complete'] == 0 && $row['ail_action_ecd'] > date("Y-m-d"))
                                    {
                                        echo "On time";
                                    }
                                ?>
                            </td>
                            
                            <td>
                                <a href='index.php?page=ail_view&meeting_id=<?php echo $row['meeting_id']?>'  class=''  data-cat-name='{$row['user_name']}' data-cat-id='{$row['user_id']}'><i data-toggle='tooltip' data-placement='left' title='Go to Action Details' style='font-size: 20px; color:#b5b5b5' class='fas fa-paper-plane options'></i></a>
                            </td>



                    </tr>

                    <?php endwhile; ?>


                </tbody>                
            </table>
        </div>
    </div>
</div>
</div>
</div> <!--row end-->




<div>
<div class="cokl-lg-12">
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">My Pending Actions</h6>
    </div>
        <div class="card-body">
            <div id="dp"></div>
        </div>
</div>
</div>



<script type="text/javascript">
  var dp = new DayPilot.Gantt("dp");
  //dp.startDate = "2021-01-01";
  dp.startDate = "<?php echo date("Y-m-d") ?>";
  dp.days = 365;
  dp.init();

  loadTasks();

  function loadTasks() {
    dp.tasks.load("functions/gantt/gantt_tasks.php");
  }

</script>
