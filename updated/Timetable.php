<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>timetable</title>
  </head>      
  <body>  
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
  <label for="tutor_id">Enter tuter ID:</label>
  <input type="text" id="tutor_id" name="tutor_id" placeholder="Enter tuter ID">
  <input type="submit" name="submit" value="Search">
</form>

<?php
require "dbconnect.php";

$conn = connectDB();


if(isset($_POST['tutor_id']) && !empty(trim($_POST['tutor_id']))){
    $tutor_id = trim($_GET['tutor_id']);

   
    $sql = "SELECT * FROM Tutors WHERE id = $tutor_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      
        $row = $result->fetch_assoc();
      
        echo "Name: " . $row["firstName"] . "<br>";
        echo "Subject: " . $row["subject"] . "<br><br>";

        
        $subject_name = $row["subject"];
        $sql = "SELECT daysTaught , startTime , endTime  FROM A2subject WHERE name = '$subject_name'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
           
            while($row = $result->fetch_assoc()) {
                
                echo "StartTime: " . $row["startTime"] . "<br>";
                echo "endTime" . $row["endTime"] . "<br>";
                echo "Days: " . $row["days"] . "<br><br>";
            }
        } else {
            echo "No subjects found.";
        }
    } else {
        echo "Tutor not found.";
    }
}

// Close the database connection
$conn->close();
?>

