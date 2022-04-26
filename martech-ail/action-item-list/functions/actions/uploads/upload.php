<?php
require_once("../../../settings/db.php");
session_start();
global $connection;

$action_id = $_GET['action_id'];
$user = $_SESSION['quatroapp_user_id'];

$target_dir = "../../../uploads/actions/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image


// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["file"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "png" && $imageFileType != "PNG" 
&& $imageFileType != "jpeg" && $imageFileType != "JPEG" && $imageFileType != "gif" && $imageFileType != "GIF" 
&& $imageFileType != "docx" && $imageFileType != "doc" && $imageFileType != "xlsx" && $imageFileType != "xls"
&& $imageFileType != "csv" && $imageFileType != "xlsm" && $imageFileType != "pdf" && $imageFileType != "PDF"
&& $imageFileType != "ppt" && $imageFileType != "pptx" && $imageFileType != "PPTX" && $imageFileType != "PPT") {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
    //echo "The file ". htmlspecialchars( basename( $_FILES["file"]["name"])). " has been uploaded.";
    $insert_file = "INSERT INTO action_files (file_action_id, file_user_id, file_name, file_url ) VALUES ($action_id, $user, '$target_file', '$target_file')";
    $result = mysqli_query($connection, $insert_file);
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}