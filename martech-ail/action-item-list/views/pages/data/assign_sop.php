<?php
if($_SESSION['ojt_user_level'] == 0)
{
    die("You dont have permission to access this page <a href='index.php'>Go Back</a>");
}
addSop();
removeSop();

$query = "SELECT * FROM ops WHERE op_id = {$_GET['op_id']}";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_array($result);

?>

<h1 class="h3 mb-4 text-gray-800">Add SOP's to: <span class="text-primary"><?php echo $row['op_name']; ?></span></h1>

<form method="POST" id="form-user" autocomplete="off" enctype="multipart/form-data">

<div class="row">






<div class="col-lg-6">
        <!-- Dropdown Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        
                <h6 class="m-0 font-weight-bold text-default">Available SOPs</h6>
                        
                <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Options:</div>
                        <a class="dropdown-item" href="index.php?page=trained">Go to trained personnel</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="index.php?page=assign_sop">Refresh</a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div id="profile-data" class="card-body">
                
                    <div style="margin-top:-20px;" class="table-responsive">
                        <table  style="font-size: 14px; vertical-align:middle; " class="table  table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Operation</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $query = "SELECT * FROM name_file";
                                    $result = mysqli_query($connection, $query);
                                    while($row = mysqli_fetch_array($result)):
                                ?>
                                    <tr>
                                        <td><?php echo $row['name_file'] ?></td>
                                        <td>
                                            <form method="POST">
                                                <input type="hidden" name="sop_id" value="<?php echo $row['id_file'] ?>">
                                                <input type="hidden" name="sop_name" value="<?php echo $row['name_file'] ?>">
                                                <button class="btn btn-primary" type="submit" name="add_sop">Add SOP</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php 
                                    endwhile;
                                ?>
                            </tbody>
                        </table>
                    </div>



            </div>
            <!-- Card Body -->
        </div>

    </div>





    <div class="col-lg-6">
        <!-- Dropdown Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        
                <h6 class="m-0 font-weight-bold text-default">Registered SOPs to Operation</h6>
                        
                <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Options:</div>
                        <a class="dropdown-item" href="index.php?page=trained">Go to trained personnel</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="index.php?page=assign_sop">Refresh</a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div id="profile-data" class="card-body">

                <div style="margin-top:-20px;" class="table-responsive">
                    <table  style="font-size: 14px; vertical-align:middle; " class="table  table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Operation</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $query = "SELECT * FROM sop_operation WHERE ops_id = {$_GET['op_id']}";
                                $result = mysqli_query($connection, $query);
                                while($row = mysqli_fetch_array($result)):
                            ?>
                                <tr>
                                    <td><?php echo $row['sop_nombre']; ?></td>
                                    <td>
                                        <form method="POST">
                                            <input type="hidden" name="so_id" value="<?php echo $row['so_id'] ?>">
                                            <button class="btn btn-danger" type="submit" name="remove_sop">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php 
                                endwhile;
                            ?>
                        </tbody>
                    </table>
                </div>                
            </div>
            <!-- Card Body -->
        </div>

    </div>











   
</div>    
</form>          








