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
	
    <h2>Registration Form</h2>
	
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
	  <label><h3>Tutor Registration</h3></label>
	  <br>

        <label for="tutorFirstName">First Name</label>
	  <br>
	  <input type="text" id="tutorFirstName" name="tutorFirstName" required pattern="[A-Za-z]+" title="Name with at least 1 letter">
	  <br>

        <label for="tutorLastName">Last Name</label>
	  <br>
	  <input type="text" id="tutorLastName" name="tutorLastName" required pattern="[A-Za-z]+" title="Name with at least 1 letter">
	  <br>

        <label for="id">ID</label>
	  <br>
	  <input type="text" id="id" name="id" required pattern="[0-9]+" maxlength="9" title="Numerical ID">
	  <br>

    <!--
        <label>Subject:</label><br><br>
	  <label for="science">Science</label><br>
	  <input type="radio" id="science" name="subject" value="Science"><br>
	  <label for="mathematics">Mathematics</label><br>
	  <input type="radio" id="mathematics" name="subject" value="Mathematics"><br>
        <label for="english">English Language</label><br>
	  <input type="radio" id="english" name="subject" value="English Language"><br>
        <label for="accounting">Accounting</label><br>
	  <input type="radio" id="accounting" name="subject" value="Accounting"><br>
        <label for="computerStudies">Computer Studies</label><br>
	  <input type="radio" id="computerStudies" name="subject" value="Computer Studies"><br>
        <label for="history">History</label><br>
	  <input type="radio" id="history" name="subject" value="History"><br>
        <label for="geography">Geography</label><br>
	  <input type="radio" id="geography" name="subject" value="Geography"><br>
        <span><?php echo $subject_err;?></span>
	  <br>
    _-->

    <?php require("dbconnect.php");?>
      <select name="subject">
      <option value="">Select Subject</option>
    <?php
      $conn = connectDB(); 
      $query ="SELECT subName FROM A2subject";
      $result = $conn->query($query);
      if($result->num_rows> 0){
        while($optionData=$result->fetch_assoc()){
        $option =$optionData['subName'];
    ?>
        <option value="<?php echo $option; ?>" ><?php echo $option; ?> </option>
   <?php
    }}
    ?>

        <input type="submit" value="Submit">

    </form>
	
    <?php

      $tutor_fname_err = $tutor_lname_err = $tutor_id_err = $subject_err = "";
      $tutor_fname = $tutor_lname = $tutor_id = $subject = "";

      if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (!empty($_POST["tutorFirstName"])){
          $tutor_fname = test_input($_POST["tutorFirstName"]);
        }
        else {
          $tutor_fname_err = "Your name is required";
        }

        if (!empty($_POST["tutorLastName"])){
          $tutor_lname = test_input($_POST["tutorLastName"]);
        }
        else {
          $tutor_lname_err = "Your last name is required";
          }
    
        if (!empty($_POST["id"])){
          $tutor_id = test_input($_POST["id"]);
        }
        else {
          $tutor_id_err = "Your ID is required";
        }

        if (!empty($_POST["subject"])){
            $subject = test_input($_POST["subject"]);
        }
        else {
          $subject_err = "Please select a subject";
        }

      }

      function test_input($data){

            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);

            return $data;
          
      }

      if(!preg_match("/[a-zA-Z]+/", $tutor_fname)){
            echo "Invalid entry";
      }
      
      if(!preg_match("/[a-zA-Z]+/", $tutor_lname)){
            echo "Invalid entry";
      }

      if(!preg_match("/[0-9]+/", $tutor_id)){
            echo "Invalid entry";
      }

      //require "dbconnect.php";

      //$conn = connectDB();

      $stmt = $conn->prepare("INSERT INTO A2tutor (id, firstName, lastName, subject) VALUES(?, ?, ?, ?)");

      $stmt->bind_param("isss", $temp_id, $temp_fname, $temp_lname, $temp_subject);

      $temp_id = $tutor_id;
      $temp_fname = $tutor_fname;
      $temp_lname = $tutor_lname;
      $temp_subject = $subject;

      if($stmt->execute()){
        echo("Record inserted");
      }
      else{
        echo("Error with insertion");
      }

      $stmt->close();
	$conn->close();

    ?>
	
    <footer>
    </footer>
	
  </body>
</html>
