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
    <span id='creator-id-span' style='display:none;'><?= $_GET['creator_id']?></span>
    <form id='create-event-form' action="">
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
        <div><input id='create' type="button" value='Create'></div>
        <div id="server_result"></div>
    </form>
    <script>
        let create_button = document.getElementById('create')
        let res = document.getElementById('server_result')
        let url = './event_server.php'
        create_button.addEventListener('click',(event) =>{
            let inputs = document.querySelectorAll('div label+*')
            let post_data = ''
            for(let i = 0; i < inputs.length; i++){
                if(inputs[i].value != ''){
                    let str = inputs[i].id + '=' + inputs[i].value + '&'
                    post_data+=str
                }
            }
            post_data+='creator_id='+ document.getElementById('creator-id-span').innerText
            console.log(inputs[1].id + inputs[1].value)
            let xml_request = new XMLHttpRequest();
            xml_request.onreadystatechange = function () {               
                if(this.readyState == 4 && this.status == 200 ){
                    res.innerHTML = this.responseText;
                }
            };
            xml_request.open('POST',url)
            xml_request.setRequestHeader('Content-type','application/x-www-form-urlencoded')
            xml_request.send(post_data)
        } )
    </script>
</body>
</html>