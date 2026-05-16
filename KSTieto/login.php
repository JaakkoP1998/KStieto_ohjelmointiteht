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
    $username = $data["username"] ?? null;
    $password = $data["password"] ?? null;

    // Tarkistetaan saatiinko käyttäjä ja salasana Jsonista.
    if (!$username || !$password) {
        echo json_encode(["error" => "Käyttäjänimi tai salasana puuttuu."]);
        exit;
    }

    // SQL-lause jolla haetaan käyttäjän kommentit.
    $sql = "SELECT id, username, password FROM users WHERE username = ?";

    // Sanitoidaan kysely SQL-injektioiden varalta.
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);

    $stmt->execute();

    $result = $stmt->get_result();

    if (mysqli_num_rows($result) === 0) {
        echo json_encode(["error" => "Käyttäjänimi tai salasana väärin"]);
        exit;
    }

    $user = $result->fetch_assoc();

    // Verrataan annettua salasanaa hashattuun salasanaan
    if (password_verify($password, $user["password"])) {
        echo json_encode([
            "id" => $user["id"],
            "username" => $user["username"]
        ]);

    } else {
        echo json_encode(["error" => "Käyttäjänimi tai salasana väärin"]);
    }

    $stmt->close();
    mysqli_close($conn);
?>