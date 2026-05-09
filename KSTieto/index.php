<?php
  include("database.php");

  $sql = "SELECT * FROM users";
  $result = mysqli_query($conn, $sql);

  // Tarkistetaan tuliko kyselystä mitään
  if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)){
      echo $row["id"] . "<br>";
      echo $row["username"] . "<br>";
    };  
  } else {
    echo"No results found";
  }

  mysqli_close($conn);
?>