<?php
    session_start();
    
    #setup connection to server
    $db_server = 'localhost';
    $db_uname = 'root';
    $db_upass = '';
    $db_name = 'eventmanager';
    $connection = new mysqli($db_server,$db_uname,$db_upass,$db_name);
    if(!$connection){
        echo "Connection to db was successfull";
    }

    $select_query='select * from event_type';
    $result = $connection->query($select_query);  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event creating page</title>
</head>
<body>
    <form id='create-event-form' action="" method='POST'>
        <div>
            <label for="event_name">Event name: </label>
            <input id="event_name" name="event_name" type='text' value='EName' required/>
        </div>
        <div>
            <label for="event_type_id">Event type: </label>
            <select form='create-event-form' id='event_type_id' name='event_type_id'>
                <?php
                    while($row = $result->fetch_assoc()){
                        echo "<option value='{$row['et_id']}'>{$row['et_name']}</option>";
                    }
                ?>
            </select>
        </div>
        <div>
            <label for="date_start">Start date: </label>
            <input id='date_start' name='date_start' type='date' value='2024-01-01' required/>
        </div>
        <div>
            <label for="date_end">End date: </label>
            <input id='date_end' name='date_end' type='date' value='2024-01-01' required/>
        </div>
        <div>
            <label for="time_start">Starting time: </label>
            <input id='time_start' name='time_start' value='11:00' type='time' required/>
        </div>
        <div>
            <label for="time_end">Ending time: </label>
            <input id='time_end' name='time_end' type='time' value='12:00' required/>
        </div>
        <div>
            <label for="entry_price">Ticket price: </label>
            <input id='entry_price' name='entry_price' value='12.24' type='text' required/>$
        </div>
        <div>
            <label for="location">Location: </label>
            <input id='location' name='location' type='text' value='somewhere' required/>
        </div>
        <div>
            <label for="description">Event description: </label>
            <textarea id="description" name="description"></textarea>
        </div>
        <div><input id='create' type="submit" value='Create'></div>
    </form>
    <?php
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $event_name = $_POST['event_name'];
            $event_type_id = $_POST['event_type_id'];
            $date_start = $_POST['date_start'];
            $date_end = $_POST['date_end'];
            $time_start = $_POST['time_start'];
            $time_end = $_POST['time_end'];
            $entry_price = $_POST['entry_price'];
            $location = $_POST['location'];
            $description =  isset($_POST['description']) ? $_POST['description'] : NULL;
            $creator_id = $_SESSION['creator_id'];
            $event_id = uniqid('e');
            $insert_stmt = $connection->prepare("INSERT INTO `event`(`event_name`, `event_type_id`, `date_start`, `date_end`, `time_start`, `time_end`, `entry_price`, `location`,`description`, `creator_id`, `event_id`) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
            $insert_stmt->bind_param("sisssssssss",$event_name,$event_type_id,$date_start,$date_end,$time_start,$time_end,$entry_price,$location,$description,$creator_id,$event_id);
            if($insert_stmt->execute()){
                echo 'Event created successfully! Go back to <a href="./user.php">user page</a>';
            }else{
                echo 'An unknown error has occured.';
            }
        }       
    ?>
</body>
</html>