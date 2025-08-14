<?php
session_start();

if (!isset($_SESSION['name'])) {
    die('Not logged in');
}

require_once "pdo.php";

// Handle Cancel button — go back to view.php
if (isset($_POST['cancel'])) {
    header("Location: view.php");
    return;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first = trim($_POST['first_name'] ?? '');
    $last = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $headline = trim($_POST['headline'] ?? '');
    $summary = trim($_POST['summary'] ?? '');

    // Validation — all fields required
    if (strlen($first) < 1 || strlen($last) < 1 || strlen($email) < 1 ||
        strlen($headline) < 1 || strlen($summary) < 1) {
        $_SESSION['error'] = 'All fields are required';
        header("Location: add.php");
        return;
    }

    // Email must contain @
    if (strpos($email, '@') === false) {
        $_SESSION['error'] = 'Email address must contain @';
        header("Location: add.php");
        return;
    }

    // Insert into DB
    $stmt = $pdo->prepare('INSERT INTO Profile 
        (user_id, first_name, last_name, email, headline, summary) 
        VALUES (:user_id, :first_name, :last_name, :email, :headline, :summary)');
    $stmt->execute(array(
        ':user_id' => $_SESSION['user_id'],
        ':first_name' => $first,
        ':last_name' => $last,
        ':email' => $email,
        ':headline' => $headline,
        ':summary' => $summary
    ));

    $_SESSION['success'] = "Record added.";
    header("Location: index.php");
    return;
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php require_once "bootstrap.php"; ?>
    <title>Nishit Yogesh Shetty | Adding Profile</title>
</head>
<body>
<div class="container">
    <h1>Adding Profile for UMSI</h1>
    <?php
    if (isset($_SESSION['error'])) {
        echo('<p style="color: red;">' . htmlentities($_SESSION['error']) . "</p>\n");
        unset($_SESSION['error']);
    }
    ?>
    <form method="post">
        <p>First Name:
            <input type="text" name="first_name" size="60"/></p>
        <p>Last Name:
            <input type="text" name="last_name" size="60"/></p>
        <p>Email:
            <input type="text" name="email" size="30"/></p>
        <p>Headline:<br/>
            <input type="text" name="headline" size="80"/></p>
        <p>Summary:<br/>
            <textarea name="summary" rows="8" cols="80"></textarea>
        </p>
        <p>
            <input type="submit" value="Add">
            <input type="submit" name="cancel" value="Cancel">
        </p>
    </form>
</div>
</body>
</html>