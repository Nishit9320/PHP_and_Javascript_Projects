<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=week3', 'admin3', 'password3');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);