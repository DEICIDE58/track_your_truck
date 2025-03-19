<?php

include 'db_connection.php';

$drivers = getDriverLocations($db);
s
echo json_encode($drivers);
?>