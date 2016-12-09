<?php require_once('functions/index.php');

    $program_sql = "SELECT * FROM " . PREFIX . "programs WHERE Name='" . str_replace("-"," ",$_GET['program']) . "'";
    $program_result = $conn->query($program_sql);
    $program = $program_result->fetch_assoc();
    $program['settings'] = unserialize($program['settings']);
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <meta name="viewport" content="width=500px, height=200px, initial-scale=2, user-scalable = no">
    <script>
    
    function navigator_Go(url) {
        window.location.assign(url); // This technique is almost exactly the same as a full <a> page refresh, but it prevents Mobile Safari from jumping out of full-screen mode
    }
    </script>
    
    <link rel="icon" href="/favicon.ico">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="<?= PATH ?>/css/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="<?= PATH ?>/css/material.css" type="text/css" />
	<link rel="stylesheet" href="<?= PATH ?>/css/style.css" type="text.css" />
	
	<link rel="manifest" href="manifest.json">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="<?= PATH ?>/js/signature/jSignature.min.js"></script>
    <script>
    
    function navigator_Go(url) {
        window.location.assign(url); // This technique is almost exactly the same as a full <a> page refresh, but it prevents Mobile Safari from jumping out of full-screen mode
    }
    </script>
    <?php if($program['settings']['other_only']){ ?>
	    <script>
	        $( document ).ready(function() {
	            var element=document.getElementById('inputReason');
	            var select=document.getElementById('select');
	            select.style.display='none';
	            element.style.display='block';
	        });
	    </script>
    <?php }else{ ?>
        <script type="text/javascript">
        function CheckColors(val){
         var element=document.getElementById('inputReason');
         if(val=='Other')
           element.style.display='block';
         else  
           element.style.display='none';
        }
        </script>
    <?php } ?>
    <script>
    
    function blockMove() {
        event.preventDefault() ;
    }
    
    
    $( document ).ready(function() {
        $(".alert").delay(3000).fadeOut(1000);
        $("#alert").delay(4000).animate({height: "0px"}, 1000);
        
        $("#signature").jSignature('init');
    });
    
    
    
    </script> 
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
  </head>
  <body ontouchmove="blockMove()">
    <div id="wrap">
        <div class="container">
            <form class="form-signin" method="post" action="../frontaction.php">
                <?php if(isset($_GET['m'])){ ?><div id="alert">
                        <?php
                        switch ($_GET['m']) {
                            case 2:
                                echo "<div class='alert alert-dismissable alert-success'>You have Succsessfuly Checked In";
                                break;
                            case 3:
                                echo "<div class='alert alert-dismissable alert-danger'>You have Succsessfuly Checked Out";
                                break;
                            case 4:
                                echo "<div class='alert alert-dismissable alert-danger'>You are required to enter a Name";
                                break;
                            case 5:
                                echo "<div class='alert alert-dismissable alert-danger'>You are required to select a Reason";
                                break;
                            case 6:
                                echo "<div class='alert alert-dismissable alert-danger'>You need to Sign Out First";
                                break;
                            case 7:
                                echo "<div class='alert alert-dismissable alert-danger'>You need to Sign In first";
                                break;
                            case 8:
                                echo "<div class='alert alert-dismissable alert-danger'>You have already signed in.";
                                break;
                            case 9:
                                echo "<div class='alert alert-dismissable alert-danger'>You have already been here today.";
                                break;
                            case 10:
                                echo "<div class='alert alert-dismissable alert-danger'>You have already signed out.";
                                break;
                            case 69:
                                echo "<div class='alert alert-dismissable alert-danger'>FATAL: There was a Fatal Error (code:" . $_GET['c'] . ") contact support.";
                        }
                        
                        ?>
                    </div>
                </div><?php }; ?>
                <div class="row">
                    <h2 class="form-signin-heading"><center><a href="javascript:navigator_Go('./')"><?= $program['name']; ?></a></center></h2>
                </div>
                &nbsp;
                <div class="form-group">
                    <input type="hidden" name="program" value="<?= $program['ID']; ?>">
                    <input type="hidden" name="redirect" value="<?= $_GET['program']; ?>">
                        <input type="text" name="Name" class="form-control" id="inputName" placeholder="Name" autocomplete="off" style="text-transform: capitalize" autocorrect="off">
                </div>
                <div class="form-group">
                    <select class="form-control" name="Reason" id="select" onchange='CheckColors(this.value);'>
                        <option <?php if(!$program['settings']['other_only']){ echo 'selected '; } ?>disabled>Select a <?= $program['settings']['desc_title']; ?></option>
                        <?php
                            foreach($program['settings']['descs'] as $value){
                                echo "<option>" . $value . "</option>";
                            }
                        if($program['settings']['other'] == 1){
                            if($program['settings']['other_only']){ 
                                echo '<option selected>Other</option>';
                            }else{
                                echo '<option>Other</option>';
                            }
                        }
                        
                        ?>
                    </select>
                </div>
                <div class="form-group">
                        <input type="text" name="otherReason" class="form-control" id="inputReason" placeholder="<?php if(!$program['settings']['other_only']){ echo 'Other'; } ?> <?= $program['settings']['desc_title']; ?>" autocomplete="off">
                </div>
                
                <?php if($program['settings']['signature']){ ?><div id="signature"></div><?php } ?>
                
                <div class="form-group">
                    <div class="col-xs-6"><center><button type="submit" name="task" value="in" class="btn btn-success btn-lg" data-toggle="modal" data-target="#Lodal">Check In</button></center></div>
                    <div class="col-xs-6"><center><button name="task" type="submit" value="out"class="btn btn-danger btn-lg" data-toggle="modal" data-target="#Lodal">Check Out</a></center></div>
                </div>
            </form>
            
            
        </div>
	</div>
	<div id="push"><center>&copy Eric Villnow and GSL Technology Dept.</center></div>
	
	<!--<div id="footer">
       <div class="container">
        <p class="muted credit">&copy; <?php echo date('Y'); ?> Eric Villnow and Glencoe-Silver Lake Schools.</p>
      </div>
    </div>-->
    
    
    <div id="Lodal" class="modal" tabindex="-1" role="fullscreen" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="modal-fullscreen">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title" id="myModalLabel"><center>Loading</center></h2>
          </div>
          <div class="modal-body">
            <center><img height="100px" src="ajax-loader.gif"></center>
          </div>
        </div>
      </div>
    </div>
    
    
	<script src="<?= PATH ?>/js/bootstrap.js"></script>
	<script src="<?= PATH ?>/js/material.js"></script>
  </body>
</html>