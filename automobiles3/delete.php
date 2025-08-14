<?php
session_start();
require_once "pdo.php";

if (!isset($_SESSION['email'])) {
    die("ACCESS DENIED");
}

if (!isset($_GET['auto_id'])) {
    die("Missing auto_id");
}

$auto_id = $_GET['auto_id'];

// Fetch record
$stmt = $pdo->prepare("SELECT * FROM autos2 WHERE auto_id = :id");
$stmt->execute([':id' => $auto_id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    die("Bad value for auto_id");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cancel'])) {
        header("Location: view.php");
        exit();
    }
    $stmt = $pdo->prepare("DELETE FROM autos2 WHERE auto_id = :id");
    $stmt->execute([':id' => $auto_id]);
    $_SESSION['success'] = "Record deleted";
    header("Location: view.php");
    exit();
}
?>
<!DOCTYPE html>
    <html>
    <head>
        <title>Nishit Yogesh Shetty</title>
    </head>
    <body>
        <h2>Delete Automobile</h2>
        <p>Are you sure you want to delete:</p>
        <ul>
            <li><?= htmlentities($row['year']) ?> <?= htmlentities($row['make']) ?> <?= htmlentities($row['model']) ?> / <?= htmlentities($row['mileage']) ?></li>
        </ul>
        <form method="post">
            <input type="submit" value="Delete">
            <input type="submit" name="cancel" value="Cancel">
        </form>
    </body>
</html>