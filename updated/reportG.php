<!DOCTYPE html>
<html lang="en">

  <head>
    <title>Tutor Registration</title>
    <meta charset=utf-8">
    <meta name="author" content="Dihutswane Mosieyane">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table{
            border: solid;
        }

    </style>
  </head>
  
  <body>
  
    <header>
    </header>
	
    <nav>
    </nav>
	
    <h1>Report G: Display the student’s weekly timetable, showing all the subjects taken by this student</h1>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="get">
	  
      <label for="fname">First Name</label>
	  <br>
	  <input type="text" id="fname" name="fname" required pattern="[A-Za-z]+" title="Name with at least 1 letter">
	  <br>

      <label for="lname">Last Name</label>
	  <br>
	  <input type="text" id="lname" name="lname" required pattern="[A-Za-z]+" title="Name with at least 1 letter">
	  <br>

      <input type="submit" value="Submit">

	</form>

    <table>
        <tr>
            <th>Time<th>
            <th>Monday<th>
            <th>Tuesday<th>
            <th>Wednesday<th>
            <th>Thursday<th>
            <th>Friday<th>
            <th>Saturday<th>
            <th>Sunday<th>
        </tr>
        <!--
        <tr>
            <td>Time<td>
            <td>Monday<td>
            <td>Tuesday<td>
            <td>Wednesday<td>
            <td>Thursday<td>
            <td>Friday<td>
            <td>Saturday<td>
            <td>Sunday<td>
        </tr>
        -->

    <?php

      $fname = $lname = "";

      if ($_SERVER["REQUEST_METHOD"] == "GET"){
        if (!empty($_GET["fname"])){
          $fname = test_input($_GET["fname"]);
        }
        else {
          $fname_err = "Name required";
        }
      }

      if (!empty($_GET["lname"])){
        $lname = test_input($_GET["lname"]);
      }
      else {
        $lname_err = "Last name required";
      }

      

      function test_input($data){

        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
      
      }

      if(preg_match("/[a-zA-Z]+/", $fname)){
        echo "Your name is valid";
      }
      else{
        echo "Error with your name";
      }

      if(preg_match("/[a-zA-Z]+/", $lname)){
        echo "Your last name is valid";
      }
      else{
        echo "Error with your last name";
      }

      require("dbconnect.php");

      $conn = connectDB();
      $result = $conn->prepare("SELECT A2studentSubject.subName, daysTaught, startTime, endTime FROM A2subjects INNER JOIN A2studentSubject ON A2studentSubject.subName=A2subjects.subName INNER JOIN A2student ON A2student.studentID=A2studentSubject.studentID where firstName = ? AND lastName = ?;");
      $result->bind_param("ss", $temp_fname, $temp_lname);

      $temp_fname = $fname;
      $temp_lname = $lname;

      $result->execute();

      $result->bind_result($col1, $col2, $col3, $col4);

      //$entryDays = array();
      $entries = array();

      while ($result->fetch()) {
        $subject = $col1;
        $days = (explode(",", $col2));
        $start = $col3;
        $end = $col4;

        $entries[$subject] = array($days, $start, $end);

        //$entryDays[$subject] = $days;
        //$entryStart[$subject] = $start;
        //$entryEnd[$subject] = $end;

        //var_dump($entryDays['History']);

        //echo($subject);
        //var_dump($days);
        //echo($start);
        //echo($end);

      }

      //var_dump($entryDays);
      //var_dump($entryDays['Mathematics']);
      //echo($entryStart['History']);
      //var_dump($entries);

      //for($i = 0; $i < 13; $i++) {

      ?>

        <tr>
            <td>08:00</td>

      <?php

        $mondayEntry = $tuesdayEntry = $wednesdayEntry = $thursdayEntry = $fridayEntry = $saturdayEntry = $fridayEntry = array();

        //var_dump($entries);

        foreach($entries as $x => $x_value) {
            for($i = 0; $i < count($entries); $i++)

              if($x_value[0][$i] == "Monday"){
                array_push($mondayEntry, $x);
              }
              else{
                array_push($mondayEntry, "");
              }

              if($x_value[0][$i] == "Tuesday"){
                array_push($tuesdayEntry, $x);
              }
              else{
                array_push($tuesdayEntry, "");
              }

              if($x_value[0][$i] == "Wednesday"){
                array_push($wednesdayEntry, $x);
              }
              else{
                array_push($wednesdayEntry, "");
              }

              if($x_value[0][$i] == "Thursday"){
                array_push($thursdayEntry, $x);
              }
              else{
                array_push($thursdayEntry, "");
              }

              if($x_value[0][$i] == "Friday"){
                array_push($fridayEntry, $x);
              }
              else{
                array_push($fridayEntry, "");
              }

              if($x_value[0][$i] == "Saturday"){
                array_push($saturdayEntry, $x);
              }
              else{
                array_push($saturdayEntry, "");
              }

              if($x_value[0][$i] == "Sunday"){
                array_push($sundayEntry, $x);
              }
              else{
                array_push($sundayEntry, "");
              }}

        //var_dump($mondayEntry);
        //var_dump($tuesdayEntry);
        var_dump($wednesdayEntry);

      ?>
<!--
      <td><?php
            //if (strtotime($x_value[1]) == strtotime('08:00:00')){
              //echo($x);

      ?>
      </tr>
-->

      
    
    </table>
	
    <footer>
    </footer>
	
  </body>
</html>