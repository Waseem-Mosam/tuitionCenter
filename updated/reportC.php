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
	
    <h1>Report C: List all enrolled students. Include all personal details and all the subjects they are taking</h1>

    <table class="enroll">
        <tr>
            <th>Student ID<th>
            <th>First Name<th>
            <th>Last Name<th>
            <th>Age<th>
        </tr>

    <?php

      require("dbconnect.php");

      $conn = connectDB();
      $query ="SELECT studentID, firstName, lastName, age FROM A2student";
      $result = $conn->query($query);

      if($result->num_rows> 0){
        while($subjectData=$result->fetch_assoc()){
            $student_ID = $subjectData['studentID'];
            $student_fname = $subjectData['firstName'];
            $student_lname = $subjectData['lastName'];
            $student_age = $subjectData['age'];
    ?>

      <tr>
        <td><?php echo "$student_ID"; ?></td>
        <td><?php echo "$student_fname"; ?></td>
        <td><?php echo "$student_lname"; ?></td>
        <td><?php echo "$student_age"; ?></td>
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
