<?php
    $db_server = 'localhost';
    $db_uname = 'root';
    $db_upass = '';
    $db_name = 'eventmanager';
    $connection = new mysqli($db_server,$db_uname,$db_upass,$db_name);
    if(!$connection){
        echo "No connection to db";
        die();
    }

    $form_state = $_POST['form_state'];
    $form_fname = $_POST['first_name'];
    $form_lname = $_POST['last_name'];
    $form_email = $_POST['email_addr'];
    $form_pass = $_POST['password'];
    $id = uniqid('a');
    
    
    $insert_query = "INSERT into user (`first_name`,`last_name`,`email_addr`,`password`,`id`) values ('{$form_fname}','{$form_lname}','{$form_email}','{$form_pass}','{$id}')";
    $select_query = "SELECT * FROM user WHERE email_addr='{$form_email}' ";
    $select_result = $connection->query($select_query);
    $user = $select_result->fetch_assoc();
    
    if($form_state == 'sign-up'){#sign up procedure
        if($select_result->num_rows == 0){
            if(!$connection->query($insert_query)){
                echo "Error: something is wrong with db :<";
            }
        }else{
            echo "Error: Account with such e-mail address already exists. Please log in :|";
        }
    }elseif($form_state == 'log-in'){ #log in procedure 
        if($select_result->num_rows == 0){
            echo "Error : no account exists with such email. Please sign up :(";
        }elseif($form_pass != $user['password']){
            echo "Error : incorrect password :/ ";
        }
    }
?>