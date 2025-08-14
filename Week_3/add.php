<?php
session_start();

if (!isset($_SESSION['name'])) {
    die('Not logged in');
}

if (isset($_POST['cancel'])) {
    header("Location: index.php");
    return;
}

require_once "pdo.php";

function validatePos()
{
    for ($i = 1; $i <= 9; $i++) {
        if (!isset($_POST['year' . $i])) continue;
        if (!isset($_POST['desc' . $i])) continue;

        $year = $_POST['year' . $i];
        $desc = $_POST['desc' . $i];

        if (strlen($year) == 0 || strlen($desc) == 0) {
            return "All fields are required";
        }

        if (!is_numeric($year)) {
            return "Position year must be numeric";
        }
    }
    return true;
}

if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email'])
    && isset($_POST['headline']) && isset($_POST['summary'])) {
    
    if (strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 || strlen($_POST['email']) < 1 ||
        strlen($_POST['headline']) < 1 || strlen($_POST['summary']) < 1) {
        $_SESSION['error'] = 'All fields are required';
        header("Location: add.php");
        return;
    } elseif (strpos($_POST['email'], '@') === false) {
        $_SESSION['error'] = 'Bad Email';
        header("Location: add.php");
        return;
    } elseif (validatePos() !== true) {
        $_SESSION['error'] = validatePos();
        header("Location: add.php");
        return;
    } else {
        // Insert into Profile table
        $stmt = $pdo->prepare('INSERT INTO Profile 
            (user_id, first_name, last_name, email, headline, summary) 
            VALUES ( :uid, :fn, :ln, :em, :he, :su)');

        $stmt->execute(array(
            ':uid' => $_SESSION['user_id'],
            ':fn' => $_POST['first_name'],
            ':ln' => $_POST['last_name'],
            ':em' => $_POST['email'],
            ':he' => $_POST['headline'],
            ':su' => $_POST['summary']
        ));

        $profile_id = $pdo->lastInsertId();

        // Insert positions
        $rank = 1;
        for ($i = 1; $i <= 9; $i++) {
            if (!isset($_POST['year' . $i])) continue;
            if (!isset($_POST['desc' . $i])) continue;

            $year = $_POST['year' . $i];
            $desc = $_POST['desc' . $i];

            $stmt = $pdo->prepare('INSERT INTO Position
                (profile_id, `rank`, year, description)
                VALUES ( :pid, :rank, :year, :desc)');

            $stmt->execute(array(
                ':pid' => $profile_id,
                ':rank' => $rank,
                ':year' => $year,
                ':desc' => $desc
            ));

            $rank++;
        }

        $_SESSION['success'] = "Record added.";
        header("Location: index.php");
        return;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php require_once "bootstrap.php"; ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <title>Jared Best | Add Profile</title>
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
        <p>
            Position: <input type="button" id="addPos" value="+">
        <div id="position_fields"></div>
        </p>
        <input type="submit" value="Add">
        <input type="submit" name="cancel" value="Cancel">
    </form>
    <script>
        countPos = 0;
        $(document).ready(function () {
            $('#addPos').click(function (event) {
                event.preventDefault();
                if (countPos >= 9) {
                    alert("Maximum of nine position entries exceeded");
                    return;
                }
                countPos++;
                $('#position_fields').append(
                    '<div id="position' + countPos + '"> \
                        <p>Year: <input type="text" name="year' + countPos + '" value="" /> \
                        <input type="button" value="-" onclick="$(\'#position' + countPos + '\').remove(); return false;"></p> \
                        <textarea name="desc' + countPos + '" rows="8" cols="80"></textarea> \
                    </div>'
                );
            });
        });
    </script>
</div>
</body>
</html>