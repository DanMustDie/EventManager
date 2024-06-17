<?php
    #setup connection to database server
    $db_server = 'localhost';
    $db_uname = 'root';
    $db_upass = '';
    $db_name = 'eventmanager';
    $connection = new mysqli($db_server,$db_uname,$db_upass,$db_name);
    if(!$connection){
        echo "Connection to db was successfull";
    }
?>
<?php
    #get params from POST request
    $event_name = $_POST['event_name'];
    $event_type = $_POST['event_type'];
    $date_start = $_POST['date_start'];
    $date_end = $_POST['date_end'];
    $time_start = $_POST['time_start'];
    $time_end = $_POST['time_end'];
    $entry_price = $_POST['entry_price'];
    $location = $_POST['location'];
    $description =  $_POST['description'];
    $creator_id = $_POST['creator_id'];
    $event_id = uniqid('e');
 
    #create query
    $insert_query = "INSERT INTO `event`(`event_name`, `event_type`, `date_start`, `date_end`, `time_start`, `time_end`, `entry_price`, `location`, `description`, `creator_id`, `event_id`) 
    VALUES ('{$event_name}','{$event_type}','{$date_start}','{$date_end}','{$time_start}','{$time_end}','{$entry_price}','{$location}','{$description}','{$creator_id}','{$event_id}')
    "
    if($connection->query($insert_query) == TRUE){
        echo "<p>Event created succesfully :></p>"
    }else{
        echo "<p>Oops something went wrong :<</p>"
    }
?>