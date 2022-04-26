<h1 class="h3 mb-4 text-gray-800">Trained Personnel</span></h1>

<form method="POST" id="form-user" autocomplete="off" enctype="multipart/form-data">

<div class="row">


    <div class="col-lg-12">
        <!-- Dropdown Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        
                <h6 class="m-0 font-weight-bold text-default">Trained Personnel List</h6>
                        
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
            <div class="card-body ">
                <div class="card-body ">
                   
                <div style="margin-bottom: 25px;" class="row">
                    <div class="col-lg-12">

                        <form method="POST" class="form-inline">
                            <label class="sr-only" for="inlineFormInputName2">Supervisor</label>
                            <select name="supervisor" class="form-control mb-2 mr-sm-2" required>
                                <option value="">Select</option>
                                <?php 
                                $sql = "SELECT DISTINCT p_supervisor FROM personnel";
                                $run = mysqli_query($connection, $sql);
                                while($super = mysqli_fetch_array($run)):
                                ?>
                                    <option><?php echo $super['p_supervisor'] ?></option>
                                <?php endwhile; ?>
                            </select>

                            

                            

                            <button type="submit" name="submit" class="btn btn-primary mb-2">Buscar</button>
                        </form>


                    </div>
                </div>

                



                <div style="margin-top:-20px;" class="table-responsive">
                    <table  style="font-size: 14px; vertical-align:middle; " class="table  table-hover" id="dataTable1" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Cell</th>
                            <th>Operation</th>
                            <th>SOP</th>
                            <th>Rev</th>
                            <th>Emp Number</th>
                            <th>Person</th>
                            <th>Supervisor</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if(isset($_POST['submit'])):
                                
                                $supervisor = $_POST['supervisor'];

                                $query = "SELECT * FROM file LEFT JOIN name_file ON file.name_id = name_file.id_file 
                                LEFT JOIN sop_operation ON name_file.name_file = sop_operation.sop_nombre 
                                LEFT JOIN ops ON ops.op_id = sop_operation.ops_id 
                                LEFT JOIN cells ON cells.cell_id = ops.cell_id 
                                LEFT JOIN personnel ON file.num_empleado = personnel.p_numero 
                                WHERE personnel.p_supervisor = '$supervisor'
                                ";
                                $result = mysqli_query($connection, $query);
                                while($row = mysqli_fetch_array($result)):
                            ?>
                                <tr>
                                    <td><?php echo $row['cell_name'] ?></td>
                                    <td><?php echo $row['op_name'] ?></td>
                                    <td><?php echo $row['name_file'] ?></td>
                                    <td><?php echo $row['rev'] ?></td>
                                    <td><?php echo $row['num_empleado'] ?></td>
                                    <td><?php echo $row['nombre'] ?></td>
                                    <td><?php echo $row['p_supervisor'] ?></td>
                                </tr>
                            <?php 
                                endwhile;
                            endif;
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








