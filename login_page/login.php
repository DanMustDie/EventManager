<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='login.css'/>
    <title>Log in page</title>
</head>
<body>
    <h1>You are on "Log in" page</h1>
    <form action='../user_page/user.php' method='post'>
        <div>E-mail: <input type='email' name='email_addr'/></div>
        <div>Password: <input type='password' name='password'/></div>
        <input type='submit' value='submit' onclick=>
    </form>
    <h3>Back to <a href='../main_page/main.php'>welcome page</a></h3>
</body>
</html>