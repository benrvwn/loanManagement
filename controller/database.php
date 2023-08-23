<?php

$host = "localhost";
$hostname = "root";
$password = "";
$database = "loan_management";
$port = 3307;

$conn = new mysqli($host, $hostname, $password, $database, $port);

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}


function fetch_all($query)
{
  $data = array();
  global $conn;
  $result = $conn->query($query);
  while($row = mysqli_fetch_assoc($result)) 
  {
    $data[] = $row;
  }
  return $data;
}
//SELECT - used when expecting a single result
//returns an associative array
function fetch_record($query)
{
  global $conn;
  $result = $conn->query($query);
  return mysqli_fetch_assoc($result);
}
//used to run INSERT/DELETE/UPDATE, queries that don't return a value
//returns a value, the id of the most recently inserted record in your database
function run_mysql_query($query)
{
  global $conn;
  $result = $conn->query($query);
  return $conn->insert_id;
}
//returns an escaped string. EG, the string "That's crazy!" will be returned as "That\'s crazy!"
//also helps secure your database against SQL injection
function escape_this_string($string)
{
  global $conn;
  return $conn->real_escape_string($string);
}


?>