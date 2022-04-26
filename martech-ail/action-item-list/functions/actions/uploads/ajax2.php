
<?php
require_once("../../../settings/db.php");
session_start();
global $connection;

$action_id = $_POST['action_id'];
$file_name = $_POST['name'];
$user = $_SESSION['quatroapp_user_id'];

/**
 * PHP Image uploader Script
 */
$uploaddir = '../../../uploads/actions/';
//$uploaddir = './uploader/';

$images = restructureArray($_FILES);
//echo '<pre>';print_r($images);echo '</pre>';exit;

$data = [];

foreach ($images as $key => $image) 
{
    $name = $image['name'];
    //add date and random string to prevent repeated filenames
    $randon_string = date("Y-m-d").rand();
    $uploadfile = $uploaddir . $randon_string . basename($name);
    if (move_uploaded_file($image['tmp_name'], $uploadfile)) 
    {
        $data[$key]['success'] = true;
        $data[$key]['src'] = $name;


        $new_url = str_replace('../../../', '', $uploadfile);
        $insert_file = "INSERT INTO tier_action_files (file_action_id, file_user_id, file_name, file_url ) 
        VALUES 
        ($action_id, $user, '$file_name', '$new_url')";

        $result = mysqli_query($connection, $insert_file);


    } 
    else
    {
        $data[$key]['success'] = false;
        $data[$key]['src'] = $name;
    }
}   

echo json_encode($data);exit;

/**
 * RestructureArray method
 * 
 * @param array $images array of images
 * 
 * @return array $result array of images
 */
function restructureArray(array $images)
{
    $result = array();
    foreach ($images as $key => $value) 
    {
        foreach ($value as $k => $val) 
        {
            for ($i = 0; $i < count($val); $i++) 
            {
                $result[$i][$k] = $val[$i];
            }
        }
    }
    return $result;
}

