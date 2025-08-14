<?php
session_start();
require_once "pdo.php";
// Restrict access if not logged in
if (!isset($_SESSION['email'])) {
    die("Name parameter missing");
}
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cancel'])) {
        header('Location: view.php');
        exit();
    }
    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: index.php");
        exit();
    }
    $make = trim($_POST['make'] ?? '');
    $year = trim($_POST['year'] ?? '');
    $mileage = trim($_POST['mileage'] ?? '');
    if ($make === '') {
        $error = "Make is required";
    } elseif (!is_numeric($year) || !is_numeric($mileage)) {
        $error = "Mileage and year must be numeric";
    } else {
        $stmt = $pdo->prepare('INSERT INTO autos1 (make, year, mileage) VALUES (:mk, :yr, :mi)');
        $stmt->execute([
            ':mk' => $make,
            ':yr' => $year,
            ':mi' => $mileage
        ]);
        $_SESSION['success'] = "Record inserted";
        header("Location: view.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Nishit Yogesh Shetty</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px;}
        .error { color: red; }
    </style>
</head>
<body>
<div class="box">
    <h2>Add New Automobile</h2>
    <?php
        if ($error) echo '<p class="error">'.htmlentities($error).'</p>';
    ?>
    <form method="post">
        <label for="make">Make:</label>
        <input type="text" name="make" id="make" size="40"><br><br>
        <label for="year">Year:</label>
        <input type="text" name="year" id="year"><br><br>
        <label for="mileage">Mileage:</label>
        <input type="text" name="mileage" id="mileage"><br><br>
        <input type="submit" value="Add">
        <input type="submit" name="cancel" value="Cancel">
        <input type="submit" class="btn" name="logout">Logout</button>
    </form>

    <a>
</div>
</body>
</html>