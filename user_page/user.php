<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='user.css'/>
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

        $form_email = $_POST['email_addr'];
        $form_pass = $_POST['password'];
        $query = "SELECT * from user where email_addr='{$form_email}' and password='{$form_pass}';";
        $result = $connection->query($query);
        if($result->num_rows > 0){
            $user = $result->fetch_assoc()
            ?><h2>Welcome, dear <?= $user['first_name']?>! Your user id is <span id='user-id'><?= $user['id']?></span></h2><?php
        }else{
            ?><h2 style='color:rgb(255,0,0);'>Error: incorrect e-mail or password. <a href='../login_page/login.php'>Try again</a> or <a href='../signup_page/signup.php'> create an account</a></h2><?php
            ?><?= $query?><?php
            die();
        }
    ?>
    <script>
        function showCreated(by_user){
            let user_id = document.getElementById('user-id').innerHTML;
            let xml_request = new XMLHttpRequest();
            xml_request.onreadystatechange = function(){
                if(this.readyState==4 && this.status == 200){
                    document.getElementById('button-res').innerHTML = this.responseText;
                }
            };
            xml_request.open("GET",'./event_handler.php?user_id='+user_id+'&'+'by_user='+ by_user,true);
            xml_request.send();
        }
    </script>
    <div><button onclick=showCreated(true)>Show created events</button><button onclick=showCreated(false)>Show available events</button> <a targer="_blank" href='./create_event.html'><button>Create your event!</button></a> </div>
    <div id='button-res'>

    </div>
</body>
</html>