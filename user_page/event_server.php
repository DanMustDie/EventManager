<?php
    #setup connection to server
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
    #check if GET request was sent
    if(isset($_GET['user_id'])){
        #get params from GET request
        $user_id = $_GET['user_id'];
        $by_user = $_GET['by_user'];
        if($by_user){ #if events created by user
            $select_query = "SELECT event_name,event_id from event where creator_id='{$user_id}'";
            $error_m = "<p>Sorry, you haven`t created an event yet :< </p>";
        }else{ #if events NOT created by user
            $select_query = "SELECT event.event_name,user.first_name,user.last_name from event inner join user on event.creator_id = user.id where not creator_id='{$user_id}'";
            $error_m = "<p>Sorry, no available events yet :< </p>";
        }

        #return html response
        $result = $connection->query($select_query);
        if($result->num_rows == 0){
            echo $error_m;
            die();
        }
        while($row = $result->fetch_assoc()){
            echo $by_user ? "<li id='{$row['event_id']}'><b>{$row['event_name']}</b><button onclick=deleteEvent(event)>Delete your event</button></li>" : "<li><b>{$row['event_name']}</b> : from creator <b>{$row['first_name']} {$row['last_name']}</b></li>";
        }
    }elseif(isset($_POST['creator_id'])){ #check if POST request was sent 
        $event_name = $_POST['event_name'];
        $event_type_id = $_POST['event_type_id'];
        $date_start = $_POST['date_start'];
        $date_end = $_POST['date_end'];
        $time_start = $_POST['time_start'];
        $time_end = $_POST['time_end'];
        $entry_price = $_POST['entry_price'];
        $location = $_POST['location'];
        $description =  isset($_POST['description']) ? $_POST['description'] : NULL;
        $creator_id = $_POST['creator_id'];
        $event_id = uniqid('e');
        
        $insert_query = "INSERT INTO `event`(`event_name`, `event_type_id`, `date_start`, `date_end`, `time_start`, `time_end`, `entry_price`, `location`,`description`, `creator_id`, `event_id`) VALUES ('{$event_name}','{$event_type_id}','{$date_start}','{$date_end}','{$time_start}','{$time_end}','{$entry_price}','{$location}','{$description}','{$creator_id}','{$event_id}')";
        if($connection->query($insert_query) == TRUE){
            echo "<p>Event created succesfully :></p>";
        }else{
            echo "<p>Oops something went wrong :<</p>";
        }
    }elseif(isset($_POST['delete_id'])){
        $delete_id = $_POST['delete_id'];
        $delete_query = "DELETE from `event` where event_id='{$delete_id}'";
        $connection->query($delete_query); 
    }
    
?>