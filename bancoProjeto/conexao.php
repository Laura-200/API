<?php
$host = "192.168.10.32";
$user = "postgres";
$senha = "L@ur@2025";
$banco = "projeto";

$pdo = new PDO(
    "pgsql:host=$host;port=5432;dbname=$banco",
    $user,
    $senha
);
