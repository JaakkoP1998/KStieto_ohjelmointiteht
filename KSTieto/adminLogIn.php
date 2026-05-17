<?php
    // Tässä tiedostossa hoidetaan adminin sisälle kirjautuminen.

    // Hyväksytään kutsut vue frontendistä:
    header("Access-Control-Allow-Origin: http://localhost:5173");

    // Hyväksytään POST
    header("Access-Control-Allow-Methods: POST, OPTIONS");

    header("Access-Control-Allow-Headers: Content-Type");
    header("Content-Type: application/json");

    include("database.php");

    // Haetaan POST:in JSON-tiedot
    $data = json_decode(file_get_contents("php://input"), true);

    // Haetaan käyttäjänimi
    $password = $data["password"] ?? null;

    // Tarkistetaan saatiinko käyttäjä ja salasana Jsonista.
    if (!$password) {
        echo json_encode(["error" => "Salasana puuttuu"]);
        exit;
    }

    // SQL-lause jolla haetaan käyttäjän kommentit.
    $sql = "SELECT password FROM admins WHERE name = 'Jaakko'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 0) {
        echo json_encode(["error" => "Virhe Admin tilin haussa"]);
        exit;
    }

    $user = $result->fetch_assoc();

    // Verrataan annettua salasanaa hashattuun salasanaan
    // Palautetaan success=true jos on oikein,
    // success=false jos ei.
    if (password_verify($password, $user["password"])) {
        echo json_encode([
        "success" => true,
        "message" => "Salasana oikein"
        ]);
    } else {
        echo json_encode([
        "success" => false,
        "error" => "Salasana väärin"
        ]);
    }

    mysqli_close($conn);
?>