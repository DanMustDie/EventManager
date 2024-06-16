<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='signup.css'/>
    <title>Sign up page</title>
</head>
<body>
    <h1>You are on 'Sign up' page</h1>
    <form action='./signup_res.php' method='post'></div>
        <div><label>First name: </label><input type='text' name='first_name'/></div>
        <div><label>Last name: </label><input type='text' name='last_name'/></div>
        <div><label>E-mail: </label><input type='email' name='email_addr'/></div>
        <div><label>Password: </label><input type='password' name='password'/></div>
        <div><input type='submit'/></div>
    </form>
    <h3>Back to <a href='../main_page/main.php'>welcome page</a></h3>
</body>
</html>