<?php
    $db_server = 'localhost';
    $db_uname = 'root';
    $db_upass = '';
    $db_name = 'eventmanager';
    $connection = new mysqli($db_server,$db_uname,$db_upass,$db_name);
    if(!$connection){
        echo "Connection to db was successfull";
    }

    $user_id = $_GET['user_id'];
    $select_query = "SELECT event_name from event where creator_id='{$user_id}'";
    $result = $connection->query($select_query);
    if($result->num_rows == 0){
        echo "<p>Sorry, you haven`t created an event yet :< </p>";
        die();
    }
    while($row = $result->fetch_assoc()){
        echo "<p>{$row['event_name']}</p>";
    }

    $connection->close();
?>