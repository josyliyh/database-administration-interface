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
    </head>        <meta name="description" content="Come to Taiwan for the truly unique natural beauty.">

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
    $id = $database->real_escape_string($_GET['id']);


    $query = "SELECT id, firstname, lastname FROM students WHERE id='".$id."';";
    $result = $database->query($query);
    while(   $record = $result->fetch_assoc() ){
        $_SESSION['id'] = $id;
        $_SESSION['firstname'] = $record["firstname"];
        $_SESSION['lastname']= $record["lastname"];
        ?>
         <form action="processor.php" method="get" >
       
        <fieldset>
        <legend>Delete a record - Are you sure?</legend>
        <?php
        echo "<p> " . $record["id"] . " " . $record["firstname"] . " " . $record["lastname"] . "</p>" ;
        echo "<input type='radio' id='yes' name='delete' value='yes'>";
        echo "<label for='yes' name='delete'>Yes</label><br>";
        echo "<input type='radio' id='no' name='notdelete' value='no'>";
        echo "<label for='no'>No</label><br>";
        echo "<input type='submit' name='deleterecord' value='Submit'>"; 
        echo "</fieldset>";

     

    }	
}
   




   

//    $database->close();
   ?>	
   
</div>
</main>
</div>
<div class="site-footer">
<footer>
    <p>©Josy Li 2022</p>
</footer>
</div>
</body>
</html>