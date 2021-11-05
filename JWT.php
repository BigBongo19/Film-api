<?php
include('login.php');
class JWT
{

    function createToken($userID, $username, $authlvl)
    {
        // hier creëren we de header in JSON formaat met informatie over de token
        $header = '{ "typ": "JWT", "alg": "HS256" }';
        $header = base64_encode($header); // omzetten naar BASE64 URL om het te kunnen gebruiken
        $header = str_replace("=", "", $header); // alle = tekens verwijderen
        $header = str_replace("+", "-", $header); // alle + vervangen door -
        $header = str_replace("/", "_", $header); // alle / vervangen door _

        // De payload is data van de gebruiker in JSON formaat
        $payload = '{ "iat": "' . date("Y-m-d H:i:s") . '", "userID": ' . $userID . ', "username": "' . $username . '", "authlvl": ' . $authlvl . ' } ';
        $payload = base64_encode($payload);
        $payload = str_replace("=", "", $payload);
        $payload = str_replace("+", "-", $payload);
        $payload = str_replace("/", "_", $payload);

        // De signature wordt op een speciale manier versleuteld
        // Geef het algoriteme, de header.payload, en dan nog een geheime sleutel met "binary" op true

        $signature = hash_hmac("sha256", $header . "." . $payload, "kippenpoot", true);
        $signature = base64_encode($signature);
        $signature = str_replace("=", "", $signature);
        $signature = str_replace("+", "-", $signature);
        $signature = str_replace("/", "_", $signature);

        $jwt = $header . "." . $payload . "." . $signature;
        $token = "Bearer " . $jwt;

        return $token;
    }

    function verifyToken($token)
    {
        $jwt       = explode("Bearer ", $token)[1];
        $header    = explode(".", $jwt)[0];
        $payload   = explode(".", $jwt)[1];
        $signature = explode(".", $jwt)[2];

        // Controleren of de signature klopt en valide is.

        $checksignature = hash_hmac("sha256", $header . "." . $payload, "kippenpoot", true);
        $checksignature = base64_encode($checksignature);
        $checksignature = str_replace("=", "", $checksignature);
        $checksignature = str_replace("+", "-", $checksignature);
        $checksignature = str_replace("/", "_", $checksignature);

        if ($signature == $checksignature) {
            return true;
        } else {
            return false;
        }
    }

    function getPayloadFromToken($token) {
        $jwt       = explode("Bearer ", $token)[1];
        $header    = explode(".", $jwt)[0];
        $payload   = explode(".", $jwt)[1];
        $signature = explode(".", $jwt)[2];

        return base64_decode($payload);
    }
}
