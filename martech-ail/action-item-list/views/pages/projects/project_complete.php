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
        echo "
        <script type='text/javascript'>
          document.addEventListener('DOMContentLoaded', function(event) {
            
            swal({
                title: 'Success!',
                text: '$message',
                type: 'success'
            }).then(function() {
                window.location = 'index.php?page=project_list';
            });
          });
       </script>
       ";
      }
  }
}

$stmt = $connection->prepare("SELECT * FROM projects LEFT JOIN key_indicator ON projects.key_indicator_id = key_indicator.key_id WHERE project_id = ?");
$stmt->bind_param("i", $_GET['project_id']);
$stmt->execute();

$result = $stmt->get_result();
if($result->num_rows === 0) 
    exit('No rows');

$row_data = $result->fetch_array();
$stmt->close();

?>

<h1 class="h3 mb-4 text-gray-800">Complete Project <b><?php echo $row_data['project_name']; ?></b></h1>
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


                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Notice!</strong> You are about to mark this project as completed: <b><?php echo $row_data['project_name'] ?></b>, by doing so you all records of actions and responsabilities will be lost.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                    <div class="form-group">
                        <b>Project Name</b><br>
                        <?php echo $row_data['project_name'] ?>
                    </div>

                    <div class="form-group">
                        <b>Project Description</b><br>
                        <?php echo $row_data['project_description'] ?>
                    </div>

                    <div class="form-group">
                        Expected Improvement: <b class="text-success"><?php echo $row_data['expected_improvement']; ?>% <?php echo $row_data['improvement_oportunity']; ?></b><br>
                    </div>
                    

                    <div class="form-group">
                        <label>Achieved Improvement</label>
                        <input type="number"   class="form-control" name="achieved_improvement" />
                        <small>Required field <i class="text-danger">*</i></small>
                    </div>



                    <div class="form-group">
                        Expected Cost Saving: <b class="text-success">$<?php echo $row_data['expected_cost_saving']; ?> In <?php echo $row_data['roi']; ?> Months</b><br>
                    </div>
                    

                    <div class="form-group">
                        <label>Achieved Cost Saving</label>
                        <input type="number"   class="form-control" name="achieved_cost_saving" />
                        <small>Required field <i class="text-danger">*</i></small>
                    </div>
                    
                    


                    
                    <div class="form-group right">
                        <button style="float: right;" id="edit_profile1" name="complete_project" type="submit" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm ">
                            <i class="fas fa-check fa-lg text-white-50"></i>&nbsp;&nbsp;Mark As A Completed Project.
                        </button>
                    </div>




                </div>
                    
               
            </div>
        </div>

    </div>






</div>    
</form>          








