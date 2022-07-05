<?php
    $db_host = "localhost";
    $db_name = "my_blog";
    $db_user = "root";
    $db_pass = "";
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    if (!$conn) {
        echo "Website is down";
        exit;
    }
    
    function change_date($date) {
        $new_date = explode('-', explode(' ', $date)[0]);
        $time = explode(':', explode(' ', $date)[1]);
        return $time[0].":".$time[1]." ".implode('/', array_reverse($new_date));
    }

?>