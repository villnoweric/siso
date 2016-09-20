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
                  <li class="active">Server Configuration</li>
                  <li>General</li>
                  <li>Accounts</li>
                </ol>
            </center>
            <div class="row">
                <div class="col-md-9">
                    <div class="well">
                        <h2>Database</h2>
                        <p>
                            <form method="post" action="action.php">
                                <input type="hidden" name="install_step" value="db">
                                <div class="form-group">
                                    <label for="district_input">Server Name</label>
                                    <input type="text" class="form-control" name="db_server">
                                </div>
                                <div class="form-group">
                                    <label for="district_input">Username</label>
                                    <input type="text" class="form-control" name="db_user">
                                </div>
                                <div class="form-group">
                                    <label for="district_input">Password</label>
                                    <input type="text" class="form-control" name="db_pass">
                                </div>
                                <div class="form-group">
                                    <label for="district_input">Database</label>
                                    <input type="text" class="form-control" name="db_db">
                                </div>
                                <div class="form-group">
                                    <label for="district_input">Table Prefix</label>
                                    <input type="text" class="form-control" name="db_prefix">
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
                            <b>Server Name</b><br>
                            This is the address pf the Database. A common one is localhost.
                        </p>
                        <p>
                            <b>Table Prefix</b><br>
                            This is a prefix added to the tables to seperate them from other conflicting tables if there are any.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </body>
</html>