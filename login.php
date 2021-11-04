<?php
$id = $_SERVER["HTTP_USERID"];
$user = $_SERVER["HTTP_USERNAME"];
$authlvl = $_SERVER["HTTP_AUTHLVL"];

$jwt = new JWT();
echo $jwt->createToken($id,$user,$authlvl);

/* creeër nieuwe pdo met query
SELECT * FROM users WHERE username = $user AND authlvl = $authlvl of zoiets