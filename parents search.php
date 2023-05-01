<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent seach</title>
  </head>      
  <body>  
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
  <label for="student_id">Enter Student ID:</label>
  <input type="text" id="student_id" name="student_id" placeholder="Enter studentID">
  <input type="submit" name="submit" value="Search">
</form>

<?php
require "dbconnect.php";

$conn = connectDB();
if (isset($_POST["submit"])) {

 
  $student_id = $_POST["student_id"];

 
  $stmt = $conn->prepare("SELECT * 
                          FROM A2parent p 
                          INNER JOIN A2student s ON p.parentID = s.parentId 
                          WHERE s.id = ?");
  $stmt->bind_param("i", $student_id);

  
  $stmt->execute();
  $stmt->bind_result($parent_firstName, $parent_lastName, $parent_phoneNum, $parent_address,$parent_Id);

 
  if ($stmt->fetch()) {
   
    echo "Parent First Name: " . $parent_firstName . "<br>";
    echo "Parent Last Name: " . $parent_lastName . "<br>";
    echo "Parent Phone Number: " . $parent_phoneNum . "<br>";
    echo "Parent Address: " . $parent_address . "<br>";
  } else {
  
    echo "No matching record found.";
  }

  // close the prepared statement and database connection
  $stmt->close();
  $conn->close();

}
?>


<footer>
</footer>

</body>
</html>
