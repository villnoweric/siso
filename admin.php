<?php require_once('functions/index.php');

if(!file_exists(__DIR__ . '/config/db.php')){
  header('Location: /oobe');
  die();
}

if(!file_exists(__DIR__ . '/config/district.php')){
  header('Location: /oobe');
  die();
}

if(logged_in() == false){
  header('Location: /login');
  die;
}

if(user_info('role') != 1){
  header('Location: /programs');
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
          <?php if(user_role() == 1){ ?>
          <ul class="nav nav-sidebar">
            <li<?php if(empty($_GET['page'])) { echo ' class="active"';} ?>><a href="/">Overview <span class="sr-only">(current)</span></a></li>
            <li<?php if($_GET['page']=='users') { echo ' class="active"';} ?>><a href="/admin/users">Users</a></li>
            <li<?php if($_GET['page']=='programs') { echo ' class="active"';} ?>><a href="/admin/programs">Programs</a></li>
            <li<?php if($_GET['page']=='kiosks') { echo ' class="active"';} ?>><a href="/admin/kiosks">Kiosks</a></li>
          </ul>
          <?php } ?>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <?php if(isset($_GET['page'])){ include_once(realpath($_SERVER['DOCUMENT_ROOT']) . '/templates/' . $_GET['page'] . '.php'); }else{ echo "TODO: Figgure out what to put here..."; } ?>
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
