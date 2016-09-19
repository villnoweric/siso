<?php session_start(); ?>
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
                <h1>Install</h1>
                <ol class="breadcrumb">
                  <li class="active">General</li>
                  <li>Accounts</li>
                </ol>
            </center>
            <div class="row">
                <div class="col-md-9">
                    <div class="well">
                        <h2>General</h2>
                        <p>
                            <form method="post" action="action.php">
                                <input type="hidden" name="install_step" value="general"/>
                                <div class="form-group col-md-6">
                                    <label>District Name</label>
                                    <input type="text" class="form-control" name="district_name" value="<?php if(isset($_SESSION['district_name'])){ echo $_SESSION['district_name']; } ?>">
                                </div>
                                <div class="form-group  col-md-6">
                                    <label>Timezone</label>
                                    <select class="form-control" name="timezone">
                                      <option value="America/Chicago">America/Chicago</option>
                                    </select>
                                </div>
                                <div class="clearfix">
                                    <a class="pull-left btn btn-raised disabled">Previous Step</a><button type="submit" class="pull-right btn btn-raised">Next Step</button>
                                </div>
                            </form>
                        </p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="well">
                        <h2>Help</h2>
                        <p>
                            <b>District Name</b><br>
                            <b>Time Zone</b>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </body>
</html>