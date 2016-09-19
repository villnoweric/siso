<?php require_once('../functions/index.php'); ?>
<html lang="en">
  <head>
    <title>First Time Set Up</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <meta name="viewport" content="width=500px, height=200px, initial-scale=2, user-scalable = no">
    
    
    <link rel="icon" href="/favicon.ico">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="../css/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="../css/material.css" type="text/css" />
	<link rel="stylesheet" href="../css/style.css" type="text.css" />
	
	<link rel="manifest" href="manifest.json">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="../js/signature/jSignature.min.js"></script>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <style>
        h2{
            text-align: center;
            
        }
    </style>
  </head>
  <body ontouchmove="">
    <div id="wrap">
        <div class="container">
            
            <center>
                <h1>Getting Started</h1>
            </center>
            <div class="row">
                <div class="col-md-9">
                    <div class="well">
                        <h2>Complete</h2>
                        <p>
                            Welcome to: <?= DISTRICT_NAME; ?>
                            <form method="post" action="action.php">
                                
                            </form>
                        </p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="well">
                        <h2>Help</h2>
                        <p>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </body>
</html>