<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration Form</title>
  </head>      
  <body>  

  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
      <label for="firstName">First Name:</label>
      <input type="text" id="firstName" name="firstName" required><br><br>
      <label for="lastName">Last Name:</label>
      <input type="text" id="lastName" name="lastName" required><br><br>
      <label for="age">Age:</label>
      <input type="number" id="age" name="age" required><br><br>
      <label for="StudentID">Student ID:</label>
      <input type="number" id="StudentID" name="StudentID" maxlength="9" required><br><br>
      <h2>Parent Information:</h2>
      <label for="parentFirstName">Parent First Name:</label>
      <input type="text" id="parentFirstName" name="parentFirstName" required><br><br>
      <label for="parentLastName">Parent Last Name:</label>
      <input type="text" id="parentLastName" name="parentLastName" required><br><br>
      <label for="parentPhone">Parent Phone Number:</label>
      <input type="tel" id="parentPhone" name="parentPhone" pattern="[0-9]{8}" required><br><br>
      <label for="parentAddress">Parent Address:</label>
      <input type="text" id="parentAddress" name="parentAddress" required><br><br>
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

$firstName = $lastName = $age = $parentFirstName = $parentLastName = $parentPhone = $parentAddress = $parentID = $subjects = $StudentID = "";
$firstNameErr = $lastNameErr = $ageErr = $parentFirstNameErr = $parentLastNameErr = $parentPhoneErr = $parentAddressErr = $parentIDErr = $subjectsErr = $StudentIDErr = "";

// Validate input and sanitize data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["firstName"])) {
    $firstNameErr = "First name is required";
  } else {
    $firstName = test_input($_POST["firstName"]);
    // Check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$firstName)) {
      $firstNameErr = "Only letters and white space allowed"; 
    }
  }

  if (empty($_POST["lastName"])) {
    $lastNameErr = "Last name is required";
  } else {
    $lastName = test_input($_POST["lastName"]);
    // Check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$lastName)) {
      $lastNameErr = "Only letters and white space allowed"; 
    }
  }

  if (empty($_POST["age"])) {
    $ageErr = "Age is required";
  } else {
    $age = test_input($_POST["age"]);
    // Check if age is a number
    if (!is_numeric($age)) {
      $ageErr = "Age must be a number"; 
    }
  }

  if (empty($_POST["parentFirstName"])) {
    $parentFirstNameErr = "Parent first name is required";
  } else {
    $parentFirstName = test_input($_POST["parentFirstName"]);
    // Check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$parentFirstName)) {
      $parentFirstNameErr = "Only letters and white space allowed"; 
    }
  }

  if (empty($_POST["parentLastName"])) {
    $parentLastNameErr = "Parent last name is required";
  } else {
    $parentLastName = test_input($_POST["parentLastName"]);
    // Check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$parentLastName)) {
      $parentLastNameErr = "Only letters and white space allowed"; 
    }
  }

  if (empty($_POST["parentPhone"])) {
    $parentPhoneErr = "Parent phone number is required";
  } else {
    $parentPhone = test_input($_POST["parentPhone"]);
    // Check if phone number is valid
    if (!preg_match("/^[0-9]{8}$/",$parentPhone)) {
      $parentPhoneErr = "Invalid phone number"; 
    }
  }

  if (empty($_POST["parentAddress"])) {
    $parentAddressErr = "Parent address is required";
  } else {
    $parentAddress = test_input($_POST["parentAddress"]);
  }

  if (empty($_POST["parentID"])) {
    $parentIDErr = "Parent ID is required";
  } else {
    $parentID = test_input($_POST["parentID"]);
   
    if (strlen($parentID) != 9 || !is_numeric($parentID)) {
      $parentIDErr = "Invalid ID number"; 
    }
  }
  if (empty($_POST["StudentID"])) {
    $StudentIDErr = "Student ID is required";
  } else {
    $StudentID= test_input($_POST["StudentID"]);
   
    if (strlen($StudentID) != 9 || !is_numeric($StudentID)) {
      $StudentIDErr = "Invalid ID number"; 
    }
  }


if (empty($_POST["subjects"])) {
  $subjectsErr  = "At least one subject is required";
} else {
  $subjects = test_input($_POST["subjects"]);
}

function test_input($data){

  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);

  return $data;

}

require "dbconnect.php";

$conn = connectDB();

  
    $stmt1 = $conn->prepare("INSERT INTO A2parent (parentID, firstName, lastName, phoneNum, address) VALUES (?, ?, ?, ?, ?)");
    $stmt1->bind_param("issss", $parentID, $parentFirstName, $parentLastName, $parentPhone, $parentAddress);
    $stmt1->execute();
    
    
    $stmt2 = $conn->prepare("INSERT INTO A2student (firstName, lastName, age, parentId,studentID) VALUES (?, ?, ?, ?, ?)");
    $stmt2->bind_param("ssiii", $firstName, $lastName, $age, $parentID, $StudentID);
    $stmt2->execute();
    
    

if($stmt1->execute()){
  echo("Record inserted");
}
else{
  echo("Error with insertion");
}
if($stmt2->execute()){
  echo("Record inserted");
}
else{
  echo("Error with insertion");
}

$stmt1->close();
$stmt2->close();
$conn->close();

?>

<footer>
</footer>

</body>
</html>
