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
    #get params from GET request
    $user_id = $_GET['user_id'];
    $by_user = $_GET['by_user'];
    if($by_user){ #if events created by user
        $select_query = "SELECT event_name from event where creator_id='{$user_id}'";
        $error_m = "<p>Sorry, you haven`t created an event yet :< </p>";
    }else{ #if events NOT created by user
        $select_query = "SELECT event_name from event where not creator_id='{$user_id}'";
        $error_m = "<p>Sorry, no available events yet :< </p>";
    }

    #return html response
    $result = $connection->query($select_query);
    if($result->num_rows == 0){
        echo $error_m;
        die();
    }
    while($row = $result->fetch_assoc()){
        echo "<p>{$row['event_name']}</p>";
    }
?>