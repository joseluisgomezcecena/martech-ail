<?php
require_once("settings/db.php");
require_once("settings/settings.php");

global $connection;

$location = "http://mxmtsvrandon1/tracker/martech-ail/action-item-list/index.php?page=ail_list";
$meeting_id = mysqli_real_escape_string($connection, $_GET['meeting_id']);

if (isset($_GET['meeting_id'])) {
    $query = "DELETE FROM ail_meeting WHERE meeting_id = $meeting_id";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("QUERY FAILED" . mysqli_error($connection));
    }

    header("Location: $location");
} else {
    header("Location: $location");
}
