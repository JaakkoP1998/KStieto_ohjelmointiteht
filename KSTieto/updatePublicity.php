<?php
    // Tämä tiedosto hoitaa kommenttien julkisuuden päivittämisen.

    // Hyväksytään kutsut vue frontendistä:
    header("Access-Control-Allow-Origin: http://localhost:5173");
    // Hyväksytään POST
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Content-Type: application/json");

    include("database.php");

    // Haetaan POST:in JSON-tiedot.
    $data = json_decode(file_get_contents("php://input"), true);

    // Haetaan kommentin id.
    $commentId = $data["commentId"] ?? null;


    $sql = "UPDATE comment SET public=1 WHERE id=?";

    // Sanitoidaan sql-kysely. 
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $commentId);

    $stmt->execute();

    echo json_encode(["Kommentti on julkaistu!"]);

    $stmt->close();
    mysqli_close($conn);
?>