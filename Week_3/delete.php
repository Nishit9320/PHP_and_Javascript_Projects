<?php
session_start();

if (!isset($_SESSION['name'])) {
    die('Not logged in');
}

require_once "pdo.php";

// Handle Cancel → view.php
if (isset($_POST['cancel'])) {
    header("Location: view.php");
    return;
}

if (isset($_POST['Delete']) && isset($_POST['profile_id'])) {
    $sql = "DELETE FROM Profile WHERE profile_id = :zip";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':zip' => $_POST['profile_id']));
    $_SESSION['success'] = 'Record deleted';
    header('Location: index.php');
    return;
}

// Guardian
if (!isset($_GET['profile_id'])) {
    $_SESSION['error'] = "Missing profile_id";
    header('Location: index.php');
    return;
}

$stmt = $pdo->prepare("SELECT first_name, last_name FROM Profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row === false) {
    $_SESSION['error'] = 'Bad value for profile id';
    header('Location: index.php');
    return;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Nishit Yogesh Shetty | Delete</title>
    <?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
    <p>First Name: <?php echo(htmlentities($row['first_name'])); ?></p>
    <p>Last Name: <?php echo(htmlentities($row['last_name'])); ?></p>
    <form method="post">
        <input type="hidden" name="profile_id" value="<?php echo($_GET['profile_id']) ?>">
        <input type="submit" name="Delete" value="Delete">
        <input type="submit" name="cancel" value="Cancel">
    </form>
</div>
</body>
</html>