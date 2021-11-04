<?php 

$authLvl = $_SERVER['HTTP_AUTHLVL'];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $authLvl >= 1) {
    echo 'Je mag de gegevens ophalen.';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $authLvl >= 2) {
    echo 'Je mag de gegevens ophalen en invoeren.';
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE'  && $authLvl == 4) {
    echo 'Je mag de gegevens verwijderen';
} else {
    echo 'Je hebt onvoldoende rechten voor dit request.';
}