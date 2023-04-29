<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject Form</title>
    <style>
        .error {color: #FF0000;}
    </style>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

        <label><h3>Subject Form</h3></label>

        Subject Name: <input type="text" pattern="[A-Za-z]+" name="sname" required>
        <!-- <span class="error">* <//?php echo $snameErr;?></span> -->
        <br><br>
        
        <label>Days Taught:</label><br>
        <input type="checkbox" name="days[]" value="Monday" checked>
        <label for="day1">Monday</label><br>
        
        <input type="checkbox" name="days[]" value="Tuesday">
        <label for="day2">Tuesday</label><br>

        <input type="checkbox" name="days[]" value="Wednesday">
        <label for="day3">Wednesday</label><br>

        <input type="checkbox" name="days[]" value="Thursday">
        <label for="day4">Thursday</label><br>

        <input type="checkbox" name="days[]" value="Friday">
        <label for="day5">Friday</label><br><br>

        <label>Teaching hours : 08:00 to 18:00</label><br>
        Start Time: <input type="time" name="startTime" min="08:00" max="18:00">
        <br><br>

        End Time: <input type="time" name="endTime" min="08:00" max="18:00">
        <br><br>

        <input type="submit" name="submit" value="Submit">  

    </form>

    <!-- submit and validate form data -->
    <?php
    
    //variables to hold extracted data
    $valid=true;
    $subjectName = $days = $startTime = $endTime = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $subjectName = test_input($_POST["sname"]);
        $days = test_input(implode(",",$_POST['days']));
        $startTime = test_input($_POST["startTime"]);
        $endTime = test_input($_POST["endTime"]);
    }

    //function to sanitize data
    function test_input($data){
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        
        return $data;
    }

    if(!preg_match('/[a-zA-Z]+/', $subjectName)){
        echo "Invalid Subject Name";
    }

    if($startTime>=$endTime){
        $valid=false;
        echo "<h4 class='error'>End time should be greater than start time.</h4>";
    }

    if($valid){
        require 'dbconnect.php';
        $conn=connectDB(); 


        //inserting data into tables using prepared statements
        $stmt = $conn->prepare("INSERT INTO A2subject (subName,daysTaught,startTime,endTime)VALUES(? ,? ,? ,?)");

        $stmt->bind_param("ssss", $temp_sname, $temp_days, $temp_startTime, $temp_endTime);

        $temp_sname = $subjectName;
        $temp_days = $days;
        $temp_startTime = $startTime;
        $temp_endTime = $endTime;

        if($stmt->execute()){	
            echo("record inserted");
        }else {
            echo "Error inserting record: " . $stmt->error;  //print error message if any
        }

        $stmt->close();
    }
    
    

    ?>
</body>
</html>