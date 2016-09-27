<?php

require_once('functions/index.php');

if(!isset($_GET['program'])){
    header('Location: ' . PATH . '/programs');
  die();
}

$program_sql = "SELECT * FROM " . PREFIX . "programs WHERE Name='" . str_replace("-"," ",$_GET['program']) . "'";
$program_result = $conn->query($program_sql);
$program = $program_result->fetch_assoc();
$program['settings'] = unserialize($program['settings']);

if(!isset($_GET['date'])){
  $date = date('Y-m-d');
  header('Location: ?date=' . $date); // figure this out
  die();
}else{
  $date = $_GET['date'];
  $todays_date = date('Y-m-d');
  if(strtotime($todays_date) == strtotime($date)){
    $istoday = true;
  }else{
    $istoday = false;
  }
}




header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=data.csv');

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

$array = array('Name', 'Date', 'Sign In', 'Sign Out');

if($program['settings']['duration'] == 1){
array_push($array, 'Durration (min)');
}

array_push($array, $program['settings']['desc_title']);

fputcsv($output, $array);

// fetch the data

$sql = "SELECT * FROM " . PREFIX . "data WHERE Program='" . $program['ID'] . "' AND (Signout LIKE '%$date%' OR Signin LIKE '%$date%') ORDER BY ID ASC";
$resultz = mysqli_query($conn,$sql);

// loop over the rows, outputting them
while($row = mysqli_fetch_array($resultz)) {
  $CheckIn = $row['Signin'];
  $CheckOut = $row['Signout'];
  
  if(is_null($CheckOut)){
      $Date = date('l, F j, Y', strtotime($CheckIn));
  }else{
      $Date = date('l, F j, Y', strtotime($CheckOut));
  }
  
  if(is_null($CheckIn)){
      $CheckIn = "---";
  }else{
      $CheckIn = date("g:i:s A", strtotime($CheckIn));
  }
  
  if(is_null($CheckOut)){
      $CheckOut = "---";
  }else{
      $CheckOut = date("g:i:s A", strtotime($CheckOut));
  }
  
  if(!is_null($CheckIn) && !is_null($CheckOut)){
      $total = round(abs(strtotime($CheckOut) - strtotime($CheckIn)) / 60,1);
  }else{
      $total = "---";
  }
  

  $array = array( $row['Name'], $Date, $CheckOut, $CheckIn);
  
  if($program['settings']['duration'] == 1){ 
  array_push($array, $total);
  }
  
  array_push($array,$row['Description']);
  
  fputcsv($output, $array);
}