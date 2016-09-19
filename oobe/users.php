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
                  <li><a href="index.php">General</a></li>
                  <li class="active">Accounts</li>
                </ol>
            </center>
            <div class="row">
                <div class="col-md-9">
                    <div class="well">
                        <h2>Accounts</h2>
                        <p>
                            <form method="post" action="action.php">
                                <input type="hidden" name="install_step" value="users"/>
                                <h3>Administrator</h3>
                                <div class="form-group col-md-6">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="admin_name" value="<?php if(isset($_SESSION['admin_name'])){ echo $_SESSION['admin_name']; } ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Username</label>
                                    <input type="text" class="form-control" name="admin_username" value="<?php if(isset($_SESSION['admin_username'])){ echo $_SESSION['admin_username']; } ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="admin_password">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>E-Mail</label>
                                    <input type="email" class="form-control" name="admin_email" value="<?php if(isset($_SESSION['admin_email'])){ echo $_SESSION['admin_email']; } ?>">
                                </div>
                                <div class="clearfix">
                                    <a href="index.php" class="pull-left btn btn-raised">Previous Step</a><button type="submit" class="pull-right btn btn-raised">Next Step</button>
                                </div>
                            </form>
                        </p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="well">
                        <h2>Help</h2>
                        <p>
                            <b>Administrator</b> Here you will set up the administrative account. If you need more than one administrative account, you can set them up later.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </body>
</html>