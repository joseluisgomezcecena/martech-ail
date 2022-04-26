
<div  class="d-sm-flex align-items-center justify-content-between mb-4">
    <a href="index.php?page=project_list" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-eye fa-sm text-white-50"></i> View All Projects</a>
</div>

<div class="row">
    <?php 
    $query = "SELECT * FROM projects WHERE (project_owner = {$_SESSION['quatroapp_user_id']} OR project_support = {$_SESSION['quatroapp_user_id']}) AND project_status != 1 AND project_active = 1";
    $result = mysqli_query($connection, $query);
    while($row = mysqli_fetch_array($result)):
    ?>  
    <div class="col-lg-3">
            <div class="card shadow mb-4 ">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?php echo $row['project_name'] ?>&nbsp;&nbsp;<i data-toggle='tooltip' data-placement='right' title="<?php echo $row['project_description'] ?>" style="color: #000000;" class="fa fa-question-circle"></i></h6>
                </div>
                
                <div class="card-body">
                <!--card body-->
                <?php 
                $cont = 0;
                $query = "SELECT * FROM actions WHERE action_project_id = {$row['project_id']}";
                $run = mysqli_query($connection, $query);
                $total = mysqli_num_rows($run);
                while($rowc = mysqli_fetch_array($run))
                {
                    if($rowc['action_complete'] == 1)
                    {
                        $cont++;
                    }
                }
                if($total == 0 || $cont == 0)
                {
                    $percentage = 0;
                }
                else
                {
                    $percentage = ceil(($cont/$total)*100);
                }
                
                

                if($percentage <= 25)
                {
                    $bg = "bg-danger";
                }
                elseif($percentage > 25 && $percentage <= 75)
                {
                    $bg = "bg-warning";
                }
                elseif($percentage > 75 && $percentage <= 99)
                {
                    $bg = "bg-success";
                }
                else
                {
                    $bg = "bg-primary";
                }

                ?>
                <div data-toggle='tooltip' data-placement='top' title='<?php echo  $cont . " Of " . $total . " Tasks Completed"?>' class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated <?php echo $bg; ?>"  role="progressbar" aria-valuenow="<?php echo $percentage ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percentage ?>%"></div>
                </div>
                <i class="fa fa-clock"></i>
                <?php
                    if($row['project_status'] == 0 && date("Y-m-d") > $row['project_promise_date'])
                    {
                        echo "Late";
                    }
                    elseif($row['project_status'] == 0 && date("Y-m-d") < $row['project_promise_date'])
                    {
                        echo "On Time";
                    }
                    elseif($row['project_status'] == 1 && date("project_end_date") < $row['project_promise_date'])
                    {
                        echo "Finished On Time";
                    }
                    elseif($row['project_status'] == 1 && date("project_end_date") >= $row['project_promise_date'])
                    {
                        echo "Finished Late";
                    }
                    else
                    {
                        echo "N/A!";
                    }  
                ?>
                <br>
                <i class="fa fa-calendar"></i> Promise Date: <?php echo date_format(date_create($row['project_promise_date']), "m-d-Y"); ?>
                <br><br>
                <a href="index.php?page=project_view&project_id=<?php echo $row['project_id']; ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm btn-block"><i class="fas fa-paper-plane fa-sm text-white-50"></i> Go To Project</a>
                <!--card body-->
                </div>
        </div>
    </div>
    <?php
    endwhile;
    ?>
</div>
