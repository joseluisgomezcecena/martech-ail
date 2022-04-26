<?php
require_once("../../../settings/db.php");
global $connection;
 
if (isset($_POST['countryId']) && !empty($_POST['countryId'])) {
 
 // Fetch state name base on country id
 $query = "SELECT * FROM tier_area WHERE tier_id = ".$_POST['countryId'];
 $result = $connection->query($query);
 
 if ($result->num_rows > 0) {
 echo '<option value="">Select Tier Area</option>';
 while ($row = $result->fetch_assoc()) {
 echo '<option value="'.$row['area_id'].'">'.$row['area_name'].'</option>';
 }
 } else {
 echo '<option value="">No Area Available</option>';
 }
} elseif(isset($_POST['stateId']) && !empty($_POST['stateId'])) {
 
 // Fetch city name base on state id
 $query = "SELECT * FROM cities WHERE state_id = ".$_POST['stateId'];
 $result = $connection->query($query);
 
 if ($result->num_rows > 0) {
 echo '<option value="">Select city</option>';
 while ($row = $result->fetch_assoc()) {
 echo '<option value="'.$row['id'].'">'.$row['city_name'].'</option>';
 }
 } else {
 echo '<option value="">City not available</option>';
 }
}
?>