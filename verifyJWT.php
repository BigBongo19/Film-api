<?php

require_once('JWT.php');

$givenToken = $_SERVER['HTTP_AUTHORIZATION'];

$jwt = new JWT();
if ($jwt->verifyToken($givenToken) == true) {
    echo "Ziet er goed uit kerel, je token werkt nogsteeds!";
} else {
    echo "Er klopt iets niet, je token is ongeldig.";
}