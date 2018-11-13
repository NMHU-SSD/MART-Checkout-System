<?php
// NOTE: THIS SCRIPT IS FOR WINDOWS TASK SCHEDULER TO BE RAN
// NOTE: AT 4:45PM and 11:45AM EVERYDAY

//set time zone
date_default_timezone_set("America/Denver");
$host="localhost";    // host name
$username="root";   // mysql username
$password="root";   // mysql password
$db_name="mart_checkout";   // database name
$tbl_name="reservations";   // table name

// Pick up time
$pu=mktime(16, 45, 00);

if(date("g:i A") >  date("g:i A", $pu)){
  // connect to server, select database
  $connect = mysqli_connect($host, $username, $password, $db_name);

  /*check connection*/
  if(mysqli_connect_error()){
    printf("Connection failed: %s\n", mysqli_connect_error());
    exit();
  }

  //get appointment date
  $query = "SELECT * FROM $tbl_name";
  if($result = mysqli_query($connect, $query)){
    // date("m/d/Y g:i A") return string
    // returned value = 10/28/2018 1:40 AM
    $curr_date = date("Y/m/d g:i A");
    //default is mysqli_BOTH
    while($row = mysqli_fetch_array($result)){

      $barcode = $row['barcode'];
      $date_pickup = $row['date_pickup'];

      $d=strtotime($date_pickup);
      $compare_date = date("Y/m/d g:i A", $d);

      // TODO: once figured out change equipment back to available
      if($curr_date > $compare_date){
        // Change  reservations isDeleted to true and equipment status to aviable for checkout
        echo "Hide reservation and change equipment status<br>";
        // Upadte Equipment Status
        $sql = "UPDATE equipment SET status='available for checkout' WHERE barcode=$barcode";

        if ($connect->query($sql) === TRUE) {
          echo "Equipment updated successfully<br>";
        } else {
          echo "Error updating record: " . $connect->error. "<br>";
        }

        // Update Reservation isDeleted
        $sql2 = "UPDATE reservations SET isDeleted=1, isCheckedOut=0 WHERE barcode=$barcode";

        if ($connect->query($sql2) === TRUE) {
          echo "Reservation updated successfully<br>";
        } else {
          echo "Error updating record: " . $connect->error. "<br>";
        }

      }else{
        echo "Do Nothing<br>";
      }
    }
    mysqli_free_result($result);
  }
  mysqli_close($connect);
}else{
  echo "Dont Run Pick up Script<br>";
}


// Equipment due time
$ed=mktime(11, 45, 00);

// On Fridays equipment due monday
if(date("g:i A") >  date("g:i A", $ed)){
  // connect to server, select database
  $connect = mysqli_connect($host, $username, $password, $db_name);

  /*check connection*/
  if(mysqli_connect_error()){
    printf("Connection failed: %s\n", mysqli_connect_error());
    exit();
  }

  $tbl_name1="students";
  $tbl_name2="faculties";
  //get appointment date
  $query = "SELECT * FROM $tbl_name";
  $query2 = "SELECT * FROM $tbl_name1";
  $query3 = "SELECT * FROM $tbl_name2";

  echo '<br><br><br>';
  if($result = mysqli_query($connect, $query)){
    // date("m/d/Y g:i A") return string
    // returned value = 10/28/2018 1:40 AM
    $curr_date = date("Y/m/d g:i A");
    //default is mysqli_BOTH
    while($row = mysqli_fetch_array($result)){

      $barcode = $row['barcode'];
      $student_id = $row['student_id'];
      $date_due = $row['date_due'];

      $d=strtotime($date_due);
      $compare_date = date("Y/m/d g:i A", $d);

      // TODO: once figured out change equipment back to available
      if($curr_date > $compare_date){
        // Change  reservations isDeleted to true and equipment status to aviable for checkout
        echo "Add 5 Dollars and eligibnility to ineligible for student account and not to faculty <br>";
        echo 'Connect to student table and faculty table<br>';

        if($result2 = mysqli_query($connect, $query2)){
          while($row2 = mysqli_fetch_array($result2)){
            if($row2['clearance_level'] != "Faculty"){
              $sql = "UPDATE students SET amount_owed='5.00', eligibility = 'ineligible' WHERE banner_id=$student_id";

              if ($connect->query($sql) === TRUE) {
                echo "Equipment updated successfully<br>";
              } else {
                echo "Error updating record: " . $connect->error. "<br>";
              }
            }
          }
          mysqli_free_result($result2);
        }

        if($result3 = mysqli_query($connect, $query3)){
          while($row3 = mysqli_fetch_array($result3)){

            if($row2['clearance_level'] != "Faculty"){
              echo $row2['name']. "   ";
              echo $row2['clearance_level']. '<br>';
            }else{
              echo 'DO NOTHING TO FACULTY';
            }

            mysqli_free_result($result3);
          }

        }else{
          echo "Do Nothing<br>";
        }
      }
      mysqli_free_result($result);
    }
    mysqli_close($connect);

    echo "Run Equipment Due Script<br>";
  }else{
    echo "Dont Run  Equipment Due Script<br>";
  }
}

?>
