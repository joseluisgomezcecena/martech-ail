<?php
require_once("../../settings/db.php");
session_start();

global $connection;

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value

## Search 
$searchQuery = " ";
if($searchValue != ''){
        $searchQuery = " and (machine_name like '%".$searchValue."%' or 
        machine_control_number like '%".$searchValue."%' or andon_machine_categories.machine_cat_name like '%".$searchValue."%' ) ";
}
//
## Total number of records without filtering
$sel = mysqli_query($connection,"select count(*) as allcount from andon_machine WHERE machine_active = 1 ");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of record with filtering
$sel = mysqli_query($connection,"select count(*) as allcount from andon_machine
LEFT JOIN andon_site ON andon_machine.machine_site_id = andon_site.site_id
LEFT JOIN andon_area ON andon_machine.machine_area_id = andon_area.area_id
LEFT JOIN andon_machine_categories ON andon_machine.machine_category_id = andon_machine_categories.machine_cat_id  
WHERE machine_active = 1 ".$searchQuery);

/*
echo "select count(*) as allcount from andon_machine
LEFT JOIN andon_site ON andon_machine.machine_site_id = andon_site.site_id
LEFT JOIN andon_area ON andon_machine.machine_area_id = andon_area.area_id
LEFT JOIN andon_machine_categories ON andon_machine.machine_category_id = andon_machine_categories.machine_cat_id  
WHERE machine_active = 1 ".$searchQuery;
*/

$records = mysqli_fetch_array($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "select * from andon_machine 
LEFT JOIN andon_site ON andon_machine.machine_site_id = andon_site.site_id
LEFT JOIN andon_area ON andon_machine.machine_area_id = andon_area.area_id
LEFT JOIN andon_machine_categories ON andon_machine.machine_category_id = andon_machine_categories.machine_cat_id 
WHERE machine_active =  1  ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
$empRecords = mysqli_query($connection, $empQuery);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {

    ##other querys
    
    #data-toggle='modal' data-target='#exampleModal'

    ##other querys

$data[] = array( 
    "machine_id"=>$row['machine_id'],
    "machine_category"=>$row['machine_cat_name'],
    "machine_name"=>$row['machine_name'],
    "machine_control_number"=>$row['machine_control_number'],
    "machine_site"=>$row['site_name'],
    "machine_area"=>$row['area_name'],
    "machine_actions"=> "
    <a href='index.php?page=machine_view&machine={$row['machine_id']}' class=''  data-cat-name='{$row['machine_name']}' data-cat-id='{$row['machine_id']}' ><i data-toggle='tooltip' data-placement='left' title='Edit category' style='font-size: 20px; color:#b5b5b5' class='far fa-eye options'></i></a>
    &nbsp;&nbsp;
    <a href='index.php?page=machine_update&machine={$row['machine_id']}'  class=''  data-cat-name='{$row['machine_name']}' data-cat-id='{$row['machine_id']}'><i data-toggle='tooltip' data-placement='left' title='Edit category' style='font-size: 20px; color:#b5b5b5' class='far fa-edit options'></i></a>
    &nbsp;&nbsp;
    <a href='index.php?page=machine_delete&machine={$row['machine_id']}' class='' data-cat-name='{$row['machine_name']}' data-cat-id='{$row['machine_id']}'><i data-toggle='tooltip' data-placement='left' title='Delete category' style='font-size: 20px; color:#b5b5b5' class='far fa-trash-alt options'></i></a>"
);
}

## Response
$response = array(
"draw" => intval($draw),
"iTotalRecords" => $totalRecords,
"iTotalDisplayRecords" => $totalRecordwithFilter,
"aaData" => $data
);

echo json_encode($response);


?>