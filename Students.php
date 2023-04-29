<!DOCTYPE html>
<html>
  <head>
    <title>Student Registration Form</title>
  </head>      
  <body>  
    <form action="" method="post" >
      <label for="firstName">First Name:</label>
      <input type="text" id="firstName" name="firstName" required><br><br>
      <label for="lastName">Last Name:</label>
      <input type="text" id="lastName" name="lastName" required><br><br>
      <label for="age">Age:</label>
      <input type="number" id="age" name="age" required><br><br>
      <label for="parentID">Parent ID:</label>
      <input type="number" id="parentID" name="parentID" maxlength="9" required><br><br>
      <label for="subjects">Select Subjects:</label><br>
      <select id="subjects" name="subjects[]" multiple required>
        <option value="math">Math</option>
        <option value="english">English</option>
        <option value="science">Science</option>
        <option value="history">History</option>
        <option value="computers">Computers</option>
      </select><br><br>  
      <input type="submit" value="Submit">
    </form>

    <?php
      // Define variables and set to empty values
      $firstName = $lastName = $age = $subjects = $parentID = "";
      $errors = array();

      // Validate the first name field
      if (empty($_POST["firstName"])) {
        $errors[] = "First name is required";
      } else {
        $firstName = test_input($_POST["firstName"]);
        // Check if first name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/",$firstName)) {
          $errors[] = "Only letters and white space allowed in first name";
        }
      }

      // Validate the last name field
      if (empty($_POST["lastName"])) {
        $errors[] = "Last name is required";
      } else {
        $lastName = test_input($_POST["lastName"]);
        // Check if last name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/",$lastName)) {
          $errors[] = "Only letters and white space allowed in last name";
        }
      }

      // Validate the age field
      if (empty($_POST["age"])) {
        $errors[] = "Age is required";
      } else {
        $age = test_input($_POST["age"]);
        // Check if age is a valid number
        if (!is_numeric($age)) {
          $errors[] = "Age must be a number";
        }
      }

      // Validate the parent id field
      if (empty($_POST["parentID"])) {
        $errors[] = "Parent ID is required";
      } else {
        $parentID = test_input($_POST["parentID"]);
        // Check if parent id is a valid number
        if (!is_numeric($parentID)) {
          $errors[] = "Parent ID must be a number";
        }
      }

      // Validate the subjects field
      if (empty($_POST["subjects"])) {
        $errors[] = "At least one subject is required";
      } else {
        $subjects = $_POST["subjects"];
      }

      // Function to sanitize and validate input
      function test_input($data) {
        $data = trim($data);
        $data = stripslashes($
