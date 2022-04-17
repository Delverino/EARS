<?php
$message = "";
$prompt = "";
$selectedOption = "";
$updatedVal = -1;
if(isset($_POST['prompt'])){ //check if form was submitted
  $prompt = $_POST['prompt'];
  $selectedOption = isset($_POST['option1']) ? "option1" : "option2";

  // establish connection info
  $server = "localhost";     // server
  $userid = "ucncqy2dvmrkb"; // user id
  $pw     = "cs20password123";   // password
  $db     = "dby43vspwn6jpn";     // database

  // Create connection
  $conn = new mysqli($server, $userid, $pw);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed!");
  }

  //select the database
  $conn->select_db($db);

  //run a query
  $sql = "SELECT option1, option2 FROM prompts WHERE prompt = ?";
  
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('s', $prompt); // 's' specifies the variable type => 'string'
  $stmt->execute();

  $result = $stmt->get_result();
  
//$result = $conn->query($sql);
  
  if ($result->num_rows == 0) 
    die($sql);
  
  $row = $result->fetch_assoc();
  
  $stat1 = ($row['option1'] == 1) ? "1 person" : (($row['option1'] == 0) ? "no one" : "{$row['option1']} people");
  $stat2 = ($row['option2'] == 1) ? "1 person" : (($row['option2'] == 0) ? "no one" : "{$row['option2']} people");

  if ($selectedOption == "option1") {
    $message = "Interesting - {$stat1} agreed with you, while {$stat2} disagreed and chose the other option.";
    $updatedVal = $row['option1'] + 1;
  } else {
    $message = "Interesting - {$stat2} agreed with you, while {$stat1} disagreed and chose the other option.";
    $updatedVal = $row['option2'] + 1;
  }
  
  $sql = "UPDATE prompts SET $selectedOption = $updatedVal WHERE prompt = ?";
  
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('s', $prompt); // 's' specifies the variable type => 'string'
  $stmt->execute();

  // if ($conn->query($sql) === FALSE) {
  //   echo "<script>console.log('Error: order updating database')</script>";
  // } else {
  //   echo "<script>console.log('Success!')</script>";
  // }

  //close the connection	
  $conn->close();


}    




?>