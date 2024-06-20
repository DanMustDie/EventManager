<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='./user.css'/>
    <title>User page</title>
</head>
<body>
    <?php
        $db_server = 'localhost';
        $db_uname = 'root';
        $db_upass = '';
        $db_name = 'eventmanager';
        $connection = new mysqli($db_server,$db_uname,$db_upass,$db_name);
        if(!$connection){
            echo "Connection to db was successfull";
        }
        if(!$_SESSION['email'] | !$_SESSION['password']){
            echo "<h2 style='color:red;'>Error no log-in information provided Go back to <a href='http://{$_SERVER['HTTP_HOST']}/EventManager/main_page/main.php?option=log-in'>log in</a></h2>";
        }
        $form_email = $_SESSION['email'];
        $form_pass = $_SESSION['password'];
        $query = "SELECT * from user where email_addr='{$form_email}';";
        $result = $connection->query($query);
        if($result->num_rows > 0){
            $user = $result->fetch_assoc();
            $_SESSION['user_id'] = $user['id'];
            echo "<h2 id='welcome'>- Welcome, dear {$user['first_name']}</h2>";
        }else{
            header('Location: http://'.$_SERVER['HTTP_HOST'].'/main_page/main.php');
        }
    ?>
    <script>
        function showCreated(by_user){
            let xml_request = new XMLHttpRequest()
            xml_request.onreadystatechange = function(){
                if(this.readyState==4 && this.status == 200){
                    document.getElementById('created-events').innerHTML = this.responseText
                }
            };

            xml_request.open("GET",'./event_server.php?user_id='+'<?= $_SESSION['user_id']?>'+'&'+'by_user='+ by_user,true)
            xml_request.send()
        }

        function deleteEvent(event){
            let delete_id = event.target.parentNode.id
            let xml_request = new XMLHttpRequest()
            let data = 'delete_id='+delete_id
            xml_request.onreadystatechange = function (){
                if(this.readyState == 4 && this.status == 200){
                    showCreated(1)
                }
            }
            xml_request.open('POST','./event_server.php')
            xml_request.setRequestHeader('Content-type','application/x-www-form-urlencoded')
            xml_request.send(data)
        }

        function generateTicket(event){
            let user_id = '<?= $_SESSION['user_id']?>'
            let event_id = event.target.parentNode.id
            let xml_request = new XMLHttpRequest()
            let data = 'event_id='+event_id +'&'+'guest_id='+user_id  
            xml_request.onreadystatechange = function (){
                if(this.readyState == 4 && this.status == 200){
                    showTickets();
                }
            }
            xml_request.open('POST','./ticket_server.php')
            xml_request.setRequestHeader('Content-type','application/x-www-form-urlencoded')
            xml_request.send(data)
        }

        function showTickets(){
            let user_id = '<?= $_SESSION['user_id']?>';
            let xml_request = new XMLHttpRequest()
            let data = 'guest_id='+user_id
            let tickets = document.getElementById('tickets')
            xml_request.onreadystatechange = function (){
                if(this.readyState == 4 && this.status == 200){
                    tickets.innerHTML = this.responseText
                }
            }
            xml_request.open('POST','./ticket_server.php')
            xml_request.setRequestHeader('Content-type','application/x-www-form-urlencoded')
            xml_request.send(data)
        }

        function returnTicket(event){
            let ticket_id = event.target.parentNode.id
            let xml_request = new XMLHttpRequest()
            xml_request.onreadystatechange = function (){
                if(this.readyState == 4 && this.status == 200){
                    document.getElementById('server-response').innerText = this.responseText;
                    showTickets();
                }
            }
            xml_request.open('POST','./ticket_server.php')
            xml_request.setRequestHeader('Content-type','application/x-www-form-urlencoded')
            xml_request.send('ticket_id='+ticket_id)
        }
        function showGuests(event){
            let id = event.target.parentNode.id
            let xml_request = new XMLHttpRequest()
            xml_request.onreadystatechange = function (){
                if(this.readyState == 4 && this.status == 200){
                    document.getElementById('server-response').innerHTML = this.responseText;
                }
            }
            xml_request.open('POST','./guests_server.php')
            xml_request.setRequestHeader('Content-type','application/x-www-form-urlencoded')
            console.log(event.target.parentNode.className)
            xml_request.send(event.target.parentNode.className+'_id' + '=' + id)
        }
    </script>
    <nav>
        <button onclick=showCreated(1)>Show created events</button>
        <button onclick=showCreated(0)>Show available events</button>
        <a href='./create_event.php'><button>Create your event</button></a>
        <a href='http://<?=$_SERVER['HTTP_HOST']?>/EventManager/main_page/main.php'><button>Back to main page</button></a>
    </nav>
    <div id='main-content'>
        <div>
            <span>List of events:</span>
            <ol id='created-events'></ol>
        </div>
        <div>
            <span>Your booked tickets:</span>
            <ul id='tickets'>
            </ul>
        </div>
    </div>
    <span id='server-response'></span>
    <script>
        showTickets();
        showCreated(0);
    </script>
</body>
</html>