<?php
$pdo = new PDO('mysql:host=localhost;dbname=misc2', 'fred2', 'zap2');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>