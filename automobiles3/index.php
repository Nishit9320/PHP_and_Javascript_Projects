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
            <a href="login.php">Please log in</a>
        </p>
        <p>
            Attempt to <a href="add.php">add data</a> without logging in
        </p>
    </div>
</body>
</html>