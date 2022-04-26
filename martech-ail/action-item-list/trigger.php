<?php
/**
 * @author Jose Luis Gomez Cecena
 * @link https://github.com/joseluisgomezcecena/
 * @license None
 */

require_once("settings/settings.php");
require_once("classes/Login.php");
require_once("settings/db.php");

require_once("views/includes/header.php");

require_once("classes/Trigger.php");
$trigger = new Trigger();

if (isset($trigger)) {
    if ($trigger->errors) {
        foreach ($trigger->errors as $error) {
          echo "
          <script type='text/javascript'>
            document.addEventListener('DOMContentLoaded', function(event) {
              swal('Error!','$error','error');
            });
         </script>
         ";        }
    }
    if ($trigger->messages) {
        foreach ($trigger->messages as $message) {
          $p =   implode(',',$trigger->project);
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
                  window.location = 'index.php';
              });
            });
         </script>
         ";
        }
    }
  }

?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <div style="margin-top: 50px;" id="">

                    <form method="POST" id="form-user" autocomplete="off" enctype="multipart/form-data">

                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Dropdown Card Example -->
                                <div class="card shadow mb-4">
                                  
                                    <!-- Card Body -->
                                    <div id="profile-data" class="card-body">
                                        
                                            <div class="form-group">
                                                <label>Issue</label>
                                                <input type="text" name="issue" id="" class="form-control" required>
                                            </div>


                                            <div class="form-group">
                                                <!-- Tier dropdown -->
                                                <label for="country">Tier And Plant</label>
                                                <select name="tier_id" class="form-control" id="country" required>
                                                <option value="">Select Tier and Plant</option>
                                                <?php 
                                                    $query = "SELECT DISTINCT tiers.tier_id, tier_name, tier_plant, tier_active FROM tiers LEFT JOIN tier_area ON tiers.tier_id = tier_area.tier_id WHERE tier_name LIKE '%2.0%' OR tier_name LIKE '%3.0%' ";
                                                    $result = mysqli_query($connection, $query);
                                                    while($row = mysqli_fetch_array($result)):
                                                    ?>
                                                        <option value="<?php echo $row['tier_id']; ?>"><?php echo $row['tier_name']; ?> Plant <?php echo $row['tier_plant']; ?> </option>
                                                <?php endwhile; ?>
                                                </select>
                                            </div>
                                                
                                            <div class="form-group">    
                                                <!-- Area dropdown -->
                                                <label for="country">Tier Area</label>
                                                <select name="tier_area_id" class="form-control" id="state" required>
                                                <option value="">Select Tier Area</option>
                                                </select>
                                            </div>


                                            <div class="form-group">
                                                <!-- Metric -->
                                                <label for="key_indicator_id">Impacted Indicator</label>
                                                <select name="key_indicator_id" class="form-control" id="key_indicator_id" required>
                                                <option value="">Select Key Indicator</option>
                                                <?php 
                                                    $query = "SELECT * FROM key_indicator";
                                                    $result = mysqli_query($connection, $query);
                                                    while($row = mysqli_fetch_array($result)):
                                                    ?>
                                                        <option value="<?php echo $row['key_id']; ?>"><?php echo $row['key_name']; ?></option>
                                                <?php endwhile; ?>
                                                </select>
                                            </div>

                                           


                                            
                                            <div class="form-group ">
                                                <button id="edit_profile1" name="add_trigger" type="submit" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                                                    <i class="fas fa-envelope fa-sm text-white-50"></i>&nbsp;&nbsp;Send Trigger
                                                </button>
                                            </div>

                                    
                                    </div>
                                </div>

                            </div>
                        </div>    
                    </form>          








            </div>
        </div>
    </div>
</div>

<?php require_once("views/includes/footer.php"); ?>

<script type="text/javascript">
  $(document).ready(function(){
    // Country dependent ajax
    $("#country").on("change",function(){
      //alert("hi");  
      var countryId = $(this).val();
      $.ajax({
        url :"functions/actions/selectbox/action.php",
        type:"POST",
        cache:false,
        data:{countryId:countryId},
        success:function(data){
          $("#state").html(data);
          $('#city').html('<option value="">Select city</option>');
        }
      });
    });
 
    // state dependent ajax
    $("#state").on("change", function(){
      var stateId = $(this).val();
      $.ajax({
        url :"action.php",
        type:"POST",
        cache:false,
        data:{stateId:stateId},
        success:function(data){
          $("#city").html(data);
        }
      });
    });
  });
</script>
