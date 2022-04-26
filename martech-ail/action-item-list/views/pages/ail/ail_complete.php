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
                icon: 'success',
                text: '$message',
                type: 'success'
            }).then(function() {
                window.location = 'index.php?page=ail_add$p';
            });
          });
       </script>
       ";
      }
  }
}

if(isset($_GET['meeting_id']))
{
    $query_data = "SELECT * FROM ail_meeting WHERE meeting_id = {$_GET['meeting_id']}";
    $run_query = mysqli_query($connection, $query_data);
    $data = mysqli_fetch_array($run_query);
}

?>

<h1 class="h3 mb-4 text-gray-800">Add Action Item List</h1>
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
                
            
            
                <div class="col-lg-8 offset-lg-2">

                    <div class="row">
                        <div class="form-group col-lg-12">
                            <h3>Meeting</h3>
                        </div>

                        <div class="form-group col-lg-12">
                            <label>Meeting (Reason for meeting, Problem or Observation)</label>
                            <input type="text" name="meeting" id="" class="form-control" value="<?php if(isset($_POST['meeting'])){echo $_POST['meeting'];}else{if(isset($data['meeting_name'])){echo $data['meeting_name'];}else{echo "";};} ?>" disabled>
                        </div>

                        <div class="form-group col-lg-6">
                            <label>Department</label>
                            <select  name="department" id="" class="form-control" disabled>
                                <option value="">Select</option>
                                <?php 
                                $query1 = "SELECT * FROM departments WHERE department_active = 1";
                                $run1 = mysqli_query($connection, $query1);
                                while($row1 = mysqli_fetch_array($run1)):
                                ?>
                                    <option value="<?php echo $row1['department_id'] ?>" <?php if(isset($data['meeting_department']) && $data['meeting_department'] == $row1['department_id'] ){echo "selected";}else{echo "";} ?>><?php echo $row1['department_name'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="form-group col-lg-6">
                            <label>Meeting Date</label>
                            <input type="text" name="meeting_date" id="" class="form-control datepicker" value="<?php if(isset($_POST['meeting_date'])){echo $_POST['meeting_date'];}else{if(isset($data['meeting_date'])){echo $data['meeting_date'];}else{echo "";};} ?>" disabled>
                        </div>

                      



                    </div>

                    <div class="row">
                       
                        <table class="table">
                            <thead>
                                <th>Action</th>
                                <th>Issue</th>
                                <th>Responsible</th>
                                <th>ECD</th>
                                <th>Status</th>
                            </thead>
                            <tbody>
                            <?php 
                            if(isset($_GET['meeting_id'])):
                                $total = 0;
                                $completed = 0;
                                $query = "SELECT * FROM ail_action 
                                LEFT JOIN users ON users.user_id = ail_action.ail_owner 
                                WHERE ail_meeting_id = {$_GET['meeting_id']} AND action_active = 1";
                                $result = mysqli_query($connection, $query);
                                while($row = mysqli_fetch_array($result)):
                                    $total++;
                            ?>
                                    <tr>
                                        <td><?php echo $row['ail_action_name']; ?></td>

                                        <td><?php echo $row['ail_issue_name']; ?></td>
                                        
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
                                                if($row['action_complete'] == 0)
                                                {
                                                    echo "In Process";
                                                }
                                                else
                                                {
                                                    echo "Completed";
                                                    $completed++;
                                                }
                                            ?>
                                        </td>
                                       
                                    </tr>
                            <?php 
                                endwhile;
                            endif;
                            ?>
                                
                            </tbody>
                        </table>


                        <input name="total" value="<?php echo $total; ?>">
                        <input name="completed" value="<?php echo $completed; ?>">


                    </div><!--row end-->
                    
                    
                    <div style="margin-top: 50px;" class="form-group right">
                        <button style="float: right;" name="complete_meeting"   class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm ">
                            <i class="fas fa-check fa-lg text-white-50"></i>&nbsp;&nbsp;Complete
                        </button>
                    </div>
                </div><!--col-8-end--> 
            </div>
        </div>
    </div>
</div>    
</form>          










<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
     <form method="POST">  
      <div class="modal-header">
        <h5 class="modal-title" id="action-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">        
            <input id="action_id" type="hidden" name="action_id" value="">
           
            <div class="form-group col-lg-12">
                <label>Action</label>
                <input type="text" name="action" id="action-name" class="form-control" required>
            </div>

            
            <div class="form-group col-lg-12">
                <label>Issue</label>
                <input type="text" name="issue" id="issue-name" class="form-control" required>
            </div>

            <div class="form-group col-lg-12">
                <label for="id_label_single">Action Owner</label>
                <select style="width: 100%;" class=" js-example-basic-single form-control" id="id_label_single1" name="owner" required>
                    <?php 
                    $query = "SELECT * FROM users WHERE user_active = 1";
                    $result = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_array($result)):
                    ?>
                        <option value="<?php echo $row['user_id']; ?>"><?php echo $row['user_name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>


            <div class="form-group col-lg-12">
                <label for="id_label_single">Support personnel</label>
                <select style="width: 100%;" class=" js-example-basic-multiple form-control" id="id_label_multiple1" name="responsible[]" multiple="multiple" > 
                    <?php 
                    $query = "SELECT * FROM users WHERE user_active = 1";
                    $result = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_array($result)):
                    ?>
                        <option value="<?php echo $row['user_id']; ?>"><?php echo $row['user_name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>


            <div class="form-group col-lg-12">
                <label>ECD</label>
                <input type="text" id="ecd" name="ecd" id="" class="form-control datepicker" value="<?php if(isset($_POST['project_start_date'])){echo $_POST['project_start_date'];} ?>" required>
            </div>


            <div class="form-group">
                
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="edit_action" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>





















<!-- Modal delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <form method="POST">
      <div class="bg-danger modal-header">
        <h5 class="text-white modal-title" id="action-title-delete"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
       
        <input id="action-id-delete" type="hidden" name="action_id" value="">
           
        <b>You are about to delete this action press on delete action to confirm.</b>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="delete_action" class="btn btn-danger">Delete Action</button>
      </div>
    </form>
    </div>
  </div>
</div>


<!--
ALTER TABLE `projects` ADD `project_priority` INT(2) NOT NULL DEFAULT '0' AFTER `project_complete`, ADD `project_type` VARCHAR(255) NOT NULL AFTER `project_priority`, ADD `improvement_oportunity` VARCHAR(255) NOT NULL AFTER `project_type`, ADD `key_indicator_id` INT(11) NOT NULL AFTER `improvement_oportunity`, ADD `expected_improvement` FLOAT(11) NOT NULL AFTER `key_indicator_id`, ADD `achieved_improvement` FLOAT(11) NOT NULL AFTER `expected_improvement`, ADD `expected_cost_saving` FLOAT(11) NOT NULL AFTER `achieved_improvement`, ADD `achieved_cost_saving` FLOAT(11) NOT NULL AFTER `expected_cost_saving`;
    -->