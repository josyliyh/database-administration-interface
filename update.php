<?php
        $stylesheet = "css/josystyle.css";
   
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/normalize.css"> 

        <link rel="stylesheet" href="css/fonts.css"> 
        <link rel="stylesheet" href="css/green.css"> 
        <link rel="stylesheet" href="css/josystyle.css"> 
                <title>Assignment</title>
    </head>
<body>


<main>             
  

<?php
session_start();

   
   //load database connectivity info
   require_once("dbinfo.php");
   
 //attempt db connection
 $database = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
 //if  mysqli_connect_errno() is zero no errors occured
 //any non zero means a problem
 if( mysqli_connect_errno() != 0  ){
     die("<p>Ack! Sorry, couldnt connect to DB</p>");	
 }
 

  if( isset($_GET['id']) ){
    $_SESSION['id'] = $_GET['id'];
    $id = $database->real_escape_string($_GET['id']);
    $query = "SELECT id, firstname, lastname FROM students WHERE id='".$id."';";
    $result = $database->query($query);
    while(   $record = $result->fetch_assoc() ){
        $_SESSION['firstname'] = $record["firstname"];
        $_SESSION['lastname']= $record["lastname"];
        ?>
         <form action="processor.php" method="get" >
       
        <fieldset>
        <legend>Update a record</legend>
        <?php
        echo "<p> " . $record["id"] . " " . $record["firstname"] . " " . $record["lastname"] . "</p>" ;
        echo "<input type='text' id='studentnumber' name='newid' value='" . $record["id"] ."'>";
        echo "<label for='studentnumber'> Studentnumber</label><br>";
        echo "<input type='text' id='firstname' name='newfirstname' value='" . $record["firstname"] ."'>";
        echo "<label for='firstname'> Firstname</label><br>";
        echo "<input type='text' id='lastname' name='newlastname' value='" . $record["lastname"] ."'>";
        echo "<label for='lastname'> Lastname</label><br>";
        echo "<input type='submit' name='update' value='Submit'>"; 
        echo "</fieldset>";
        echo "</form>";

     

    }	
}
   


   

//    $database->close();
   ?>	
   
</div>
</main>
</div>
<div class="site-footer">
<footer>
    <p>??Josy Li 2022</p>
</footer>
</div>
</body>
</html>