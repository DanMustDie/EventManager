<?php
    #This functions as a .php server that displays current created/not-created-by-user-events
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
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        #get params from GET request
        $user_id = $_GET['user_id'];
        $by_user = $_GET['by_user'];
        if($by_user){ #if events created by user
            $select_query = "SELECT event_name,event_id from event where creator_id='{$user_id}'";
            $error_m = "<p>Sorry, you haven`t created an event yet :< </p>";
        }else{ #if events NOT created by user
            $select_query = "SELECT event.event_name,user.first_name,user.last_name,event.event_id,event.max_guests,event.description from event inner join user on event.creator_id = user.id where not creator_id='{$user_id}'";
            $error_m = "<p>Sorry, no available events yet :< </p>";
        }

        #return html response
        $result = $connection->query($select_query);
        if($result->num_rows == 0){
            echo $error_m;
            die();
        }
        while($row = $result->fetch_assoc()){
            if($by_user){
                echo "<li class='event' id='{$row['event_id']}'><span><b>{$row['event_name']}</b></span><button onclick=deleteEvent(event)>Delete your event</button><button onclick=showGuests(event)> Show guests</button></li>";
            }else{
                $at_query = "SELECT count(*) as `count` from `event` inner join `ticket` on `event`.event_id = `ticket`.event_id where `ticket`.event_id='{$row['event_id']}' group by `ticket`.event_id;";
                $at_res = $connection->query($at_query);
                $at_row = $at_res->fetch_assoc();
                if(isset($at_row)){
                    $count = $at_row['count'];
                }else{
                    $count = 0;
                }
                $at = $row['max_guests'] - $count;
                
                echo "<li class='event' id='{$row['event_id']}'>".
                        "<span>".
                            "<b>{$row['event_name']}</b> :from creator <b>{$row['first_name']} {$row['last_name']}</b>".
                            "</span><span>Available tickets: $at</span>".
                            "<span>Description: <br/> ".(isset($row['description']) ? $row['description'] : 'no description')."</span>".
                            "<button onclick='generateTicket(event)'>Order ticket</button>".
                            "<button onclick=showGuests(event)>Show guests</button></li>";
            }
        }
    }else{
        $delete_id = $_POST['delete_id'];
        $delete_event_query = "DELETE from `event` where event_id='{$delete_id}'";
        $delete_tickets_query = "DELETE from `ticket` where event_id='{$delete_id}'";
        $connection->query($delete_tickets_query); 
        $connection->query($delete_event_query);
        

    }
    
?>