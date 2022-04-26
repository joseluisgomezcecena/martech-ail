<h1 class="h3 mb-4 text-gray-800">Pending Tier Issues</h1>

<div style="margin-bottom:15px;">
    
</div>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"></h6>
    </div>
        <div class="card-body">
            <div style="margin-top:-20px;" class="table-responsive">
            <table  style="font-size: 14px; vertical-align:middle; " class="table  order-column " id="dataTableExcel" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th style="text-align: center; width:10%">Tier</th>
                    <th style="text-align: center;width:10%">Plant</th>
                    <th style="text-align: center;width:15%">Area</th>
                    <th style="text-align: left;width:40%">Issue</th>
                    <th style="text-align: center;width:20%">Impact</th>
                    <th style="width:5%;text-align: center;">Actions</th>                    
                </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM tier_triggers LEFT JOIN tiers ON tiers.tier_id = tier_triggers.trigger_tier_id LEFT JOIN key_indicator ON tier_triggers.key_indicator_id = key_indicator.key_id LEFT JOIN plants ON tiers.tier_plant = plants.plant_id LEFT JOIN tier_area AS tiername ON tiername.tier_id = tiers.tier_id LEFT JOIN tier_area AS areaname ON areaname.area_id = tier_triggers.trigger_area_id WHERE trigger_complete = 0 GROUP BY tier_triggers.trigger_id ORDER BY trigger_id DESC";
                    $result = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_array($result)):
                    ?>
                        <tr>
                            <td style="text-align: center;"><?php echo $row['tier_name']; ?></td>
                            <td style="text-align: center;"><?php echo $row['plant_name'];  ?></td>
                            <td style="text-align: center;"><?php if($row['area_name'] == ""){echo "N/A";}else{echo $row['area_name'];}  ?> <?php if($row['area_ident'] == ""){echo "N/A";}else{echo $row['area_ident'];} ?></td>
                            <td style="text-align: left;"><?php echo $row['trigger_issue']; ?></td>
                            <td style="text-align: center;"><b><?php if($row['key_name'] == ""){echo "N/A";}else{echo $row['key_name'];}  ?></b></td>

                            <td>
                                <a href='index.php?page=tier_action_add&tier_id=<?php echo $row['trigger_tier_id']?><?php if($row['trigger_area_id'] != ""){echo "&area_id={$row['trigger_area_id']}";}else{echo "";} ?>&from=pending&trigger_id=<?php echo $row['trigger_id']; ?>'  class='' ><i data-toggle='tooltip' data-placement='left' title='Accept' style='font-size: 20px; color:#b5b5b5' class='far fa-eye options'></i></a>
                            </td>

                        </tr>
                    <?php endwhile; ?>
                </tbody>                
            </table>
        </div>
    </div>
</div>




