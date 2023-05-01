<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tuition Services</title>
    <link href="styles.css" type="text/css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="row">
    <header class="col-12">
        <img class="group1" id="logo" src="logo.png" alt="Website Logo">
        <h2 class="group1" id="companyName">Tuition Center</h2>
    </header>
    </div>
    
    <div class="row">
    <nav class="col-12 navbar">
        <ul class="navbar">
            <li><a href="index.html">Home</a></li>
            <li><a href="parentStudent.php">Register Student</a></li>
            <li><a href="tutorForm.php">Register Tutor</a></li>
            <li><a href="subjectForm.php">Register Subject</a></li>
            <li><a href="reports.php">Reports</a></li>
        </ul>
    </nav>
    </div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

        <label><h3>Subject Form</h3></label>
        <label>Subject Name:</label><br>
        <input type="text" pattern="[A-Za-z]+" name="sname" required>
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
        <label>Start Time:</label>
        <input type="time" name="startTime" min="08:00" max="18:00">
        <br><br>

        <label>End Time:</label>
        <input type="time" name="endTime" min="08:00" max="18:00">
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
        $stmt = $conn->prepare("INSERT INTO A2subjects (subName,daysTaught,startTime,endTime)VALUES(? ,? ,? ,?)");

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
    <div class="row">
        <footer class="col-12">
            <div>
                <h3>About Us</h3>
                <p>We are a leading provider of one-on-one and group tutoring services for a variety of subjects, including math, science, and language arts. Our experienced tutors are passionate about helping students achieve their academic goals.</p>
            </div>
            <div>
                <h3>Contact Us</h3>
                <ul class="list-unstyled contacts">
                    <li>+267 76600196</li>
                    <li>info@tuitionservices.com</li>
                    <li>123 Phakalane, Gaborone Botswana</li>
                </ul>
            </div>
            <div>
                <h3>Follow Us</h3>
                <ul class="list-unstyled">
                    <a href="#" class="text-decoration-none"><i></i>Facebook</a>
                    <a href="#" class="text-decoration-none"><i></i>Twitter</a>
                    <a href="#" class="text-decoration-none"><i></i>Instagram</a>
                    <a href="#" class="text-decoration-none"><i></i>LinkedIn</a>
                </ul>
            </div>
        
            <div>
                <p>© 2023 Tuition Services. All rights reserved.</p>
            </div>            
        </footer>
    </div>
</body>
</html>