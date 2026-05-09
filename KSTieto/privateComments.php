<?php
    
    // Hyväksytään kutsut vue frontendistä:
    header("Access-Control-Allow-Origin: http://localhost:5173");

    // Hyväksytään POST
    header("Access-Control-Allow-Methods: POST, OPTIONS");

    header("Access-Control-Allow-Headers: Content-Type");
    header("Content-Type: application/json");

    include("database.php");

    //HUOM POSTin hakemisessa ongelmia.

    // Haetaan POST:in JSON-tiedot
    $data = json_decode(file_get_contents("php://input"), true);

    // Haetaan käyttäjän id, toimii jos kovakoodataan käyttäjän id.
    $userId = $_POST["userId"] ?? null;

    // Tarkistetaan onko idtä olemassa.
    if (!$userId) {
        echo json_encode([
            "error" => "Missing userId"
        ]);
        exit;
    }

    // Väliaikaisesti testaamista varten haetaan kaikki kommentit
    $sql = "SELECT id, content FROM comment WHERE userid = ?";

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