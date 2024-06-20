<?php
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
    if(!isset($_POST['event_id'])){
        $ticket = $connection->query("SELECT event_id from `ticket` where ticket_id = '{$_POST['ticket_id']}'");
        $ticket_row = $ticket->fetch_assoc();
        $event_id = $ticket_row['event_id'];
    }else{
        $event_id = $_POST['event_id'];
    }
    $select_guest = "SELECT first_name,last_name from `ticket` inner join `user` on `user`.id = `ticket`.guest_id inner join `event` on `event`.event_id = `ticket`.event_id where `ticket`.event_id = '$event_id'";
        $res = $connection->query($select_guest);
        echo "<p>List of guests: </p>";
        echo "<ul>";
        while($row = $res->fetch_assoc()){
            echo "<li>{$row['first_name']} {$row['last_name']}</li>";
        }
        echo "</ul>";
?>