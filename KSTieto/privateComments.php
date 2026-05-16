<?php
    
    // Hyväksytään kutsut vue frontendistä:
    header("Access-Control-Allow-Origin: http://localhost:5173");

    // Hyväksytään POST
    header("Access-Control-Allow-Methods: POST, OPTIONS");

    header("Access-Control-Allow-Headers: Content-Type");
    header("Content-Type: application/json");

    include("database.php");

    // Haetaan POST:in JSON-tiedot
    $data = json_decode(file_get_contents("php://input"), true);

    // Haetaan käyttäjän id.
    $userId = $data["userId"] ?? null;

    // Tarkistetaan onko idtä olemassa.
    if (!$userId) {
        echo json_encode([
            "error" => "Missing userId"
        ]);
        exit;
    }

    // SQL-lause jolla haetaan käyttäjän kommentit.
    $sql = "SELECT id, content, public FROM comment WHERE userid = ?";

    // Sanitoidaan kysely SQL-injektioiden varalta.
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);

    $stmt->execute();

    $result = $stmt->get_result();


    $comments = [];

    // Laitetaan kaikki löydetyt kommentit taulukkoon.
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $comments[] = $row;
        }
    }

    // Lähetetään kommentit JSON-muodossa.
    echo json_encode($comments);

    $stmt->close();
    mysqli_close($conn);
?>