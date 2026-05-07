<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$host='127.0.0.1';$db='stylesheet_db';$user='root';$pass='root';
try {
  $pdo=new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4",$user,$pass,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]);
} catch (PDOException $e) { die('DB connection failed: '.$e->getMessage()); }
function clean_input($v){ return htmlspecialchars(trim((string)$v),ENT_QUOTES,'UTF-8'); }
