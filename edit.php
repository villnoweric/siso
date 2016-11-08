<?php require_once('functions/index.php');

if(logged_in() == false){
  header('Location: /login');
  die;
}

if(user_info('role') != 1 && !isset($_GET['referal'])){
  header('Location: /programs');
  die;
}

if(isset($_GET['referal'])){
  $user = user_info('ID');
}else{
  $user = $_GET['user'];
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
    <link href="<?= PATH ?>/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?= PATH ?>/css/dashboard.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="<?= PATH ?>/js/ie-emulation-modes-warning.js"></script>

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
                <li><a href="./">Back</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="<?= PATH ?>/login?action=logout">Logout</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <?php if(user_info('role') == 1){ ?>
          <ul class="nav nav-sidebar">
            <li><a href="<?= PATH ?>">Overview <span class="sr-only">(current)</span></a></li>
            <li class="active"><a href="<?= PATH ?>/admin/users">Users</a></li>
            <li><a href="<?= PATH ?>/admin/programs">Programs</a></li>
            <li><a href="<?= PATH ?>/admin/kiosks">Kiosks</a></li>
          </ul>
          <?php } ?>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <?php
            //user loop
            $sql = "SELECT * FROM " . PREFIX . "users WHERE ID='" . $user . "'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $array = unserialize($row['ACCESS']);
            ?>
          <h2 class="page-subheader"><?= $row['FULLNAME'] ?> <span class="pull-right"><small><?php if($row['ROLE'] != 1){ ?>Standard User<?php }else{ ?> Administrator <?php } ?></small></span></h2>
          <div class="table-responsive">
            <?php if(user_info('role') == 1){ ?>
            <?php if($row['ROLE'] == 0){ ?>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  
                  $sql2 = "SELECT * FROM " . PREFIX . "programs";
                  $result2 = $conn->query($sql2);
                  
                  if ($result2->num_rows > 0) {
                      // output data of each row
                      while($row2 = $result2->fetch_assoc()) {
                        
                        if(in_array($row2['ID'], $array)){
                          $button = "<a class='btn btn-danger' href='" . PATH . "/action.php?page=users&action=remove&content=" . $row2['ID'] . "&user=" . $user . "'>Remove</a>";
                        }else{
                          $button = "<a class='btn btn-success' href='" . PATH . "/action.php?page=users&action=add&content=" . $row2['ID'] . "&user=" . $user . "'>Add</a>";
                        }
                        
                        
                        if(!empty($row['kiosks'])){ $kiosks = implode(',', unserialize($row["kiosks"])); }else{ $kiosks = ''; }
                          echo "<tr><td>" . $row2["ID"]. "</td><td>" . $row2["name"]. "</td><td>" . $button . "</td></tr>";
                      }
                  } else {
                      echo "0 results";
                  }
                
                  
                  ?>
              </tbody>
            </table>
            <?php } ?>
          </div>
          <?php } ?>
          
          
          <h3>Password Reset</h3>
          <form action="<?= PATH ?>/action.php" class="form-group">
            <input type="hidden" name="user" value="<?= $user ?>">
            <input type="hidden" name="action" value="reset">
            <input type="hidden" name="page" value="users">
            <b>New Password:</b> <input class="form-control" type="password" name="content"><br>
            <input class="btn btn-danger" type="submit" value="Reset"/>
          </form>
          <?php if(user_info('role') == 1){ ?>
          <?php if(user_info('ID') != $user){ ?>
          <h3>Permissions</h3>
            <?php if($row['ROLE'] != 1){ ?><a href="<?= PATH ?>/action.php?page=users&action=makeadmin&content=<?= $row['ID'] ?>" class="btn btn-info">Make Administrator</a><?php }else{ ?><a href="<?= PATH ?>/action.php?page=users&action=removeadmin&content=<?= $row['ID'] ?>" class="btn btn-info">Make Standard User</a><?php } ?>
          <br><br><a href="<?= PATH ?>/action.php?page=users&action=delete&content=<?= $row['ID'] ?>" class="btn btn-danger">DELETE USER</a>
          <?php }else{ echo '<div class="alert alert-warning">You cannot change your own settings.</div>'; } } ?>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="<?= PATH ?>/js/bootstrap.min.js"></script>
  </body>
</html>
