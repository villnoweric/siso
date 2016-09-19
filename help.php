<?php require_once('functions/index.php');

if(logged_in() == false){
  header('Location: /login');
  die;
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= DISTRICT_NAME ?></title>
    
    

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/dashboard.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><?= DISTRICT_NAME ?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Welcome <?= user_info('fullname'); ?> <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="/help">Help</a></li>
                <li><a href="/admin/updates">Updates</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="/login?action=logout">Logout</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
           <ul>
             <li>Installation</li>
           </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h2 class="sub-header">Siso Help</h2>
          <h3>Updates</h3>
          It is recomended that you backup your users, programs, kiosks, and data before running an update, just in case something goes wrong during the update process. Because there are many different database managers, you'll have to look up how to backup on your own.
          <h3>Users</h3>
          <h4>Create new user</h4>
          On the users page, at the bottom, there is 3 lines. Name, Username, and Email. Fill these out with your users data, and click create. In order for them to log in, you will have to reset there password. For more information on password reset, see below.
          <h4>Editing</h4>
          <h5>Managing Program Access</h5>
          Click on the "Edit" button next to the users name. On the edit page, you can click to Add/Remove access from a user. Keep in mind Administrators have access to all programs regardless if they have access or not.
          <h5>Password Reset</h5>
          At the bottom of the edit page, enter in the new password and click reset. [BUG password in plain text]. The user can log in with this password, and reset it from there account settings.
          <h3>Programs</h3>
          <h4>Create new program</h4>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
  </body>
</html>
