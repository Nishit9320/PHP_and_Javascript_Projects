<?php
session_start();
require_once "pdo.php";

// Access control
if (!isset($_SESSION['email'])) {
    die("Name Parameter missing");
}

$message = '';
$error = '';

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

// Handle add
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $make = trim($_POST['make'] ?? '');
    $year = trim($_POST['year'] ?? '');
    $mileage = trim($_POST['mileage'] ?? '');

    if ($make === '' || $year === '' || $mileage === '') {
        $error = "All fields are required";
    } elseif (!is_numeric($year) || !is_numeric($mileage)) {
        $error = "Mileage and year must be numeric";
    } else {
        $stmt = $pdo->prepare('INSERT INTO autos (make, year, mileage) VALUES (:mk, :yr, :mi)');
        $stmt->execute([
            ':mk' => $make,
            ':yr' => $year,
            ':mi' => $mileage
        ]);
        $message = "Record inserted";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Nishit Yogesh Shetty</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px;}
        /* .topbar {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            margin-bottom: 24px;
        }
        .hello {
            font-size: 1.10em;
            margin-right: 14px;
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
        } */
        /* .box {
            border: 2px solid #446;
            padding: 22px 25px 30px 25px;
            width: 430px;
            margin-bottom: 20px;
        }
        h2 { margin-top: 0; margin-bottom: 13px; }
        label { width: 70px; display: inline-block; } */
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<!-- <body>
<div class="topbar">
    <span class="hello">
        Hello, <?= htmlentities($_SESSION['email']) ?>
    </span>
    <form method="post" style="display:inline;">
        <button type="submit" class="logout-btn" name="logout">Logout</button>
    </form>
</div> -->

<div class="box">
    <h2>Tracking Autos for <?= htmlentities($_SESSION['email']) ?></h2>
    <?php
    if ($message) echo '<p class="success">'.htmlentities($message).'</p>';
    if ($error)   echo '<p class="error">'.htmlentities($error).'</p>';
    ?>

    <form method="post">
        <label for="make">Make:</label>
        <input type="text" name="make" size="40" id="make"><br/>
        <label for="year">Year:</label>
        <input type="text" name="year" id="year"><br/>
        <label for="mileage">Mileage:</label>
        <input type="text" name="mileage" id="mileage"><br/>
        <button type="submit" name="add">Add</button>
        <button type="submit" name="logout">Logout</button>

    </form>

    <h3>Automobiles</h3>
    <ul>
    <?php
    $stmt = $pdo->query("SELECT make, year, mileage FROM autos ORDER BY auto_id DESC");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<li>".htmlentities($row['year']).' '.htmlentities($row['make']).' / '.htmlentities($row['mileage'])."</li>\n";
    }
    ?>
    </ul>
</div>
</body>
</html>
