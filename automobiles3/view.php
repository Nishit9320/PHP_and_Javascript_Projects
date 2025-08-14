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

    <h2>Welcome to the Automobile Database</h2>

    <?php if ($success): ?>
        <p class="success"><?= htmlentities($success) ?></p>
    <?php endif; ?>

    <h3>Automobiles</h3>
    <?php
        $stmt = $pdo->query("SELECT auto_id, make, model, year, mileage FROM autos2 ORDER BY auto_id DESC");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($rows) > 0) {
        echo('<table border="1">');
        echo("<tr>
                <th>Make</th>
                <th>Model</th>
                <th>Year</th>
                <th>Mileage</th>
                <th>Action</th>
            </tr>");
        foreach ($rows as $row) {
            echo "<tr>";
            echo "<td>" . htmlentities($row['make']) . "</td>";
            echo "<td>" . htmlentities($row['model']) . "</td>";
            echo "<td>" . htmlentities($row['year']) . "</td>";
            echo "<td>" . htmlentities($row['mileage']) . "</td>";
            // Links to edit and delete, passing the row's auto_id
            echo '<td>';
            echo '<a href="edit.php?auto_id=' . $row['auto_id'] . '">Edit</a> / ';
            echo '<a href="delete.php?auto_id=' . $row['auto_id'] . '">Delete</a>';
            echo '</td>';
            echo "</tr>";
        }
        echo "</table>";
        } else {
        echo '<p>No entries found</p>';
        }
    ?>
    <div class="button-group">
        <a href="add.php">Add New Entry</a> 
        <form method="post" style="display:inline;">
            <button type="submit" class="btn" name="logout">Logout</button>
        </form>
    </div>
</body>
</html>
