<!DOCTYPE html>
<html lang="en">

  <head>
    <title>Tutor Registration</title>
    <meta charset="utf-8">
    <meta name="author" content="Dihutswane Mosieyane">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  
  <body>
  
    <header>
    </header>
	
    <nav>
    </nav>
	
    <h1>Report A: List all the offered subjects, including their details.</h1>

    <table class="enroll">
        <tr>
            <th>Subject<th>
        </tr>

    <?php

      require("dbconnect.php");

      $conn = connectDB();
      $query ="SELECT subName FROM A2subjects";
      $result = $conn->query($query);

      if($result->num_rows> 0){
        while($subjectData=$result->fetch_assoc()){
            $subject = $subjectData['subName'];
    ?>

      <tr>
        <td><?php echo "$subject"; ?></td>
      </tr>

    <?php
        }}

      $result->close();
	  $conn->close();
    ?>

    
    </table>
	
    <footer>
    </footer>
	
  </body>
</html>
