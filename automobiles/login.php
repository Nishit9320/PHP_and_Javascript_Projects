<?php
session_start();
require_once "pdo.php";

$salt = 'XyZzy12*_';
$stored_hash = hash('md5', $salt . 'php123');  // Password is php123

$error = false;

if (isset($_POST['cancel'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['who']) && isset($_POST['pass'])) {
    $email = $_POST['who'];
    $pass = $_POST['pass'];

    if (strlen($email) < 1 || strlen($pass) < 1) {
        $error = "Email and password are required";
    } else if (strpos($email, '@') === false) {
        $error = "Email must have an at-sign (@)";
    } else {
        $check = hash('md5', $salt . $pass);
        if ($check == $stored_hash) {
            $_SESSION['email'] = $email;
            header("Location: autos.php");
            exit();
        } else {
            $error = "Incorrect password";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Nishit Yogesh Shetty</title>
    <style>
        .box { max-width: 345px; border: 1px solid #ccc; background: #f8f8f8; padding: 30px 20px; margin: 70px auto; }
        h1 { margin-top: 0; }
        label, input { display: block; margin-bottom: 10px; }
        .error { color: red; }
        .hint { color: #888; font-size: 0.97em; }
        button, input[type="submit"] { padding: 5px 12px; font-size: 1em;}
    </style>
</head>
<body>
<div class="box">
    <h1>Please Log In</h1>
    <?php
    if ($error !== false) {
        echo('<p class="error">'.htmlentities($error)."</p>\n");
    }
    ?>
    <form method="POST">
        <label for="who">User Name</label>
        <input type="text" name="who" id="email" autocomplete="username">
        <label for="pass">Password</label>
        <input type="password" name="pass" id="pass" autocomplete="current-password">
        <input type="submit" value="Log In">
        <input type="submit" name="cancel" value="Cancel">
    </form>
    <p class="hint">For a password hint, view source and find a password hint in the HTML comments.</p>
</div>
<!-- Hint: The password is the three character language prefix used in this course (all lower case) followed by 123 -->
</body>
</html>