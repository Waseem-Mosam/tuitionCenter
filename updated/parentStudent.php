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

        <label><h3>Parent Registration</h3></label>

        ID : <input type="text" name="pID" required>
        <br><br>

        First Name : <input type="text" name="pfName" pattern="[A-Za-z]+" required>
        <br><br>

        Last Name : <input type="text" name="plName" pattern="[A-Za-z]+" required>
        <br><br>

        Address : <input type="text" name="pAddress" required>
        <br><br>

        Phone Number : <input type="text" name="phone" required>
        <br><br>

        <label><h3>Parent Registration</h3></label>

        ID : <input type="text" name="sID" required>
        <br><br>

        First Name : <input type="text" name="sfName" pattern="[A-Za-z]+" required>
        <br><br>

        Last Name : <input type="text" name="slName" pattern="[A-Za-z]+" required>
        <br><br>

        Age : <input type="text" name="age" required>
        <br><br>

    <?php require("dbconnect.php");?>
     
    <?php
      $conn = connectDB(); 
      $query ="SELECT subName FROM A2subjects";
      $result = $conn->query($query);
      if($result->num_rows> 0){
        while($optionData=$result->fetch_assoc()){
            $option =$optionData['subName'];
    ?>

        <label><?php echo $option; ?></label></label>
        <input type="checkbox" name="subjects[]" value="<?php echo $option; ?>">

    <?php
    }}
    ?>

        <input type="submit" name="submit" value="Submit">  

    </form>
    <?php

    //echo("Hello World 1");
    
    //variables to hold extracted data
    $pID = $pfname = $plname = $address = $phone = ""; //for parent info
    $sID = $sfname = $slname = $age = $subjects = ""; //for student info

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        //parent info
        $pID = test_input($_POST["pID"]);
        $pfname = test_input($_POST["pfName"]);
        $plname = test_input($_POST["plName"]);
        $address = test_input($_POST["pAddress"]);
        $phone = test_input($_POST["phone"]);

        //student info
        $sID = test_input($_POST["sID"]);
        $sfname = test_input($_POST["sfName"]);
        $slname = test_input($_POST["slName"]);
        $age = test_input($_POST["age"]);
        $subjects = test_input(implode(",",$_POST['subjects']));
       
    }

    //function to sanitize data
    function test_input($data){
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        
        return $data;
    }

    if(!preg_match('/[a-zA-Z]+/', $pfname)){
        echo "Invalid parent first name";
    }

    if(!preg_match('/[a-zA-Z]+/', $plname)){
        echo "Invalid parent last name";
    }

    if(!preg_match('/[a-zA-Z]+/', $sfname)){
        echo "Invalid student first name";
    }

    if(!preg_match('/[a-zA-Z]+/', $slname)){
        echo "Invalid student last name";
    }
    
    //require 'dbconnect.php';
    //$conn=connectDB(); 

    //inserting data into parent table
    $stmtP = $conn->prepare("INSERT INTO A2parent (parentID, firstName, lastName, paddress, phoneNum)VALUES(?, ?, ?, ?, ?)");


    $stmtP->bind_param("isssi", $temp_pID, $temp_pfname, $temp_plname, $temp_address, $temp_phone);

    $temp_pID = $pID;
    $temp_pfname = $pfname;
    $temp_plname = $plname;
    $temp_address = $address;
    $temp_phone = $phone;


    if($stmtP->execute()){	
        echo("record inserted");
    }else {
        echo "Error inserting record: " . $stmtP->error;  //print error message if any
    }

    $stmtP->close();
    
    //inserting data into student table
    $stmtS = $conn->prepare("INSERT INTO A2student (studentID, firstName, lastName, age, parentID)VALUES(?, ?, ?, ?, ?)");

    $stmtS->bind_param("issii", $temp_sID, $temp_sfname, $temp_slname, $temp_age, $temp_spID);

    $temp_sID = $sID;
    $temp_sfname = $sfname;
    $temp_slname = $slname;
    $temp_age = $age;
    $temp_spID = $pID;

    if($stmtS->execute()){	
        echo("record inserted");
    }else {
        echo "Error inserting record: " . $stmtS->error;  //print error message if any
    }

    $stmtS->close();

    //inserting data into student parent table
    $stmtSS = $conn->prepare("INSERT INTO A2studentSubject (studentID, subName)VALUES(?, ?)");

    $stmtSS->bind_param("is", $temp_ssID, $temp_subjects);

    $temp_ssID = $sID;
    $temp_subjects = $subjects;

    if($stmtSS->execute()){	
        echo("record inserted");
    }else {
        echo "Error inserting record: " . $stmtSS->error;  //print error message if any
    }

    $stmtSS->close();
    
    $conn->close();

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