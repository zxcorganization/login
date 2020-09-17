<?php   
try {
    $pdo = new PDO("mysql:host=localhost;dbname=database", 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
    exit($e->getMessage());
}?>