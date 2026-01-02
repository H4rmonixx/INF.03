<?php

try{
    $pdo = new PDO("mysql:hostname=localhost;dbname=baza", "root", "");
} catch(PDOException $e){
    die("Nie udalo sie polaczyc z baza danych: " . $e);
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $stmt = $pdo->prepare("INSERT INTO rezerwacje (data_rez, liczba_osob, telefon) VALUES (?, ?, ?)");
    $stmt->execute([$_POST['data'], $_POST['osoby'], $_POST['telefon']]);
    $stmt->closeCursor();
}

echo 'Dodano rezerwację do bazy';

$pdo = null;

?>