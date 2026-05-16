<?php
    // Tämä tiedosto hoitaa uuden käyttäjän lisäämisen tietokantaan.

    // Hyväksytään kutsut vue frontendistä:
    header("Access-Control-Allow-Origin: http://localhost:5173");

    // Hyväksytään POST
    header("Access-Control-Allow-Methods: POST, OPTIONS");

    header("Access-Control-Allow-Headers: Content-Type");
    header("Content-Type: application/json");

    include("database.php");

    // Haetaan POST:in JSON-tiedot.
    $data = json_decode(file_get_contents("php://input"), true);

    // Haetaan käyttäjänimi ja salasana.
    $username = $data["username"] ?? null;
    $password = $data["password"] ?? null;

    // Hashataan salasana
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

    // Sanitoidaan sql-kysely.
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $hash);

    $stmt->execute();

    echo json_encode(["Uusi käyttäjä luotu!"]);

    $stmt->close();
    mysqli_close($conn);
?>