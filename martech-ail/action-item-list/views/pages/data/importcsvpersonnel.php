<?php 
if($_SESSION['ojt_user_level'] == 0)
{
    die("You dont have permission to access this page <a href='index.php'>Go Back</a>");
}
importCsvPersonnel();
?>

<h1 class="h3 mb-4 text-gray-800">Import Personnel Data </h1>

<div style="margin-bottom:15px;">
</div>

<div class="row">

    <div class="col-lg-4">
        <!-- Dropdown Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        
                <h6 class="m-0 font-weight-bold text-default">Choose Personnel File</h6>
                        
                <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Options:</div>
                        <a class="dropdown-item" href="index.php?page=trained">Go to trained personnel</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="index.php?page=importcsv">Refresh</a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body text-center">
                <div class="card-body text-center">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <input type='file' name="file[]" accept=".csv" multiple />
                        </div>
                        <div class="form-group right">
                            <input class="btn btn-primary" type="submit" name="submit_file" value="Import CSV">
                        </div>
                    </form>
                </div>
            </div>
            <!-- Card Body -->
        </div>

    </div>



    <div class="col-lg-8">
        <!-- Dropdown Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        
                <h6 class="m-0 font-weight-bold text-default">Personnel Info</h6>
                        
                <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Options:</div>
                        <a class="dropdown-item" href="index.php?page=trained">Go to trained personnel</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="index.php?page=importcsv">Refresh</a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div id="profile-data" class="card-body">
                <div style="margin-top:-20px;" class="table-responsive">
                    <table  style="font-size: 14px; vertical-align:middle; " class="table  table-hover" id="dataTable1" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Numero de empleado</th>
                            <th>Nombre</th>
                            <th>Departamento</th>
                            <th>Supervisor</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $query = "SELECT * FROM  personnel";
                                $result = mysqli_query($connection, $query);
                                while($row = mysqli_fetch_array($result)):
                            ?>
                                <tr>
                                    <td><?php echo $row['p_numero'] ?></td>
                                    <td><?php echo $row['p_nombre'] ?></td>
                                    <td><?php echo $row['p_departamento'] ?></td>
                                    <td><?php echo $row['p_supervisor'] ?></td>
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

