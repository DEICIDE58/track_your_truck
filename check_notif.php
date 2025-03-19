<?php
if (file_exists('notification.txt')) {
    $message = file_get_contents('notification.txt');
    echo json_encode(["message" => $message]);
} else {
    echo json_encode(["message" => ""]);
}
?>
