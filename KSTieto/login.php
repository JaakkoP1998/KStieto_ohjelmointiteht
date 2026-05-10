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

    // Haetaan käyttäjänimi
    $username = $data["username"] ?? null;

    // Tarkistetaan onko käyttäjää olemassa.
    if (!$username) {
        echo json_encode([
            "error" => "Wrong username or user doesn't exist."
        ]);
        exit;
    }

    // SQL-lause jolla haetaan käyttäjän kommentit.
    $sql = "SELECT id, username FROM users WHERE username = ?";

    // Sanitoidaan kysely SQL-injektioiden varalta.
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);

    $stmt->execute();

    $result = $stmt->get_result();

    $user = NULL;

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $user = $row;
    }

    echo json_encode($user);

    $stmt->close();
    mysqli_close($conn);
?>