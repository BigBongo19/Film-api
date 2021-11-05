<?php
$id = $_SERVER["HTTP_USERID"];
$user = $_SERVER["HTTP_USERNAME"];
$authlvl = $_SERVER["HTTP_AUTHLVL"];
$token = $_SERVER['HTTP_TOKEN'];

$host = 'gc-webhosting.nl';
$db   = 'tvermeeren_security';
$user = 'tvermeeren_s_user';
$pass = 'filmsUser';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$jwt = new JWT();
$jwt->verifyToken($token);

try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int) $e->getCode());
}

$query = 'SELECT * FROM users WHERE username=:username AND authlvl=:authlvl';
$stmt = $pdo->prepare($query);
$stmt->bindParam(':username', $user);
$stmt->bindValue(':authlvl', $authlvl);
$stmt->execute();

$count = $stmt->rowCount();
$row   = $stmt->fetch(PDO::FETCH_ASSOC);
if ($count > 0 && $jwt->verifyToken($token) == true) {
    echo "Welkom gebruiker!";
} else {
    echo "Invalide gebruikersnaam en je token!";
}

/* creeër nieuwe pdo met query
SELECT * FROM users WHERE username = $user AND authlvl = $authlvl of zoiets */