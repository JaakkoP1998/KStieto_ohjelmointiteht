<?php
    // Hyväksytään kutsut vue frontendistä:
    header("Access-Control-Allow-Origin: http://localhost:5173");

    // Hyväksytään POST
    header("Access-Control-Allow-Methods: POST, OPTIONS");

    header("Access-Control-Allow-Headers: Content-Type");
    header("Content-Type: application/json");

    include("database.php");

    // Haetaan POST:in JSON-tiedot.
    $data = json_decode(file_get_contents("php://input"), true);

    // Haetaan kommentin tiedot
    $content = $data["content"] ?? null;
    $userid = $data["userid"] ?? null;
    $public = $data["public"] ?? null;

    if (!$content) {
        echo json_encode([
            "error" => "Kommentti ei saa olla tyhjä!"
        ]);
        exit;
    }

    $sql = "INSERT INTO comment (content, userid, public) VALUES (?, ?, ?)";

    // Sanitoidaan sql-kysely. 
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $content, $userid, $public);

    $stmt->execute();

    echo "Uusi kommentti lisätty!";

    $stmt->close();
    mysqli_close($conn);
?>