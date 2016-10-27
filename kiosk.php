<?php

require_once('functions/index.php');

if(isset($_GET['register'])){
    if(empty($_GET['name'])){
         header('Location: ' . PATH . '/kiosk?error=1');
    }else{
    $name = addslashes($_GET['name']);
    $id = rand(1111, 9999);
    $time = $_GET['register'];
    $expire = time()+60*60*24*30*$time;
    $sql="SELECT * FROM " . PREFIX . "kiosks WHERE apid=" . $id;
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result) > 0){
        header('Location: /kiosk?register=' . $time);
    }
    $sql = "INSERT INTO " . PREFIX . "kiosks (apid, name, expire)
    VALUES ('" . $id . "', '" . $name . "', '" . $expire . "')";

    if ($conn->query($sql) === TRUE) {
        setcookie('KIOSK_ID', $id, $expire);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        die();
    }
    
    header('Location: ' . PATH . '/kiosk');
    }
}
if(isset($_GET['unregister'])){
  
    $cookie = $_COOKIE['KIOSK_ID'];
    
    $sql="SELECT * FROM " . PREFIX . "kiosks WHERE apid=" . $cookie;
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result) > 0){
  
        $sql = "DELETE FROM " . PREFIX . "kiosks WHERE apid=" . $cookie;
      
        if ($conn->query($sql) === TRUE) {
            setcookie('KIOSK_ID', null, -1);
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            die();
        }
    }else{
      setcookie('KIOSK_ID', null, -1);
    }

    header('Location: /kiosk');
}

if(isset($_COOKIE['KIOSK_ID'])){

    $sql="SELECT * FROM " . PREFIX . "kiosks WHERE apid=" . $_COOKIE['KIOSK_ID'];
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result) == 0){
        header('Location: ./kiosk?unregister=1');
    }
    
}

if(!isset($_COOKIE['KIOSK_ID'])){
    
    $body = '<form method="get"><div class="form-group">
    <div class="col-md-4">
          <label for="sel1">Friendly Name</label>
          <input class="form-control" type="text" name="name">
          <label for="sel1">Registration Time (months)</label>
          <select class="form-control" id="sel1" name="register">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
          </select><br>
          <input type="submit" value="Register" class="btn">
        </div></div></form>';
    
    if(isset($_GET['error'])){
        $body = '<div class="alert alert-danger" role="alert">You need to have a Friendly Name</div>' . $body;
    }
    
    $title = "Device Not Registered";
}else{
    $title =  DISTRICT_NAME . "<div class='pull-right'>" . $_COOKIE['KIOSK_ID'] . "</div>";
    $body = "<a href=\"javascript:navigator_Go('" . PATH . "/kiosk')\" class='btn btn-success'>Refresh</a><br><br>";
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="/ic_launcher.png">
    <?php if(isset($_COOKIE['KIOSK_ID'])){ ?><!--<meta http-equiv="refresh" content="3">--><?php } ?>

    <title><?= DISTRICT_NAME ?> Kiosk</title>

    <!-- Bootstrap core CSS -->
    <link href="<?= PATH ?>/css/bootstrap.min.css" rel="stylesheet">

    <script>
    
    function navigator_Go(url) {
        window.location.assign(url); // This technique is almost exactly the same as a full <a> page refresh, but it prevents Mobile Safari from jumping out of full-screen mode
    }
    
    function blockMove() {
        event.preventDefault() ;
    }
    </script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
  </head>

  <body>

    <!-- Begin page content -->
    <div class="container">
      <div class="page-header">
        <h1><?= $title ?></h1>
      </div>
      <p class="lead"><?= $body ?>
      
      <?php
        if(isset($_COOKIE['KIOSK_ID'])){
        $sql = "SELECT * FROM " . PREFIX . "programs WHERE kiosks LIKE '%" . $_COOKIE['KIOSK_ID'] . "%'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            // output data of each row
            echo 'Enlisted Programs';
            echo '<div class="list-group">';
            while($row = $result->fetch_assoc()) {
                echo '<a href="javascript:navigator_Go(\'' . PATH . '/kiosk/' . str_replace(" ","-",$row['name']) . '\')" class="list-group-item">' . $row['name'] . '</a>';
            }
        }else{
        }
      } ?>
      </div>
      </p>
    </div>

  </body>
</html>
