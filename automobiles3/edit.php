<?php
session_start();
require_once "pdo.php";

// Check login
if (!isset($_SESSION['email'])) {
    die("ACCESS DENIED");
}

// Check for auto_id
if (!isset($_GET['auto_id'])) {
    die("Missing auto_id");
}

$auto_id = $_GET['auto_id'];

// Fetch existing record
$stmt = $pdo->prepare("SELECT * FROM autos2 WHERE auto_id = :id");
$stmt->execute([':id' => $auto_id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    die("Bad value for auto_id");
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cancel'])) {
        header("Location: view.php");
        exit();
    }
    $make = trim($_POST['make'] ?? '');
    $model = trim($_POST['model'] ?? '');
    $year = trim($_POST['year'] ?? '');
    $mileage = trim($_POST['mileage'] ?? '');

    if ($make === '' || $model === '' || $year === '' || $mileage === '') {
        $error = "All fields are required";
    } elseif (!is_numeric($year) || !is_numeric($mileage)) {
        $error = "Mileage and year must be numeric";
    } else {
        $stmt = $pdo->prepare('UPDATE autos2 
            SET make = :mk, model = :md, year = :yr, mileage = :mi
            WHERE auto_id = :id');
        $stmt->execute([
            ':mk' => $make,
            ':md' => $model,
            ':yr' => $year,
            ':mi' => $mileage,
            ':id' => $auto_id
        ]);
        $_SESSION['success'] = "Record updated";
        header("Location: view.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Nishit Yogesh Shetty</title>
    </head>
    <body>
        <h2>Edit Automobile</h2>
        <?php if ($error): ?>
            <p style="color: red"><?= htmlentities($error) ?></p>
        <?php endif; ?>
        <form method="post">
            <p>Make: <input type="text" name="make" size="40" value="<?= htmlentities($row['make']) ?>"></p>
            <p>Model: <input type="text" name="model" size="40" value="<?= htmlentities($row['model']) ?>"></p>
            <p>Year: <input type="text" name="year" value="<?= htmlentities($row['year']) ?>"></p>
            <p>Mileage: <input type="text" name="mileage" value="<?= htmlentities($row['mileage']) ?>"></p>
            <input type="submit" value="Save">
            <input type="submit" name="cancel" value="Cancel">
        </form>
    </body>
</html>