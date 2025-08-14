<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Nishit Yogesh Shetty</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .topbar {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            margin-bottom: 30px;
        }
        .hello {
            font-size: 1.15em;
            margin-right: 16px;
        }
        .logout-btn {
            padding: 4px 14px;
            background: #337ab7;
            color: #fff;
            border: none;
            border-radius: 4px;
            margin-left: 8px;
            cursor: pointer;
            font-size: 1em;
        }
        .logout-btn:hover {
            background: #23527c;
        }
        h1 { font-size: 2.5em; margin-bottom: 0.3em; }
        a { color: #337ab7; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .content { font-size: 1.15em; line-height: 1.7; }
    </style>
</head>
<body>

<div class="topbar">
    <?php if (isset($_SESSION['email'])): ?>
        <span class="hello">
            Hello, <?= htmlentities($_SESSION['email']) ?>
        </span>
        <form method="post" style="display:inline;">
            <button type="submit" class="logout-btn" name="logout">Logout</button>
        </form>
    <?php endif; ?>
</div>

<h1>Welcome to Autos Database</h1>
<div class="content">
    <?php if (!isset($_SESSION['email'])): ?>
        <p><a href="login.php">Please Log In</a></p>
    <?php endif; ?>
    <p>
        Attempt to go to <a href="autos.php">autos.php</a> without logging in – it should fail with an error message.
    </p>
</div>

<?php
// Handle logout from this page
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}
?>

</body>
</html>