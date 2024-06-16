<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up result</title>
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

        $form_fname = $_POST['first_name'];
        $form_lname = $_POST['last_name'];
        $form_email = $_POST['email_addr'];
        $form_pass = $_POST['password'];
        $id = uniqid();

        $select_query = "SELECT * from user where email_addr='{$form_email}' and password='{$form_pass}'";
        $insert_query = "INSERT INTO user (`first_name`, `last_name`, `email_addr`, `password`, `id`) VALUES ('{$form_fname}','{$form_lname}','{$form_email}','{$form_pass}','{$id}')";

        $select_res = $connection->query($select_query);
        if($select_res->num_rows > 0){
            ?><h2>Account already exists. Please <a href='../login_page/login.php'>log in</a></h2><?php
            die();
        }
        if($connection->query($insert_query) === TRUE){
            ?>
            <h2>Account has been created!Proceed to <a href='../login_page/login.php'>logging in</a></h2><?php
        }
    ?>
    <h3>Back to <a href='../main_page/main.php'>welcome page</a></h3>
</body>
</html>