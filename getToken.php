<?php

$token = $_SERVER['HTTP_TOKEN'];
$id = $_SERVER["HTTP_USERID"];
$user = $_SERVER["HTTP_USERNAME"];
$authlvl = $_SERVER["HTTP_AUTHLVL"];

$jwt = new JWT();
echo $jwt->createToken($id, $user, $authlvl);