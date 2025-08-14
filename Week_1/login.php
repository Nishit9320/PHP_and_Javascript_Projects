<?php
session_start();
require_once "pdo.php";

if (isset($_POST['cancel'])) {
    header("Location: index.php");
    return;
}

$salt = 'XyZzy12*_';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email'] ?? '');
    $pass = trim($_POST['pass'] ?? '');

    // Server-side validation
    if (strlen($email) < 1 || strlen($pass) < 1 || strpos($email, '@') === false) {
        $_SESSION['error'] = "Invalid input";
        header("Location: login.php");
        return;
    }

    // Password check
    $check = hash('md5', $salt . $pass);
    $stmt = $pdo->prepare('SELECT user_id, name FROM users WHERE email = :em AND password = :pw');
    $stmt->execute(array(':em' => $email, ':pw' => $check));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row !== false) {
        $_SESSION['name'] = $row['name'];
        $_SESSION['user_id'] = $row['user_id'];
        header("Location: index.php");
        return;
    } else {
        $_SESSION['error'] = "Incorrect password";
        header("Location: login.php");
        return;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php require_once "bootstrap.php"; ?>
    <title>Nishit Yogesh Shetty | Login</title>
    <script>
        function validateForm(event) {
            const email = document.forms["loginForm"]["email"].value.trim();
            const pass = document.forms["loginForm"]["pass"].value.trim();

            // Only validate if the login button was clicked
            if (event.submitter.name === "login") {
                if (email === "" || pass === "") {
                    alert("Both fields must be filled out");
                    event.preventDefault();
                    return false;
                }
                if (!email.includes("@")) {
                    alert("Invalid email address");
                    event.preventDefault();
                    return false;
                }
            }
        }
    </script>
</head>
<body>
<div class="container">
    <h1>Please Log In</h1>
    <?php
    if (isset($_SESSION['error'])) {
        echo('<p style="color: red;">' . htmlentities($_SESSION['error']) . "</p>\n");
        unset($_SESSION['error']);
    }
    ?>
    <form name="loginForm" method="POST" action="login.php" onsubmit="validateForm(event);">
        Email <input type="text" name="email"><br/>
        Password <input type="password" name="pass"><br/>
        <input type="submit" name="login" value="Log In">
        <input type="submit" name="cancel" value="Cancel">
    </form>
</div>
</body>
</html>
