<?php
    session_start();
    $error_m = '';
    $db_server = 'localhost';
    $db_uname = 'root';
    $db_upass = '';
    $db_name = 'eventmanager';
    $connection = new mysqli($db_server,$db_uname,$db_upass,$db_name);
    if(!$connection){
        echo "No connection to db";
        die();
    }
    
    if(!isset($_GET['option'])){
        $_GET['option'] = 'sign-up';
    }
    if(isset($_POST['option'])){
        $form_fname = $_POST['option'] == 'sign-up' ? $_POST['first_name'] : '';
        $form_lname = $_POST['option'] == 'sign-up' ? $_POST['last_name'] : '';
        $form_email = $_POST['email_addr'];
        $form_pass = $_POST['password'];
        $form_pass_hash = password_hash($form_pass,PASSWORD_BCRYPT);
        $id = uniqid('a');
        
        
        $select_query = "SELECT * FROM user WHERE email_addr='{$form_email}'";
        $insert_stm = $connection->prepare("INSERT into user (`first_name`,`last_name`,`email_addr`,`password`,`id`) values (?,?,?,?,?)");
        $insert_stm->bind_param('sssss',$form_fname,$form_lname,$form_email,$form_pass_hash,$id);
        $select_result = $connection->query($select_query);
        $user = $select_result->fetch_assoc();

        $select_result = $connection->query($select_query);
        $user = $select_result->fetch_assoc();
        $_SESSION['user_id'] = isset($user['id']) ? $user['id'] : '';
        $_SESSION['email'] = $form_email;
        $_SESSION['password'] = $form_pass;
        

        if($_POST['option'] == 'sign-up'){
            if($select_result->num_rows > 0){
                $error_m = "Account already exists. <br/> Please log in into existing account.";
            }else{
                if($insert_stm->execute()){
                    $select_result = $connection->query($select_query);
                    $user = $select_result->fetch_assoc();
                    $_SESSION['user_id'] = $user['id'] ? $user['id'] : '';
                    $_SESSION['email'] = $user['email_addr'] ? $user['email_addr'] : '';
                    $_SESSION['password'] = $form_pass ? $form_pass : '';
                    header('Location: http://'.$_SERVER['HTTP_HOST'].'/EventManager/user_page/user.php');
                    success($connection,$select_query);
                }else{
                    $error_m =  'Database error.';
                }
            }
        }else{
            if($select_result->num_rows > 0){
                if(password_verify($form_pass,$user['password'])){
                    header('Location: http://'.$_SERVER['HTTP_HOST'].'/EventManager/user_page/user.php');
                }else{
                    $error_m = "Incorrect password.";
                }
            }else{
                $error_m = "Account doesn`t exist";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='./main.css?v=<?php echo time(); ?>' />
    <title>Main page</title>
</head>
<body>
    <h1 id='app-title'>EventManager</h1>
    <h3 id='description'>Welcome to EventManager event management (duh) web-app! <br/> <a href='./main.php?option=sign-up' id='sign-up' style='color:red;'>Sign up</a> or <a href='./main.php?option=log-in' id='log-in' style='color:green;'>log in</a> to begin</h3>
    <div>
        <form id='main-form' action='' method='post'>
            <?php
                if($_GET['option'] == 'sign-up'){
                    ?>
                    <div class='signing-up'><label for='first_name'>First name: </label></label><input type='text' name='first_name' value='Jan' required/></div>
                    <div class='signing-up'><label for='last_name'>Last name: </label><input type='text' name='last_name' value='Kowalski' required/></div>
                    <?php
                }
            ?>
            <div class='logging-in'><label for='email_addr'>E-mail: </label><input type='email' name='email_addr' value='jk@example.org' required/></div>
            <div class='logging-in'><label minlength='6' size='20' maxlength='20' for='password'>Password: </label><input type='password' name='password' value='123456' required/></div>
            <input type='submit' name='option' value='<?= $_GET['option']?>'/> 
        </form>
        <div id='server-response'>
            <span>Server response:</span>
            <span><?= $error_m ?></span>
        </div>
    </div>
</body>
</html>