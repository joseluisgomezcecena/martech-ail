<?php
require_once("classes/Project.php");
$project = new Project();


if (isset($project)) {
    if ($project->errors) {
        foreach ($project->errors as $error) {
          echo "
          <script type='text/javascript'>
            document.addEventListener('DOMContentLoaded', function(event) {
              swal('Error!','$error','error');
            });
         </script>
         ";        }
    }
    if ($project->messages) {
        foreach ($project->messages as $message) {
          $p =   implode(',',$project->project);
          if($p == 1){
              $p = "project_list_lean";
          }
          else{
              $p = "project_list";
          }  
          echo "
          <script type='text/javascript'>
            document.addEventListener('DOMContentLoaded', function(event) {
              
              swal({
                  title: 'Success!',
                  text: '$message',
                  type: 'success'
              }).then(function() {
                  window.location = 'index.php?page=$p';
              });
            });
         </script>
         ";
        }
    }
}
  
$stmt = $connection->prepare("SELECT * FROM projects WHERE project_id = ?");
$stmt->bind_param("i", $_GET['project_id']);
$stmt->execute();

$result = $stmt->get_result();
if($result->num_rows === 0) 
    exit('No rows');

$row_data = $result->fetch_array();
$stmt->close();

?>

<h1 class="h3 mb-4 text-gray-800">Edit Project <b><?php echo $row_data['project_name']; ?></b></h1>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.php?page=project_list">Back To Project List</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit Project <?php echo $row_data['project_name']; ?></li>
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
                        <div class="dropdown-header">Dropdown Header:</div>
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div id="profile-data" class="card-body">
                
            
            
                <div class="col-lg-8 offset-lg-2">

                <div class="row">
                    <div class="form-group col-lg-3">
                        <label>Lean Tracker Project</label>
                        <select  name="project_lean" id="" class="form-control" required>
                            <option value="">Select</option>
                            <option <?php if($row_data['lean'] == 0){echo "selected";}else{echo "";} ?> value="0">No</option>
                            <option <?php if($row_data['lean'] == 1){echo "selected";}else{echo "";} ?> value="1">Yes</option>
                        </select>
                    </div>
                </div>


                <div class="row">
                    <div class="form-group col-lg-6">
                        <label>Priority</label>
                        <select  name="project_priority" id=""  class="form-control">
                            <option value="">Select</option>
                            <?php for($x = 1; $x <= 25; $x++): ?>
                                <option <?php if($row_data['project_priority'] == $x){echo "selected";}else{echo "";} ?> value="<?php echo $x ?>">Priority <?php echo $x ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="form-group col-lg-6">
                        <label>Project Type</label>
                        <select  name="project_type" id="" class="form-control">
                            <option value="">Select</option>
                            <option <?php if($row_data['project_type'] == 'Automation'){echo "selected";}else{echo"";} ?> >Automation</option>
                            <option <?php if($row_data['project_type'] == 'Departamental'){echo "selected";}else{echo"";} ?> >Departamental</option>
                            <option <?php if($row_data['project_type'] == 'Kaizen'){echo "selected";}else{echo"";} ?> >Kaizen</option>
                            <option <?php if($row_data['project_type'] == 'Project'){echo "selected";}else{echo"";} ?> >Project</option>
                            <option <?php if($row_data['project_type'] == 'Software Application'){echo "selected";}else{echo"";} ?> >Software Application</option>
                            <option <?php if($row_data['project_type'] == 'VSM'){echo "selected";}else{echo"";} ?> >VSM</option>
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group col-lg-4">
                        <label>Improvement Oportunity</label>
                        <input type="text" name="improvement_oportunity" id="" value="<?php echo $row_data['improvement_oportunity'] ?>" class="form-control" required>
                    </div>

                    <div class="form-group col-lg-4">
                        <label>Key indicator</label>
                        <select  name="key_indicator_id" id="" class="form-control">
                            <option value="">Select</option>
                            <?php 
                            $query = "SELECT * FROM key_indicator";
                            $run = mysqli_query($connection, $query);
                            while($row = mysqli_fetch_array($run)):
                            ?>
                                <option <?php if($row_data['key_indicator_id'] == $row['key_id']){echo "selected";}else{echo"";} ?> value="<?php echo $row['key_id'] ?>"><?php echo $row['key_name']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group col-lg-4">
                        <label>Expected Improvement Percent %</label>
                        <input type="number" name="expected_improvement" id="" step=".1" class="form-control" value="<?php echo $row_data['expected_improvement'] ?>"  required>
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label>Expected Annual Cost Saving $</label>
                        <input type="number" name="expected_cost_saving" id="" step=".01" class="form-control" value="<?php echo $row_data['expected_cost_saving'] ?>" required>
                    </div>

                    <div class="form-group col-lg-6">
                        <label>ROI Months</label>
                        <input type="number" name="roi" id="" class="form-control" value="<?php echo $row_data['roi'] ?>" required>
                    </div>
                </div>
                






                <div class="form-group">
                        <label>Project Name</label>
                        <input type="text" name="project_name" id="" class="form-control" value="<?php echo $row_data['project_name'] ?>" required>
                    </div>

                    <div class="form-group ">
                          <label>Department</label>
                          <select  name="project_department" id="" class="form-control">
                            <option value="">Select</option>
                            <?php 
                            $query1 = "SELECT * FROM departments WHERE department_active = 1";
                            $run1 = mysqli_query($connection, $query1);
                            while($row1 = mysqli_fetch_array($run1)):
                            ?>
                                <option <?php if($row_data['project_department'] == $row1['department_id']){echo "selected";}else{echo "";} ?> value="<?php echo $row1['department_id'] ?>"><?php echo $row1['department_name'] ?></option>
                            <?php endwhile; ?>
                          </select>
                    </div>

                    <div class="form-group">
                        <label>Project Description</label>
                        <textarea name="project_description" id="" class="form-control" rows="7" required><?php echo $row_data['project_description'] ?></textarea>
                    </div>


                    <div class="form-group">
                            <label for="id_label_single">Staff Leader</label>
                            <select style="width: 100%;" class=" js-example-basic-single form-control" id="id_label_single3" name="staff" required>
                                <?php 
                                $query = "SELECT * FROM users WHERE user_active = 1";
                                $result = mysqli_query($connection, $query);
                                while($row = mysqli_fetch_array($result)):
                                ?>
                                    <option <?php if($row_data['staff'] == $row['user_id']){echo "selected";}else{echo "";} ?> value="<?php echo $row['user_id']; ?>"><?php echo $row['user_name']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>




                    <div class="form-group">
                        <label for="id_label_single">Project Owner</label>
                        <select style="width: 100%;" class=" js-example-basic-single form-control" id="id_label_single" name="project_owner" required>
                            <?php 
                            $query = "SELECT * FROM users WHERE user_active = 1";
                            $result = mysqli_query($connection, $query);
                            while($row = mysqli_fetch_array($result)):
                            ?>
                                <option <?php if($row_data['project_owner'] == $row['user_id']){echo "selected";}else{echo "";} ?> value="<?php echo $row['user_id']; ?>"><?php echo $row['user_name']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id_label_single">Project Support</label>
                        <select style="width: 100%;" class=" js-example-basic-single form-control" id="id_label_single2" name="project_support" required>
                            <?php 
                            $query = "SELECT * FROM users WHERE user_active = 1";
                            $result = mysqli_query($connection, $query);
                            while($row = mysqli_fetch_array($result)):
                            ?>
                                <option <?php if($row_data['project_support'] == $row['user_id']){echo "selected";}else{echo "";} ?> value="<?php echo $row['user_id']; ?>"><?php echo $row['user_name']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    

                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label>Project Start Date</label>
                            <input type="text" name="project_start_date" id="" class="form-control datepicker" value="<?php echo date_format(date_create($row_data['project_start_date']), "m/d/Y");  ?>" required>
                        </div>

                        <div class="form-group col-lg-6">
                            <label>Project Promise Date</label>
                            <input type="text" name="project_promise_date" id="" class="form-control datepicker" value="<?php echo date_format(date_create($row_data['project_promise_date']), "m/d/Y"); ?>" required>
                        </div>
                    </div>

                    
                   


                    <div class="row">
                        <div class="col-lg-12">
                            <label>Project Phases</label>

                            <div id="phasesold">
                                <?php 

                                $phases_query = "SELECT * FROM project_phase WHERE project_id = {$_GET['project_id']} AND phase_active = 1";
                                $run_query = mysqli_query($connection, $phases_query);
                                while($row_phases = mysqli_fetch_array($run_query)):
                                ?>
                                    <div class="input-group mb-3">
                                        <input type="text" name="phase2" class="form-control m-input2 phasesclass" placeholder="Enter Phase" data-phase-id="<?php echo $row_phases['phase_id']; ?>" value="<?php echo $row_phases['phase_name']; ?>" autocomplete="off">
                                        <div class="input-group-append">                
                                            <button  id="removeRow" type="button" data-phase-id="<?php echo $row_phases['phase_id']; ?>" class="btn btn-danger delete-phase">Remove</button>
                                        </div>
                                    </div>
                                <?php

                                endwhile;
                                ?>
                            </div>


                            <div id="inputFormRow">
                                <div class="input-group mb-3">
                                    <input type="text" name="phase[]" class="form-control m-input" placeholder="Enter Phase" autocomplete="off">
                                    <div class="input-group-append">                
                                        <button id="removeRow" type="button" class="btn btn-danger">Remove</button>
                                    </div>
                                </div>
                            </div>

                            <div id="newRow"></div>
                            <button id="addRow" type="button" class="btn btn-dark">Add Phase</button>
                        </div>
                    </div>


                    
                    <div class="form-group right">
                        <button style="float: right;" id="edit_profile1" name="edit_project" type="submit" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm ">
                            <i class="far fa-save fa-lg text-white-50"></i>&nbsp;&nbsp;Save Project
                        </button>
                    </div>




                </div>
                    
               
            </div>
        </div>

    </div>






</div>    
</form>          








