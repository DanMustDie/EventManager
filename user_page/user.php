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
        $query = 'SELECT * from user where email_addr=\''.$form_email.'\' and password=\''.$form_pass.'\';';
        $result = $connection->query($query);
        if($result->num_rows > 0){
            $user_row = $result->fetch_assoc()
            ?><h2>Welcome, dear <?= $user_row['first_name']?>!</h2><?php
        }else{
            ?><h2 style='color:rgb(255,0,0);'>Error: incorrect e-mail or password. <a href='../login_page/login.php'>Try again</a> or <a href='../signup_page/signup.php'> create an account</a></h2><?php
            die();
        }
    ?>
</body>
</html>