<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event creating page</title>
</head>
<body>
    <span id='creator-id-span'><?= $_GET['creator_id']?></span>
    <form action="">
        <div><label for="event_name">Event name: </label><input  id="event_name" name="event_name" type='text' required/></div>
        <div><label for="event_type">Event type: </label><input id='event_type' name='event_type' type='text' required/></div>
        <div><label for="date_start">Start date: </label><input id='date_start' name='date_start' type='date' required/></div>
        <div><label for="date_end">End date: </label><input id='date_end' name='date_end' type='date' required/></div>
        <div><label for="time_start">Starting time: </label><input id='time_start' name='time_start' type='time' required/></div>
        <div><label for="time_end">Ending time: </label><input id='time_end' name='time_end' type='time' required/></div>
        <div><label for="entry_price">Ticket price: </label><input id='entry_price' name='entry_price' type='text' required/>$</div>
        <div><label for="location">Location: </label><input id='location' name='location' type='text' required/></div>
        <div><label for="description">Event description: </label><textarea id="description" name="description"></textarea></div>
        <div><input id='create' type="button"></div>
        <div id="server_result"></div>
    </form>
    <script>
        let create_button = document.getElementById('create')
        let res = document.getElementById('server_result')
        let url = './event_creator.php'
        create_button.addEventListener('click',(event) =>{
            let inputs = document.querySelectorAll('div label+*')
            let post_data = ''

            console.log(inputs)
            for(let i = 0; i < inputs.length; i++){
                if(inputs[i].value != ''){
                    let str = inputs[i].id + '=' + inputs[i].value + '&'
                    post_data+=str
                }
            }
            post_data+='creator_id='+ document.getElementById('creator-id-span').innerText

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