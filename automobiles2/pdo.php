<?php
$pdo = new PDO('mysql:host=localhost;dbname=misc1', 'fred1', 'zap1');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>