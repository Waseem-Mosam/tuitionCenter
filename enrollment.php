<!DOCTYPE html>
<html>
<head>
	<title>Search Enrollment Number</title>
</head>
<body>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
	<label for="subject">Search Subject:</label>
	<input type="text" id="subject" name="subject">
	<button type="submit">Search</button>
</form>

<?php
require "dbconnect.php";

$conn = connectDB();
	
    if(isset($_POST['search_subject'])){
        $subject_name = $_POST['search_subject'];
    }
    
   
    $stmt = $conn->prepare("SELECT COUNT(*) FROM A2studentSubject WHERE subName = ?");
    $stmt->bind_param("s", $subject_name);
    $stmt->execute();
    $stmt->bind_result($enrollment_count);
    $stmt->fetch();
    
   
    echo "Number of students enrolled in $subject_name: $enrollment_count";
    
    $stmt->close();
    $conn->close();
    ?>
</body>
</html>
