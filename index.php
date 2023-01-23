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
     //see if there are messages to display
     if(isset($_SESSION['messages'])){    
         echo "<ul>";
         foreach($_SESSION['messages'] as $message){
             echo "<li>$message</li>";
         }
         echo "</ul>";

         //now that they'ev been displayed,
         //clear them from the session

        $_SESSION = array();
     }
     ?>           
<p><a href="add.php">Adding a student</a></p>

<?php
   
   
   //load database connectivity info
   require_once("dbinfo.php");
   
   //challenge 1
   //a default sort order setting:
   $sortOrder = "lastname"; 
   //a collection of acceptable sort choices
   $validChoices = array("id","firstname","lastname");//
   //see if the URL contains a sort choice
   if( isset($_GET['choice'] ) ){
       echo "<p>A sort choice was made </p>";	
       //make use the choice is acceptable	
       if( in_array($_GET['choice'], $validChoices) ){
           $sortOrder = $_GET['choice'];	
       }else{
           echo "<p>Hey you, '".$_GET['choice']."' is not a valid sort choice! Don't mess with the URL if you want this sort feature to work.</p>";
       }
   }else{
       echo "<p>A sort choice was NOT made. We'll use the default sort order by: '".$sortOrder."'</p>";	
   }
   
   //attempt db connection
   $database = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
   //if  mysqli_connect_errno() is zero no errors occured
   //any non zero means a problem
   if( mysqli_connect_errno() != 0  ){
       die("<p>Ack! Sorry, couldnt connect to DB</p>");	
   }
   
 
   /*
   challenge 2
   if an id was sent in the GET query string,
   use the id value to retrieve a record from the 
   database
   */
  if( isset($_GET['id']) ){
    $id = $database->real_escape_string($_GET['id']);
    $query = "SELECT id, firstname, lastname FROM students WHERE id='".$id."';";
    $result = $database->query($query);
    while(   $record = $result->fetch_assoc() ){
        echo "<fieldset>";
        echo "<legend>Student number " . $record["id"] . " was selected</legend>" ;
        echo "<p>Hello, " . $record["firstname"] . " " . $record["lastname"] . "!</p>" ;
        echo "</fieldset>";
    }	
}
   

  

   //IMPORTANT!
   //before we use external data in an SQL query, use: real_escape_string() 
   $sortOrder = $database->real_escape_string($sortOrder);
   
   //"SELECT * FROM tablename ORDER BY field;"
   $query = "SELECT id, firstname, lastname FROM students ORDER BY ".$sortOrder.";";
   
   $result = $database->query($query);
   echo "<table>";
   
   /*
   challenge 1
   output some hyperlinked table headings before
   displaying the table data.
   add a query string to the hrefs,
   to send data from one request to another
   */
   $fieldObjects = $result->fetch_fields();
   echo "<tr>";
   foreach($fieldObjects as $fieldObject){
       echo "<th><a href='index.php?choice=$fieldObject->name'><p>" .$fieldObject->name. "</p></a></th>" ;
   }
   echo "</tr>";
   while(   $record = $result->fetch_assoc() ){
       echo "<tr>";
       /*
       challenge 2
       output a clickable link for the studnet number
       the link will request this page when clicked,
       and will include a query string to identify which id was clicked
       */
      echo "<td>" . $record["id"] . "</td>" ;
      echo "<td>" . $record["firstname"] . "</td>" ;
       echo "<td>" . $record["lastname"] . "</td>" ;
       echo "<td><a href='delete.php?id=".$record["id"]."'> delete </a></td>" ;
       echo "<td><a href='update.php?id=".$record["id"]."'> update </a></td>" ;
       echo "</tr>";		
   }
   echo "</table>";

   $database->close();
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