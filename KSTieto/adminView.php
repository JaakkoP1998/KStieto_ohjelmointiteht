<?php

    // Hyväksytään kutsut vue frontendistä:
    header("Access-Control-Allow-Origin: http://localhost:5173");

    // Hyväksytään POST
    header("Access-Control-Allow-Methods: GET, OPTIONS");

    header("Access-Control-Allow-Headers: Content-Type");
    header("Content-Type: application/json");

    include("database.php");

    // Tämän lauseen muodostamisessa on käytetty apuna ChatGPT:tä.
    $sql = "
    SELECT 
        users.id as user_id,
        users.username,
        comment.id as comment_id,
        comment.content
    FROM users
    LEFT JOIN comment 
        ON users.id = comment.userid
    ORDER BY users.username
    ";

    $result = $conn->query($sql);

    $users = [];

    // Palutetaan käyttäjät ja heidän kommentit.
    while ($row = $result->fetch_assoc()) {

        $userId = $row['user_id'];

        if (!isset($users[$userId])) {
            $users[$userId] = [
                "id" => $userId,
                "username" => $row['username'],
                "comments" => []
            ];
        }

        if ($row['comment_id']) {
            $users[$userId]["comments"][] = [
                "id" => $row['comment_id'],
                "content" => $row['content']
            ];
        }
    }

    echo json_encode(array_values($users));

    $conn->close();
?>