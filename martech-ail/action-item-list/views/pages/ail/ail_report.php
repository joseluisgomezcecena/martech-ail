<?php
require_once("classes/ActionItem.php");
$actionitem = new ActionItem();


if (isset($actionitem)) {
  if ($actionitem->errors) {
      foreach ($actionitem->errors as $error) {
        echo "
        <script type='text/javascript'>
          document.addEventListener('DOMContentLoaded', function(event) {
            swal('Error!','$error','error');
          });
       </script>
       ";        }
  }
  if ($actionitem->messages) {
      foreach ($actionitem->messages as $message) {
        $p =   implode(',',$actionitem->project);  
        if($p != ''){
            $p = '&meeting_id='.$p;
        }
        else{
            $p = '';
        }
        echo "
        <script type='text/javascript'>
          document.addEventListener('DOMContentLoaded', function(event) {
            
            swal({
                title: 'Success!',
                text: '$message',
                type: 'success'
            }).then(function() {
                window.location = 'index.php?page=ail_view$p';
            });
          });
       </script>
       ";
      }
  }
}

if(isset($_GET['meeting_id']))
{
    $query_data = "SELECT * FROM ail_meeting 
    LEFT JOIN departments ON ail_meeting.meeting_department = departments.department_id  
    WHERE meeting_id = {$_GET['meeting_id']}";
    
    $run_query = mysqli_query($connection, $query_data);
    $data = mysqli_fetch_array($run_query);
}

?>

<h1 class="h3 mb-4 text-gray-800">Report Meeting</h1>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.php?page=ail_list">Back To Lists</a></li>
    <li class="breadcrumb-item active" aria-current="page">Add Action Item List</li>
  </ol>
</nav>
<form method="POST" id="form-user" autocomplete="off" enctype="multipart/form-data">

<div class="row">
    <div class="col-lg-12 ">
        <!-- Dropdown Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        
                <h6 class="m-0 font-weight-bold text-default"></h6>
                        
                <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Options:</div>
                        <a class="dropdown-item" href="#">Return to lists</a>
                        <a class="dropdown-item" href="#">Refresh Page</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" target="_blank" href="index.php?page=user_list">Add Users</a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div id="profile-data" class="card-body">
                
            
            
                <div class="col-lg-10 offset-lg-1">


                    <div class="row">   
                        <div class="table-responsive">
                            <table style="width: 100%;" class="table" id="dataTableExcel">
                                <thead>
                                    <th>Action</th>
                                    <th>Responsible</th>
                                    <th>ECD</th>
                                    <th>Updates</th>
                                    <th>Status</th>
                                </thead>
                                <tbody>
                                <?php 
                                if(isset($_GET['meeting_id'])):
                                    $query = "SELECT * FROM ail_action 
                                    LEFT JOIN users ON users.user_id = ail_action.ail_owner 
                                    WHERE ail_meeting_id = {$_GET['meeting_id']} AND action_active = 1 ORDER BY ail_action_ecd";
                                    $result = mysqli_query($connection, $query);
                                    while($row = mysqli_fetch_array($result)):
                                ?>
                                        <tr>
                                            <td><?php echo $row['ail_action_name']; ?></td>
                                            
                                            <td>
                                            <b><?php echo $row['user_name'] ?></b><br>
                                            <?php
                                                $query_users = "SELECT * FROM ail_users 
                                                LEFT JOIN users ON users.user_id = ail_users.ail_user_id 
                                                WHERE ail_meeting_id =  {$_GET['meeting_id']} AND ail_action_id = {$row['ail_action_id']}";
                                                $run_user_query = mysqli_query($connection, $query_users);
                                                while($row_users = mysqli_fetch_array($run_user_query)):
                                            ?>
                                                <?php echo $row_users['user_name'] ?><br>
                                            <?php endwhile; ?>
                                            </td>
                                            
                                            <td><?php echo $row['ail_action_ecd'] ?></td>
                                            
                                           
                                            <td>
                                                <?php 
                                                $query_updates = "SELECT * FROM ail_updates 
                                                LEFT JOIN users ON users.user_id = ail_updates.update_user 
                                                WHERE action_id = {$row['ail_action_id']} ORDER BY update_id DESC";
                                                $result_updates = mysqli_query($connection, $query_updates);
                                                while($row_updates = mysqli_fetch_array($result_updates)):
                                                ?>
                                                    <b class="text_primary"><?php echo $row_updates['update_date'] ?></b>&nbsp;&nbsp;
                                                    <?php echo $row_updates['update_text'] ?><br>
                                                    <?php echo $row_updates['user_name'] ?><br>

                                                <?php endwhile; ?>
                                            </td>

                                            <td>
                                                <?php if($row['action_complete'] == 0){echo "In Process";}else{echo "Completed";} ?>
                                            </td>
                                        </tr>
                                <?php 
                                    endwhile;
                                endif;
                                ?>
                                    
                                </tbody>
                            </table>

                        </div>
                    </div><!--row end-->
                    
                    
                   




                </div><!--col-8-end-->
                    
               
            </div>
        </div>

    </div>
</div>    
</form>          
