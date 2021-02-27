<?php


const DB_HOST = 'mysql:dbname=sushi_nishinokaze;host=localhost;charset=utf8';

CONST DB_USER = 'sushi_nishinokaze_user';

CONST DB_PASSWORD = 'nishinokaze';



try{
    $pdo = new PDO(DB_HOST, DB_USER, DB_PASSWORD,[
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false,]);
    echo 'Successful connection';

} catch(PDOException $e){
    echo 'Unable to connect to server'. $e->getMessage(). "\n";
　　　exit();
}

