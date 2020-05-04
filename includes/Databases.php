<?php
$host = 'localhost';
$user = 'root';
$dbname = 'iproject12';
$dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;
$pdo = new PDO($dsn, $user);

function getArraySelection1Par($sql, $par1){
    $statement = $this->pdo->prepare($sql);
    $statement->execute(['p1'=>$par1]);
    return $projecten = $statement->fetchAll();
}

function insertIntoDB($sql){
    $statement =$this->prepare($sql);
    $statement->execute();
}

function getArraySelection2Par($sql, $par1, $par2){
    $statement = $this->pdo->prepare($sql);
    $statement->execute(['p1'=>$par1,'p2'=>$par2]);
    return $projecten = $statement->fetchAll();
}