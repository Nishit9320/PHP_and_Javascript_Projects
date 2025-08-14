<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=week4', 'admin4', 'password4');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);