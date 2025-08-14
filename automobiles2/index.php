<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Nishit Yogesh Shetty</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h1 { font-size: 2.3em; margin-bottom: 0.2em; }
        a { color: #337ab7; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .content { font-size: 1.12em; line-height: 1.7; }
    </style>
</head>
<body>
    <h1>Welcome to Autos Database</h1>
    <div class="content">
        <p>
            <a href="login.php">Please Log In</a>
        </p>
        <p>
            Attempt to go to <a href="view.php">view.php</a> without logging in – it should fail with an error message.<br>
            Attempt to go to <a href="add.php">add.php</a> without logging in – it should fail with an error message.
        </p>
    </div>
</body>
</html>