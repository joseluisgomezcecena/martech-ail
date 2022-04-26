<h1 class="h3 mb-4 text-gray-800">Tiers</h1>

<div style="margin-bottom:15px;">
    
</div>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"></h6>
    </div>
        <div class="card-body">
            <div style="margin-top:-20px;" class="table-responsive">
            <table  style="font-size: 14px; vertical-align:middle; " class="table  order-column " id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th style="text-align: center;">Tier</th>
                    <th style="text-align: center;">Plant</th>
                    <th style="text-align: center;">Area</th>
                    <th style="text-align: center;">Area ID</th>
                    <th style="width: 100px;text-align: center;">Status</th>
                    <th style="width: 100px;text-align: center;">Actions</th>
                    <th style="width: 100px;text-align: center;">Options</th>
                    
                </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM tiers 
                    LEFT JOIN plants ON tiers.tier_plant = plants.plant_id 
                    LEFT JOIN tier_area ON tier_area.tier_id = tiers.tier_id 
                    WHERE tier_active = 1 ";
                    

                    $result = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_array($result)):
                    ?>
                        <tr>
                            <td style="text-align: center;"><?php echo $row['tier_name']; ?></td>
                            <td style="text-align: center;"><?php echo $row['plant_name'];  ?></td>
                            <td style="text-align: center;"><?php if($row['area_name'] == ""){echo "N/A";}else{echo $row['area_name'];}  ?></td>
                            <td style="text-align: center;"><?php if($row['area_ident'] == ""){echo "N/A";}else{echo $row['area_ident'];} ?></td>
                            




                            <td style="text-align: center;">
                                <?php
                                $cont = 0;
                                if($row['area_id'] != NULL)
                                {
                                    $query = "SELECT * FROM tier_actions WHERE action_tier_id = {$row[0]} AND action_tier_area = {$row['area_id']} ";
                                }
                                else
                                {
                                    $query = "SELECT * FROM tier_actions WHERE action_tier_id = {$row[0]} ";
                                }
                                
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
                                <div data-toggle='tooltip' data-placement='left' title='<?php echo  $cont . " Of " . $total . " Tasks Completed"?>' class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated <?php echo $bg; ?>"  role="progressbar" aria-valuenow="<?php echo $percentage ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percentage ?>%"></div>
                                </div>
                            </td>
 
                            <td class="text-center">
                                <?php echo $total; ?>
                            </td>







                            <td>
                                <a href='index.php?page=tier_view&tier_id=<?php echo $row[0]?><?php if($row['area_id'] != ""){echo "&area_id={$row['area_id']}";}else{echo "";} ?>'  class='' ><i data-toggle='tooltip' data-placement='left' title='View Actions' style='font-size: 20px; color:#b5b5b5' class='far fa-eye options'></i></a>

                                <?php
                                /* 
                                if($_SESSION['quatroapp_user_level'] >= 1):
                                ?>
                                <a href='index.php?page=tier_edit&tier_id=<?php echo $row['tier_id']?>'  class=''  data-cat-name='{$row['user_name']}' data-cat-id='{$row['user_id']}'><i data-toggle='tooltip' data-placement='left' title='Edit Project' style='font-size: 20px; color:#b5b5b5' class='far fa-edit options'></i></a>
                                <a href='index.php?page=tier_delete&tier_id=<?php echo $row['tier_id']?>'  class=''  data-cat-name='{$row['user_name']}' data-cat-id='{$row['user_id']}'><i data-toggle='tooltip' data-placement='left' title='Delete Project' style='font-size: 20px; color:#b5b5b5' class='far fa-trash-alt options'></i></a>
                                <?php 
                                endif;
                                */
                                ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>                
            </table>
        </div>
    </div>
</div>




