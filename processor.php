<?php
session_start();
//load database connectivity info
require_once("dbinfo.php");
$messages = array();
const STUDENT_NUM_PATTERN = "/^a0[0-9]{7}$/i";
   
//attempt db connection
$database = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
//if  mysqli_connect_errno() is zero no errors occured
//any non zero means a problem
if( mysqli_connect_errno() != 0  ){
    die("<p>Ack! Sorry, couldnt connect to DB</p>");	
}



    if (isset($_GET['deleterecord'])){
      $id = $_SESSION['id'];
      $firstname = $_SESSION['firstname'];
      $lastname = $_SESSION['lastname'];

      if (isset($_GET['delete'])){
        $query = "DELETE FROM students WHERE id='".$_SESSION['id']."';"; 
        $result = $database->query($query);
        if($result == true){
          $messages[] = "Record of $id $firstname $lastname is removed" ;

        }else{
          $messages[] = "The record could not be deleted as requested" ;
        }
      } else {
      $messages[] = "Record of $id $firstname $lastname is not removed" ;
      }
    }


    if (isset($_GET['update'])){
      $oldId = $_SESSION['id'];
      $oldFirstname = $_SESSION['firstname'];
      $oldLastname = $_SESSION['lastname'];


      $newid = trim($_GET['newid']);
      $newfname = trim($_GET['newfirstname']);
      $newlname = trim($_GET['newlastname']);
      if (empty( $newid )) {
          $messages[] = "Please fill in student number" ;
      } 
      if (empty( $newfname )) {
          $messages[] = "Please fill in first name" ;
      } 
      if (empty( $newlname )) {
          $messages[] = "Please fill in last name" ;
      } 
      if (preg_match( STUDENT_NUM_PATTERN, $newid) !== 1 ){
          $messages[] =  "Student number pattern should look like 'A0nnnnnnn'";		
      }
    
      if (COUNT ($messages) ==  0) {
      $editquery = "UPDATE students SET id = '$newid', firstname='$newfname', lastname='$newlname' WHERE id='".$_SESSION['id']."';"; 
      $result = $database->query($editquery);
      
        if($result == true){
          $messages[] = "Record of $oldId $oldFirstname $oldLastname is updated" ;
        }else{
          $messages[] = "Record of $oldId $oldFirstname $oldLastname could not be updated as requested" ;
          $messages[] = "Please choose another student number" ;
        }
      } else {
      $messages[] = "Record of $oldId $oldFirstname $oldLastname could not be updated as requested" ;
      }
    }
  

    if (isset($_GET['add'])){

    $studentnumber = trim($_GET['studentnumber']);
    $firstname = trim($_GET['firstname']);
    $lastname = trim($_GET['lastname']);

    if (empty( $studentnumber)) {
      $messages[] = "Please fill in student number" ;
    } 
    if (empty( $firstname )) {
        $messages[] = "Please fill in first name" ;
    } 
    if (empty( $lastname)) {
          $messages[] = "Please fill in last name" ;
    } 
    if (preg_match( STUDENT_NUM_PATTERN, $studentnumber) !== 1 ){
            $messages[] =  "Student number pattern should look like 'A0nnnnnnn'";		
    }
    
    
      if (COUNT ($messages) ==  0) {

        $addquery = "INSERT INTO students (id, firstname, lastname) VALUES ('$studentnumber', '$firstname', '$lastname');"; 
        $result = $database->query($addquery);
        if($result == true){
          $messages[] = "New record of  $studentnumber $firstname $lastname is added" ;
        } else {
          $messages[] = "Please choose another student number" ;
          $messages[] = "The record could not be added as requested" ;
        }
      } else {
        $messages[] = "The record could not be added as requested" ;
      }
    }

    $_SESSION['messages'] = $messages;
    header("location: index.php");
    
?>