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

    $user_id = $_POST['user_id'];
    $event_id = $_POST['event_id'];
    $ticket_id = uniqid('t');

    $connection->query('INSERT INTO tickets('u_id','e_id','t_id') values('$user_id','$event_id','$ticket_id')');

    $user_query = "SELECT * FROM user WHERE id='{$user_id}'";
    $user_res = $connection->query($user_query);
    $user_row = $user_res->fetch_assoc();
    $event_query = "SELECT * FROM event inner join event_type on event.event_type_id=event_type.et_id WHERE event_id='{$event_id}'";
    $event_res = $connection->query($event_query);
    $event_row = $event_res->fetch_assoc();
    $event_creator_query = "SELECT * FROM user where id='{$event_row['creator_id']}'";
    $event_creator_res = $connection->query($event_creator_query)''
    $event_creator_row = $event_creator_res->fetch_assoc();

    $event_name = $event_row['event_name'];
    $event_type_name = $event_row['et_name'];
    $date_start = $event_row['date_start'];
    $time_start = $event_row['time_start'];
    $date_end = $event_row['date_end'];
    $time_end = $event_row['time_end'];
    $t_price = $event_row['entry_price'];

    $event_creator_fname = $event_creator_row['first_name'];
    $event_creator_lname = $event_creator_row['last_name'];
    echo "
        <div>
            <h3>A ticket to "$event_name" $et_name event</h3>
            <h2>Event created by: $event_creator_fname $event_creator_lname</h2>
            <h2>Ticket for: </h2>
            <span>Starts on $date_start / $time_start to $date_end</span>
            <span>Venue is open from $time_start until $time_end</span>
            <span>Total entry cost: $t_price</span>
            <span>
        </div>
    ";
?>