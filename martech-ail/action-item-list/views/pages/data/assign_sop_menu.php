<?php 
if($_SESSION['ojt_user_level'] == 0)
{
    die("You dont have permission to access this page <a href='index.php'>Go Back</a>");
}
?>
<h1 class="h3 mb-4 text-gray-800">Add SOP's to operations</span></h1>

<form method="POST" id="form-user" autocomplete="off" enctype="multipart/form-data">

<div class="row">


    <div class="col-lg-12">
        <!-- Dropdown Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        
                <h6 class="m-0 font-weight-bold text-default">Operations List</h6>
                        
                <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Options:</div>
                        <a class="dropdown-item" href="index.php?page=trained">Go to trained personnel</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Refresh</a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body ">
                <div class="card-body ">
                   

                <div style="margin-top:-20px;" class="table-responsive">
                    <table  style="font-size: 14px; vertical-align:middle; " class="table  table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cell</th>
                            <th>Operation</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $query = "SELECT * FROM ops LEFT JOIN cells ON ops.cell_id = cells.cell_id 
                                WHERE ops.op_active = 1 AND cells.cell_active = 1";
                                $result = mysqli_query($connection, $query);
                                while($row = mysqli_fetch_array($result)):
                            ?>
                                <tr>
                                    <td><?php echo $row['op_id'] ?></td>
                                    <td><?php echo $row['cell_name'] ?></td>
                                    <td><?php echo $row['op_name'] ?></td>
                                    <td><a href="index.php?page=assign_sop&op_id=<?php echo $row['op_id'] ?>"><i data-toggle='tooltip' data-placement='left' title='Add SOP to <?php echo $row['op_name'] ?>' style='font-size: 28px; color:#b5b5b5' class='far fa-plus-square options'></i></a></td>
                                </tr>
                            <?php 
                                endwhile;
                            ?>
                        </tbody>
                    </table>
                </div>


                </div>
            </div>
        </div>

    </div>



   
</div>    
</form>          








