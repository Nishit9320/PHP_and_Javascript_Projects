<?php
session_start();
require_once "pdo.php";

// Restrict access if not logged in
if (!isset($_SESSION['email'])) {
    die("Name parameter missing");
}

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

// Handle message from add.php via session
$success = $_SESSION['success'] ?? '';
unset($_SESSION['success']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Nishit Yogesh Shetty</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }
        .topbar {
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
        }
        .success {
            color: green;
        }
        h2 {
            margin-top: 0;
            margin-bottom: 13px;
        }
        .add-link {
            margin-bottom: 14px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <!-- <div class="topbar">
        <span class="hello">
            Hello, <?= htmlentities($_SESSION['email']) ?>
        </span>
        <form method="post" style="display:inline;">
            <button type="submit" class="logout-btn" name="logout">Logout</button>
        </form>
    </div> -->

    <h2>Tracking Autos for <?= htmlentities($_SESSION['email']) ?></h2>

    <?php if ($success): ?>
        <p class="success"><?= htmlentities($success) ?></p>
    <?php endif; ?>

    
    <div class="button-group">
        <a href="add.php">Add New</a>
        <form method="post" style="display:inline;">
            <button type="submit" class="btn" name="logout">Logout</button>
        </form>
    </div>


    <h3>Automobiles</h3>
    <ul>
        <?php
        $stmt = $pdo->query("SELECT make, year, mileage FROM autos1 ORDER BY auto_id DESC");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<li>" . htmlentities($row['year']) . ' ' . htmlentities($row['make']) . ' / ' . htmlentities($row['mileage']) . "</li>\n";
        }
        ?>
    </ul>
</body>
</html>
