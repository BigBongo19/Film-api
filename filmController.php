<?php
// Film.php meegeven om de getters en setters te kunnen herkennen.
include('film.php');

$authLvl = $_SERVER['HTTP_AUTHLVL'];


// Functies voor het kunnen gebruiken van de API.
function getFilms()
{
    $dsn = "mysql:host=gc-webhosting.nl;dbname=tvermeeren_films;charset=utf8mb4";

    // try catch meegeven voor het geval de connectie niet werkt, en je een error terug krijgt.
    try {
        $pdo = new PDO($dsn, 'tvermeeren_filmsUser', 'filmsUser');
        $query = $pdo->prepare("SELECT * FROM films");
        $query->execute();
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        $array = json_encode($data, JSON_PRETTY_PRINT);
        header('Content-Type: application/json');
    } catch (PDOException $e) {
        die('Kan niet verbinden met de database.');
    }

    return $array;
}

function getFilmsByID($id)
{

    $dsn = "mysql:host=gc-webhosting.nl;dbname=tvermeeren_films;charset=utf8mb4";

    // try catch meegeven voor het geval de connectie niet werkt, en je een error terug krijgt.
    try {
        $pdo = new PDO($dsn, 'tvermeeren_filmsUser', 'filmsUser');
        $query = $pdo->prepare("SELECT * FROM films WHERE id=:id");
        $query->bindParam(':id', $id);
        $query->execute();
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        $array = json_encode($data, JSON_PRETTY_PRINT);
        header('Content-Type: application/json');
    } catch (PDOException $e) {
        die('Kan niet verbinden met de database.');
    }

    return $array;
}

function addFilm(){
    try {
        $pdo = new PDO('mysql:host=gc-webhosting.nl;dbname=tvermeeren_films;charset=utf8mb4', 'tvermeeren_filmsUser', 'filmsUser');

        // Json uitlezen
        $data_in_json = file_get_contents('php://input');

        // Json converteren naar associative array
        $data = json_decode($data_in_json, true);

        // De film gegevens eruit halen
        $titel = $data['titel'];
        $speelduur = $data['speelduur'];
        $kijkwijzer = $data['kijkwijzer'];
        $genre = $data['genre'];

        $query = $pdo->prepare("INSERT INTO films(titel, speelduur, kijkwijzer, genre)VALUES(:titel, :speelduur, :kijkwijzer, :genre)");
        $query->bindParam(':titel', $titel);
        $query->bindParam(':speelduur', $speelduur);
        $query->bindParam(':kijkwijzer', $kijkwijzer);
        $query->bindParam(':genre', $genre);
        $query->execute();

        echo "De film is opgeslagen.";

    } catch (PDOException $e) {
        die('Kan niet verbinden met de database.');
    }
}

function deleteFilmById($id) {
    try {
        $pdo = new PDO('mysql:host=gc-webhosting.nl;dbname=tvermeeren_films;charset=utf8mb4', 'tvermeeren_filmsUser', 'filmsUser');

        // Json uitlezen
        $data_in_json = file_get_contents('php://input');

        // Json converteren naar associative array
        $data = json_decode($data_in_json, true);

        // De film gegevens eruit halen
        $id = $data['id'];

        $query = $pdo->prepare("DELETE FROM films WHERE id=:id");
        $query->bindParam(':id', $id);
        $query->execute();

        echo "De film met het bijbehorende ID is verwijderd.";

    } catch (PDOException $e) {
        die('Kan niet verbinden met de database.');
    }
}

// Als er om een GET-request wordt gevraagt, voer deze code uit
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $authLvl >= 1) {
    
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        echo getFilmsByID($id);
    } else {
        echo getFilms();
    }
} 

// Als er om een POST-request wordt gevraagt, voer deze code uit
elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $authLvl >= 2) {
    echo addFilm();
} 

// Als er om een DELETE-request wordt gevraagt, voer deze code uit
elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE' && $authLvl == 4) {
    echo deleteFilmById($id);
} else {
    echo "Je hebt niet genoeg rechten om dit uit te voeren.";
}