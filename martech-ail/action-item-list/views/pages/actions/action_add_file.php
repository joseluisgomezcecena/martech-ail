<?php
require_once("classes/ActionUpdate.php");
$actionUpdate = new ActionUpdate();


if (isset($actionUpdate)) {
  if ($actionUpdate->errors) {
      foreach ($actionUpdate->errors as $error) {
        echo "
        <script type='text/javascript'>
          document.addEventListener('DOMContentLoaded', function(event) {
            swal('Error!','$error','error');
          });
       </script>
       ";        }
  }
  if ($actionUpdate->messages) {
      foreach ($actionUpdate->messages as $message) {
        $p =   implode(',',$actionUpdate->project);  
        echo "
        <script type='text/javascript'>
          document.addEventListener('DOMContentLoaded', function(event) {
            
            swal({
                title: 'Success!',
                text: '$message',
                type: 'success'
            }).then(function() {
              window.location = 'index.php?page=project_view&project_id=$p';
            });
          });
       </script>
       ";
      }
  }
}

$stmt = $connection->prepare("SELECT * FROM actions WHERE action_id = ?");
$stmt->bind_param("i", $_GET['action_id']);
$stmt->execute();

$result = $stmt->get_result();
if($result->num_rows === 0) 
    exit('No rows');

$row = $result->fetch_array();
$stmt->close();

?>

<h1 class="h3 mb-4 text-gray-800">Add An Update to Action <b><?php echo " ".$row['action_name']; ?></b></h1>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.php?page=project_list">Back To Project List</a></li>
    <li class="breadcrumb-item"><a href="index.php?page=project_view&project_id=<?php echo $row['action_project_id'] ?>">View Project</a></li>
    <li class="breadcrumb-item active" aria-current="page">Add An Update to <?php echo $row['action_name']; ?></li>
  </ol>
</nav>

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
                  <form id="imageUploadForm">

                    <input type="hidden" name="action_id" value="<?php echo $_GET['action_id'] ?>">

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" aria-describedby="name" placeholder="Enter Name" required>
                        <small class="form-text"></small>
                    </div>
                   
                    <div id="imageUpload" class="dropzone"></div>
                    
                    <div style="margin-top: 15px;" class="form-group">
                      <button style="float: right;" id="uploaderBtn" type="button" class="btn btn-primary">Upload Files</button>
                    </div>
                  </form>   
                </div>
                  


                <div class="col-lg-8 offset-lg-2">
                  <div style="margin-top: 100px;" id="fileList">
                      <table class="table">
   
                      <?php 
                      $query = "SELECT * FROM action_files WHERE file_active = 1 AND file_action_id = {$_GET['action_id']} AND file_user_id = {$_SESSION['quatroapp_user_id']} ORDER BY file_id DESC";
                      $run = mysqli_query($connection, $query);
                      while($row_files = mysqli_fetch_array($run)):
                      ?>
                      
                        <tr>
                          <td>
                             <a><i class="fa fa-file"></i>&nbsp;<?php if($row_files['file_name'] == ''){echo "Untitled File";}else{echo $row_files['file_name'];} ?><br><?php echo $row_files['file_url'] ?></a><br><br>
                          </td>
                          <td>
                              <a href="#" class="delete-file" data-file-id="<?php echo $row_files['file_id'] ?>"><i data-toggle='tooltip' data-placement='left' title='Delete File' style='font-size: 20px; color:#b5b5b5'  class="far fa-trash-alt text-danger"></i></a>
                          </td>
                          <td>
                              <a href="<?php echo $row_files['file_url'];  ?>" download="<?php echo $row_files['file_url'];  ?>"><i data-toggle='tooltip' data-placement='left' title='Download File' style='font-size: 20px; color:#b5b5b5'  class="fa fa-download text-info"></i></a>
                          </td>
                        </tr>
                        
                      
                      <?php endwhile; ?>


                      </table>
                  </div>
                </div>

               
            </div>
        </div>

    </div>






</div>    
</form>          








