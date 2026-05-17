<?php
    // Tässä tiedostossa hoidetaan käyttäjän sisälle kirjautuminen.

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
    $userid = $data["id"] ?? null;

    // SQL-lause jolla poistetaan käyttäjä.
    $sql = "DELETE FROM users WHERE id = ?";

    // Sanitoidaan kysely SQL-injektioiden varalta.
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userid);

    $stmt->execute();


    echo json_encode(["Käyttäjä poistettu"]);

    $stmt->close();
    mysqli_close($conn);
?>