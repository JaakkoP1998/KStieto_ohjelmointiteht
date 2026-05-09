<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json");

  include("database.php");
  // Väliaikaisesti testaamista varten haetaan kaikki kommentit
  $sql = "SELECT id, content FROM comment";
  $result = mysqli_query($conn, $sql);

  $comments = [];

  if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
          $comments[] = $row;
      }
  }

  echo json_encode($comments);

  mysqli_close($conn);
?>