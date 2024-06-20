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

    function ticketTemplate($tid,$en,$ds,$ts,$de,$te,$tp){
        return "<div class='ticket' id='$tid'>".
                "<h2>A ticket to '$en' event</h2>".
                "<h3>Starts on $ds and ends in $de</h3>".
                "<h4>Venue is open from $ts until $te </h4>".
                "<h4>Total entry cost: $tp $</h4>".
                "<button onclick=returnTicket(event)>Return ticket</button>".
                "<button onclick=showGuests(event)>Show guests</button>".
                "</div>";
    }

    
    
    if(!isset($_POST['ticket_id']) & isset($_POST['event_id']) & isset($_POST['guest_id'])){
        $ticket_id = uniqid('t');
        $event_id = $_POST['event_id'];
        $user_id = $_POST['guest_id'];

        $max_query = "SELECT count(*) as `count`,max_guests from `event` inner join `ticket` on `event`.event_id = `ticket`.event_id where `ticket`.event_id='{$event_id}' group by `ticket`.event_id;";
        $res = $connection->query($max_query);
        $row = $res->fetch_assoc();
        if(isset($row['count'])){
            if((int) $row['count'] + 1 > $row['max_guests']){
                echo "<p>Sorry no available tickets</p>";
                die();
            }
        }

        $check_query = "SELECT * from `ticket` where event_id='{$event_id}' and guest_id='{$user_id}'";
        $check_result = $connection->query($check_query);
        if($check_result->num_rows>0){
            echo "You already have a ticket for this event.";
            die();
        }
        $connection->query("INSERT INTO `ticket`(`guest_id`,`event_id`,`ticket_id`) values ('$user_id','$event_id','$ticket_id')");

    }elseif(isset($_POST['ticket_id']) & !isset($_POST['guest_id']) & !isset($_POST['event_id'])){
        $ticket_id = $_POST['ticket_id']; 
        $delete_query = "DELETE from `ticket` where ticket_id='$ticket_id'";
        if($connection->query($delete_query)){
            echo 'deleted successfully';
        }
    }elseif(isset($_POST['guest_id']) & !isset($_POST['ticket_id']) & !isset($_POST['event_id'])){
        $user_id = $_POST['guest_id'];
        $get_tickets_query = "SELECT * FROM `ticket` inner join `user` on `ticket`.guest_id = `user`.id inner join `event` on `ticket`.`event_id` = `event`.`event_id` where `ticket`.guest_id='$user_id'";
        $res = $connection->query($get_tickets_query);
        while($row = $res->fetch_assoc()){
            echo ticketTemplate($row['ticket_id'],$row['event_name'],$row['date_start'],substr($row['time_start'],0,5),$row['date_end'],substr($row['time_end'],0,5),$row['entry_price']);
        }
    }
    
?>