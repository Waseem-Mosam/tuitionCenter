<!DOCTYPE html>
<html lang="en">

  <head>
    <title>Tutor Registration</title>
    <meta charset=utf-8">
    <meta name="author" content="Dihutswane Mosieyane">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  
  <body>
  
    <header>
    </header>
	
    <nav>
    </nav>
	
    <h1>Report E: List all tutors</h1>

    <table>
        <tr>
            <th>Tutors<th>
        </tr>

    <?php

      require("dbconnect.php");

      $conn = connectDB();
      $query ="SELECT firstName, lastName FROM A2tutor";
      $result = $conn->query($query);

      if($result->num_rows> 0){
        while($studentData=$result->fetch_assoc()){
            $fname = $studentData['firstName'];
            $lname = $studentData['lastName'];
    ?>

      <tr>
        <td><?php echo "$fname $lname"; ?></td>
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
